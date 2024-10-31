<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\Tag;
use App\Models\Writer;
use App\Models\Province;
use App\Enums\ContentTypes;
use App\Enums\SubjectTypes;
use App\Models\TagsContent;
use App\Models\ContentMedia;
use Illuminate\Http\Request;
use App\Services\SaveFileService;
use App\DataTables\ContentDataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ContentRepository;
use App\Factories\ContentServiceFactory;
use App\Repositories\PageTypeRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateContentRequest;
use App\Http\Requests\UpdateContentRequest;


class ContentController extends AppBaseController
{
    private string $filePath = 'contents';

    private array $contentTypes = [];
    /** @var  ContentRepository */
    private $contentRepository;

    public function __construct(
        ContentRepository $contentRepo,
        private PageTypeRepository $pageTypeRepository,
        private SaveFileService $saveFileService,
        private ContentServiceFactory $contentService
    )
    {
        $this->middleware('auth');
        $this->middleware('can:content-edit', ['only' => ['edit']]);
        $this->middleware('can:content-store', ['only' => ['store']]);
        $this->middleware('can:content-show', ['only' => ['show']]);
        $this->middleware('can:content-update', ['only' => ['update']]);
        $this->middleware('can:content-delete', ['only' => ['delete']]);
        $this->middleware('can:content-create', ['only' => ['create']]);
        $this->contentRepository = $contentRepo;
        foreach (ContentTypes::cases() as $contentType) {
            $this->contentTypes[] = $contentType->slug();
        }
    }

    /**
     * Display a listing of the Content.
     *
     * @param ContentDataTable $contentDataTable
     * @return Response
     */
    public function index(string $contentTypeSlug)
    {
        if (!in_array($contentTypeSlug,$this->contentTypes)) {
            abort(404);
        }

        $typeId = ContentTypes::getValueFromSlug($contentTypeSlug);

        return (new ContentDataTable($typeId))->render('contents.index',compact('typeId'));
    }

    /**
     * Show the form for creating a new Content.
     *
     * @return Response
     */
    public function create(string $contentTypeSlug)
    {
        if (!in_array($contentTypeSlug,$this->contentTypes)) {
            abort(404);
        }

        $typeId = ContentTypes::getValueFromSlug($contentTypeSlug);

        $subjectTypes = Tag::select(['id','title','category_id'])
                        ->whereIn('category_id',SubjectTypes::getValues())
                        ->orderBy('category_id')
                        ->get();

        if (count($subjectTypes) <= 0) {
            $subjectTypes = [
                SubjectTypes::TOKOH->value => [],
                SubjectTypes::TOPIK->value => [],
                SubjectTypes::OTONOMIDAERAH->value => []
            ];
        }else{
            $subjectTypes = $subjectTypes->groupBy('category_id');
        }


        $provinces = Province::with('cities')->get();

        $writers = Writer::all();

        $contentType = ContentTypes::tryFrom($typeId)->title();

        return view('contents.create',compact('typeId','subjectTypes','contentType','provinces','writers'));
    }

    /**
     * Store a newly created Content in storage.
     *
     * @param CreateContentRequest $request
     *
     * @return Response
     */
    public function store(CreateContentRequest $request)
    {
        $input = $request->all();

        $content = $this->contentService->create($input);

        Flash::success('Content saved successfully.');
        return redirect(route('contents.index',ContentTypes::tryFrom($content->page_type_id)->slug()));
    }

    /**
     * Display the specified Content.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $content = $this->contentRepository->findWithoutFail($id);

        if (empty($content)) {
            Flash::error('Content not found');
            return redirect()->back();
        }

        return view('contents.show')->with('content', $content);
    }

    /**
     * Show the form for editing the specified Content.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $content = $this->contentRepository->with(['tags'])->findWithoutFail($id);

        if (empty($content)) {
            Flash::error('Content not found');
            return redirect()->back();
        }

        $subjectTypes = Tag::select(['id','title','category_id'])
                        ->whereIn('category_id',SubjectTypes::getValues())
                        ->orderBy('category_id')
                        ->get();

        if (count($subjectTypes) <= 0) {
            $subjectTypes = [
                SubjectTypes::TOKOH->value => [],
                SubjectTypes::TOPIK->value => [],
                SubjectTypes::OTONOMIDAERAH->value => []
            ];
        }else{
            $subjectTypes = $subjectTypes->groupBy('category_id');
        }

        $typeId = $content->page_type_id;

        $provinces = Province::with('cities')->get();

        $contentType = ContentTypes::tryFrom($typeId)->title();

        $writers = Writer::all();

        $tags = $content->tags()->get()->groupBy('category_id')->toArray();
        $contentTags = [];

        foreach (SubjectTypes::getValues() as $categoryId) {
            if (key_exists($categoryId,$tags)) {
                $contentTags[$categoryId] = $tags[$categoryId][0]['id'];
            }
        }

        $content->tags = $contentTags;
        $content->unsetRelation('tags');

        return view('contents.edit',compact('subjectTypes','typeId','provinces','contentType','content','writers'));
    }

    /**
     * Update the specified Content in storage.
     *
     * @param  int              $id
     * @param UpdateContentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContentRequest $request)
    {
        $content = $this->contentRepository->findWithoutFail($id);

        if (empty($content)) {
            Flash::error('Content not found');
            return redirect(route('contents.index'));
        }

        $input = $request->all();

        $this->contentService->update($content,$input);

        Flash::success('Content updated successfully.');
        return redirect(route('contents.index',ContentTypes::tryFrom($content->page_type_id)->slug()));
    }

    /**
     * Remove the specified Content from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $content = $this->contentRepository->findWithoutFail($id);

        if (empty($content)) {
            Flash::error('Content not found');
            return redirect(route('contents.index'));
        }

        $slug = ContentTypes::tryFrom($content->page_type_id)->slug();
        $this->contentRepository->delete($id);

        Flash::success('Content deleted successfully.');
        return redirect(route('contents.index',$slug));
    }

    /**
     * Store data Content from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $content = $this->contentRepository->create($item->toArray());
            });
        });

        Flash::success('Content saved successfully.');
        return redirect(route('contents.index'));
    }

    public function deleteMedia(int $id)
    {
        $media = ContentMedia::find($id);

        if (!$media) {
            return response()->json([
                'message' => 'data not found'
            ],404);
        }

        $media->delete();

        return response()->json([
            'message' => 'succces'
        ],200);
    }
}
