<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage; 
use Maatwebsite\Excel\Facades\Excel; 

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:category-edit', ['only' => ['edit']]);
        $this->middleware('can:category-store', ['only' => ['store']]);
        $this->middleware('can:category-show', ['only' => ['show']]);
        $this->middleware('can:category-update', ['only' => ['update']]);
        $this->middleware('can:category-delete', ['only' => ['delete']]);
        $this->middleware('can:category-create', ['only' => ['create']]);
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('categories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        

        return view('categories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->create($input);

        Flash::success('Category saved successfully.');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        

        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('categories.index'));
        }

        return view('categories.edit')
            ->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('categories.index'));
        }

        $input = $request->all();
        $category = $this->categoryRepository->update($input, $id);

        Flash::success('Category updated successfully.');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');
        return redirect(route('categories.index'));
    }

    /**
     * Store data Category from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $category = $this->categoryRepository->create($item->toArray());
            });
        });

        Flash::success('Category saved successfully.');
        return redirect(route('categories.index'));
    }
}
