<?php

namespace App\Http\Controllers;

use App\DataTables\IconDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateIconRequest;
use App\Http\Requests\UpdateIconRequest;
use App\Repositories\IconRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage; 
use Maatwebsite\Excel\Facades\Excel; 

class IconController extends AppBaseController
{
    /** @var  IconRepository */
    private $iconRepository;

    public function __construct(IconRepository $iconRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:icon-edit', ['only' => ['edit']]);
        $this->middleware('can:icon-store', ['only' => ['store']]);
        $this->middleware('can:icon-show', ['only' => ['show']]);
        $this->middleware('can:icon-update', ['only' => ['update']]);
        $this->middleware('can:icon-delete', ['only' => ['delete']]);
        $this->middleware('can:icon-create', ['only' => ['create']]);
        $this->iconRepository = $iconRepo;
    }

    /**
     * Display a listing of the Icon.
     *
     * @param IconDataTable $iconDataTable
     * @return Response
     */
    public function index(IconDataTable $iconDataTable)
    {
        return $iconDataTable->render('icons.index');
    }

    /**
     * Show the form for creating a new Icon.
     *
     * @return Response
     */
    public function create()
    {
        

        return view('icons.create');
    }

    /**
     * Store a newly created Icon in storage.
     *
     * @param CreateIconRequest $request
     *
     * @return Response
     */
    public function store(CreateIconRequest $request)
    {
        $input = $request->all();

        $icon = $this->iconRepository->create($input);

        Flash::success('Icon saved successfully.');
        return redirect(route('icons.index'));
    }

    /**
     * Display the specified Icon.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $icon = $this->iconRepository->findWithoutFail($id);

        if (empty($icon)) {
            Flash::error('Icon not found');
            return redirect(route('icons.index'));
        }

        return view('icons.show')->with('icon', $icon);
    }

    /**
     * Show the form for editing the specified Icon.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        

        $icon = $this->iconRepository->findWithoutFail($id);

        if (empty($icon)) {
            Flash::error('Icon not found');
            return redirect(route('icons.index'));
        }

        return view('icons.edit')
            ->with('icon', $icon);
    }

    /**
     * Update the specified Icon in storage.
     *
     * @param  int              $id
     * @param UpdateIconRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIconRequest $request)
    {
        $icon = $this->iconRepository->findWithoutFail($id);

        if (empty($icon)) {
            Flash::error('Icon not found');
            return redirect(route('icons.index'));
        }

        $input = $request->all();
        $icon = $this->iconRepository->update($input, $id);

        Flash::success('Icon updated successfully.');
        return redirect(route('icons.index'));
    }

    /**
     * Remove the specified Icon from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $icon = $this->iconRepository->findWithoutFail($id);

        if (empty($icon)) {
            Flash::error('Icon not found');
            return redirect(route('icons.index'));
        }

        $this->iconRepository->delete($id);

        Flash::success('Icon deleted successfully.');
        return redirect(route('icons.index'));
    }

    /**
     * Store data Icon from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $icon = $this->iconRepository->create($item->toArray());
            });
        });

        Flash::success('Icon saved successfully.');
        return redirect(route('icons.index'));
    }
}
