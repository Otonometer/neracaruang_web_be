<?php

namespace App\Http\Controllers\Webcore;

use App\DataTables\PermissiongroupDataTable;
use App\Http\Requests\Webcore;
use App\Http\Requests\Webcore\CreatePermissiongroupRequest;
use App\Http\Requests\Webcore\UpdatePermissiongroupRequest;
use App\Repositories\PermissiongroupRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request; // added by dandisy
use Illuminate\Support\Facades\Auth; // added by dandisy
use Illuminate\Support\Facades\Storage; // added by dandisy
use Maatwebsite\Excel\Facades\Excel; // added by dandisy

class PermissiongroupController extends AppBaseController
{
    /** @var  PermissiongroupRepository */
    private $permissiongroupRepository;

    public function __construct(PermissiongroupRepository $permissiongroupRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:permissiongroup-edit', ['only' => ['edit']]);
        $this->middleware('can:permissiongroup-store', ['only' => ['store']]);
        $this->middleware('can:permissiongroup-show', ['only' => ['show']]);
        $this->middleware('can:permissiongroup-update', ['only' => ['update']]);
        $this->middleware('can:permissiongroup-delete', ['only' => ['delete']]);
        $this->middleware('can:permissiongroup-create', ['only' => ['create']]);
        $this->permissiongroupRepository = $permissiongroupRepo;
    }

    /**
     * Display a listing of the Permissiongroup.
     *
     * @param PermissiongroupDataTable $permissiongroupDataTable
     * @return Response
     */
    public function index(PermissiongroupDataTable $permissiongroupDataTable)
    {
        return $permissiongroupDataTable->render('permissiongroups.index');
    }

    /**
     * Show the form for creating a new Permissiongroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('permissiongroups.create');
    }

    /**
     * Store a newly created Permissiongroup in storage.
     *
     * @param CreatePermissiongroupRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissiongroupRequest $request)
    {
        $input = $request->all();

        $permissiongroup = $this->permissiongroupRepository->create($input);

        Flash::success('Permissiongroup saved successfully.');

        return redirect(route('permissiongroups.index'));
    }

    /**
     * Display the specified Permissiongroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $permissiongroup = $this->permissiongroupRepository->findWithoutFail($id);

        if (empty($permissiongroup)) {
            Flash::error('Permissiongroup not found');

            return redirect(route('permissiongroups.index'));
        }

        return view('permissiongroups.show')->with('permissiongroup', $permissiongroup);
    }

    /**
     * Show the form for editing the specified Permissiongroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $permissiongroup = $this->permissiongroupRepository->findWithoutFail($id);

        if (empty($permissiongroup)) {
            Flash::error('Permissiongroup not found');
            return redirect(route('permissiongroups.index'));
        }

        return view('permissiongroups.edit')
            ->with('permissiongroup', $permissiongroup);
    }

    /**
     * Update the specified Permissiongroup in storage.
     *
     * @param  int              $id
     * @param UpdatePermissiongroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermissiongroupRequest $request)
    {
        $permissiongroup = $this->permissiongroupRepository->findWithoutFail($id);

        if (empty($permissiongroup)) {
            Flash::error('Permissiongroup not found');

            return redirect(route('permissiongroups.index'));
        }

        $permissiongroup = $this->permissiongroupRepository->update($request->all(), $id);

        Flash::success('Permissiongroup updated successfully.');

        return redirect(route('permissiongroups.index'));
    }

    /**
     * Remove the specified Permissiongroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permissiongroup = $this->permissiongroupRepository->findWithoutFail($id);

        if (empty($permissiongroup)) {
            Flash::error('Permissiongroup not found');

            return redirect(route('permissiongroups.index'));
        }

        $this->permissiongroupRepository->delete($id);

        Flash::success('Permissiongroup deleted successfully.');

        return redirect(route('permissiongroups.index'));
    }

    /**
     * Store data Permissiongroup from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $permissiongroup = $this->permissiongroupRepository->create($item->toArray());
            });
        });

        Flash::success('Permissiongroup saved successfully.');

        return redirect(route('permissiongroups.index'));
    }
}
