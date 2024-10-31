<?php

namespace App\Http\Controllers;

use App\DataTables\TagDataTable;
use App\Enums\SubjectTypes;
use App\Http\Requests;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Repositories\TagRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\TagsContent;
use App\Services\SaveFileService;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TagController extends AppBaseController
{
    private string $filePath = 'tag-icons';
    /** @var  TagRepository */
    private $tagRepository;
    private $iconPath = 'icons/tags';

    public function __construct(
        TagRepository $tagRepo,
        private SaveFileService $saveFileService
    )
    {
        $this->middleware('auth');
        $this->middleware('can:tag-edit', ['only' => ['edit']]);
        $this->middleware('can:tag-store', ['only' => ['store']]);
        $this->middleware('can:tag-show', ['only' => ['show']]);
        $this->middleware('can:tag-update', ['only' => ['update']]);
        $this->middleware('can:tag-delete', ['only' => ['delete']]);
        $this->middleware('can:tag-create', ['only' => ['create']]);
        $this->tagRepository = $tagRepo;
        $this->saveFileService->setStorage($this->filePath);
    }

    /**
     * Display a listing of the Tag.
     *
     * @param TagDataTable $tagDataTable
     * @return Response
     */
    public function index(TagDataTable $tagDataTable)
    {
        return $tagDataTable->render('tags.index');
    }

    /**
     * Show the form for creating a new Tag.
     *
     * @return Response
     */
    public function create()
    {
        $subjectTypes = SubjectTypes::cases();

        return view('tags.create',compact('subjectTypes'));
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param CreateTagRequest $request
     *
     * @return Response
     */
    public function store(CreateTagRequest $request)
    {
        $input = $request->all();

        // $input['icon'] = $this->saveFileService->setImage($request->icon)->handle();

        $tag = $this->tagRepository->create($input);

        $tag->icon()->create([
            'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setStorage($this->iconPath)->handle(),
            'color' => 'blue'
        ]);

        $tag->icon()->create([
            'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setStorage($this->iconPath)->handle(),
            'color' => 'green'
        ]);

        Flash::success('Tag saved successfully.');
        return redirect(route('tags.index'));
    }

    /**
     * Display the specified Tag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tag = $this->tagRepository->findWithoutFail($id);

        if (empty($tag)) {
            Flash::error('Tag not found');
            return redirect(route('tags.index'));
        }

        return view('tags.show')->with('tag', $tag);
    }

    /**
     * Show the form for editing the specified Tag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $tag = $this->tagRepository->findWithoutFail($id);

        if (empty($tag)) {
            Flash::error('Tag not found');
            return redirect(route('tags.index'));
        }

        $subjectTypes = SubjectTypes::cases();

        return view('tags.edit',compact('tag','subjectTypes'))
            ->with('blue_icon', $tag->blue())
            ->with('green_icon', $tag->green());
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param  int              $id
     * @param UpdateTagRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTagRequest $request)
    {
        $tag = $this->tagRepository->findWithoutFail($id);

        if (empty($tag)) {
            Flash::error('Tag not found');
            return redirect(route('tags.index'));
        }

        $input = $request->all();

        // $input['icon'] = $this->saveFileService->setImage($request->icon)->handle();

        if (empty($tag->blue())) {
            $tag->icon()->create([
                'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setStorage($this->iconPath)->handle(),
                'color' => 'blue'
            ]);
        } else {
            $tag->blue()->update([
                'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setModel($tag->blue()->image)->setStorage($this->iconPath)->handle(),
            ]);
        }

        if (empty($tag->green())) {
            $tag->icon()->create([
                'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setStorage($this->iconPath)->handle(),
                'color' => 'green'
            ]);
        } else {
            $tag->green()->update([
                'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setModel($tag->green()->image)->setStorage($this->iconPath)->handle(),
            ]);
        }

        $tag = $this->tagRepository->update($input, $id);

        Flash::success('Tag updated successfully.');
        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tag = $this->tagRepository->findWithoutFail($id);

        if (empty($tag)) {
            Flash::error('Tag not found');
            return redirect(route('tags.index'));
        }

        $this->saveFileService->setModel(@$tag->blue()->image)->isDelete(1)->handle();
        $this->saveFileService->setModel(@$tag->green()->image)->isDelete(1)->handle();

        $tag->icon()->delete();
        $this->tagRepository->delete($id);

        Flash::success('Tag deleted successfully.');
        return redirect(route('tags.index'));
    }

    /**
     * Store data Tag from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $tag = $this->tagRepository->create($item->toArray());
            });
        });

        Flash::success('Tag saved successfully.');
        return redirect(route('tags.index'));
    }
    public function filter() {
        $data = TagsContent::where(function($q) {
            $q->where('kontol', 'tonl')
            ->orWhere('lala', 'lala');
        });
    }
}
