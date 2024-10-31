<?php

namespace App\Http\Controllers\Webcore;

use App\DataTables\RoleDataTable;
use App\Http\Requests;
use App\Http\Requests\Webcore\CreateRoleRequest;
use App\Http\Requests\Webcore\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Permission;
use App\Models\Permissiongroup;
use App\Models\Permissionlabel;
use App\User;
use Response;
use Illuminate\Http\Request; // added by dandisy
use Illuminate\Support\Facades\Auth; // added by dandisy
use Illuminate\Support\Facades\Storage; // added by dandisy
use Maatwebsite\Excel\Facades\Excel; // added by dandisy

class RoleController extends AppBaseController
{
    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:role-edit', ['only' => ['edit']]);
        $this->middleware('can:role-store', ['only' => ['store']]);
        $this->middleware('can:role-show', ['only' => ['show']]);
        $this->middleware('can:role-update', ['only' => ['update']]);
        $this->middleware('can:role-delete', ['only' => ['delete']]);
        $this->middleware('can:role-create', ['only' => ['create']]);
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        $groups = Permissiongroup::all();
        $permissions = [];

        foreach($groups as $group){
            $labels = Permissionlabel::where('permission_group_id', $group->id)->get();
            $arr_label = [];
            foreach($labels as $label){
                $arr_label[] = [
                    'name' => $label->name,
                    'permissions' => Permission::where('permissions_label_id', $label->id)->select('id', 'name')->get()
                ];
            }

            $permissions[] = [
                'group' => $group->name,
                'labels' => $arr_label
            ];
        }
        
        return view('roles.create')
            ->with('role', null)
            ->with('permissions', $permissions);
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->except(['permissions']);
        $role = $this->roleRepository->create($input);

        if($request->permissions <> ''){
            $role->syncPermissions($request->permissions);
        }

        Flash::success('Role saved successfully.');
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');
            return redirect(route('roles.index'));
        }

        $groups = Permissiongroup::all();
        $permissions = [];

        foreach($groups as $group){
            $labels = Permissionlabel::where('permission_group_id', $group->id)->get();
            $arr_label = [];
            foreach($labels as $label){
                $arr_label[] = [
                    'name' => $label->name,
                    'permissions' => Permission::where('permissions_label_id', $label->id)->select('id', 'name')->get()
                ];
            }

            $permissions[] = [
                'group' => $group->name,
                'labels' => $arr_label
            ];
        }

        return view('roles.show')->with('role', $role)->with('permissions', $permissions);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');
            return redirect(route('roles.index'));
        }

        $groups = Permissiongroup::all();
        $permissions = [];

        foreach($groups as $group){
            $labels = Permissionlabel::where('permission_group_id', $group->id)->get();
            $arr_label = [];
            foreach($labels as $label){
                $arr_label[] = [
                    'name' => $label->name,
                    'permissions' => Permission::where('permissions_label_id', $label->id)->select('id', 'name')->get()
                ];
            }

            $permissions[] = [
                'group' => $group->name,
                'labels' => $arr_label
            ];
        }
        
        return view('roles.edit')
            ->with('role', $role)
            ->with('permissions', $permissions);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int              $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $input = $request->except(['permissions']);

        $role->fill($input)->save();

        $role->syncPermissions($request->permissions);

        Flash::success('Role updated successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $this->roleRepository->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Store data Role from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $role = $this->roleRepository->create($item->toArray());
            });
        });

        Flash::success('Role saved successfully.');

        return redirect(route('roles.index'));
    }
}
