<?php

namespace App\Http\Controllers;

use App\DataTables\PageTypeDataTable;
use App\Enums\ContentTypes as ContentTypesEnum;
use App\Http\Requests;
use App\Http\Requests\CreatePageTypeRequest;
use App\Http\Requests\UpdatePageTypeRequest;
use App\Repositories\PageTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PageTypeController extends AppBaseController
{
    /** @var  PageTypeRepository */
    private $pageTypeRepository;

    public function __construct(PageTypeRepository $pageTypeRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:pageType-edit', ['only' => ['edit']]);
        $this->middleware('can:pageType-store', ['only' => ['store']]);
        $this->middleware('can:pageType-show', ['only' => ['show']]);
        $this->middleware('can:pageType-update', ['only' => ['update']]);
        $this->middleware('can:pageType-delete', ['only' => ['delete']]);
        $this->middleware('can:pageType-create', ['only' => ['create']]);
        $this->pageTypeRepository = $pageTypeRepo;
    }

    /**
     * Display a listing of the PageType.
     *
     * @param PageTypeDataTable $pageTypeDataTable
     * @return Response
     */
    public function index(PageTypeDataTable $pageTypeDataTable)
    {
        return $pageTypeDataTable->render('page_types.index');
    }

    /**
     * Show the form for creating a new PageType.
     *
     * @return Response
     */
    public function create()
    {
        return view('page_types.create');
    }

    /**
     * Store a newly created PageType in storage.
     *
     * @param CreatePageTypeRequest $request
     *
     * @return Response
     */
    public function store(CreatePageTypeRequest $request)
    {
        $input = $request->all();

        $pageType = $this->pageTypeRepository->create($input);

        Flash::success('Page Type saved successfully.');
        return redirect(route('pageTypes.index'));
    }

    /**
     * Display the specified PageType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pageType = $this->pageTypeRepository->findWithoutFail($id);

        if (empty($pageType)) {
            Flash::error('Page Type not found');
            return redirect(route('pageTypes.index'));
        }

        return view('page_types.show')->with('pageType', $pageType);
    }

    /**
     * Show the form for editing the specified PageType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pageType = $this->pageTypeRepository->findWithoutFail($id);

        if (empty($pageType)) {
            Flash::error('Page Type not found');
            return redirect(route('pageTypes.index'));
        }

        return view('page_types.edit')
            ->with('pageType', $pageType);
    }

    /**
     * Update the specified PageType in storage.
     *
     * @param  int              $id
     * @param UpdatePageTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePageTypeRequest $request)
    {
        $pageType = $this->pageTypeRepository->findWithoutFail($id);

        if (empty($pageType)) {
            Flash::error('Page Type not found');
            return redirect(route('pageTypes.index'));
        }

        $input = $request->all();
        $pageType = $this->pageTypeRepository->update($input, $id);

        Flash::success('Page Type updated successfully.');
        return redirect(route('pageTypes.index'));
    }

    /**
     * Remove the specified PageType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pageType = $this->pageTypeRepository->findWithoutFail($id);

        if (empty($pageType)) {
            Flash::error('Page Type not found');
            return redirect(route('pageTypes.index'));
        }

        $this->pageTypeRepository->delete($id);

        Flash::success('Page Type deleted successfully.');
        return redirect(route('pageTypes.index'));
    }

    /**
     * Store data PageType from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $pageType = $this->pageTypeRepository->create($item->toArray());
            });
        });

        Flash::success('Page Type saved successfully.');
        return redirect(route('pageTypes.index'));
    }
}
