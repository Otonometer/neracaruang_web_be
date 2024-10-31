<?php

namespace App\Http\Controllers\Webcore;

use App\DataTables\PermissionDataTable;
use App\Http\Requests;
use App\Http\Requests\Webcore\CreatePermissionRequest;
use App\Http\Requests\Webcore\UpdatePermissionRequest;
use App\Repositories\PermissionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Permissiongroup;
use App\Models\Permissionlabel;
use Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request; // added by dandisy
use Illuminate\Support\Facades\Auth; // added by dandisy
use Illuminate\Support\Facades\Storage; // added by dandisy
use Maatwebsite\Excel\Facades\Excel; // added by dandisy

class PermissionController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:permission-edit', ['only' => ['edit']]);
        $this->middleware('can:permission-store', ['only' => ['store']]);
        $this->middleware('can:permission-show', ['only' => ['show']]);
        $this->middleware('can:permission-update', ['only' => ['update']]);
        $this->middleware('can:permission-delete', ['only' => ['delete']]);
        $this->middleware('can:permission-create', ['only' => ['create']]);
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Permission.
     *
     * @param PermissionDataTable $permissionDataTable
     * @return Response
     */
    public function index(PermissionDataTable $permissionDataTable)
    {
        return $permissionDataTable->render('permissions.index');
    }

    /**
     * Show the form for creating a new Permission.
     *
     * @return Response
     */
    public function create()
    {
        $group = Permissiongroup::all();
        return view('permissions.create')
        ->with('group', $group)
        ->with('label', null)
        ->with('permissions', null);
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param CreatePermissionRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissionRequest $request)
    {
        $input = $request->all();

        $label = Permissionlabel::create(['name' => $input['name'], 'permission_group_id' => @$input['permission_group_id']]);
        if(@$label->id > 0){
            $arr_permission = [];
            if(count(@$input['id_permission']) > 0){
                foreach(@$input['id_permission'] as $k => $val){
                    $arr_permission[] = [
                        'name' => @$input['name_permission'][$k],
                        'guard_name' => @$input['guard_name'],
                        'permissions_label_id' => @$label->id
                    ];
                }
            }
            if(count($arr_permission) > 0){
                Permission::insert($arr_permission);
            }
        }

        Flash::success('Permission saved successfully.');
        return redirect(route('permissions.index'));
    }

    /**
     * Display the specified Permission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $label = Permissionlabel::find($id);
        if (empty($label)) {
            Flash::error('Permission not found');
            return redirect(route('permissions.index'));
        }

        $group = Permissiongroup::find($label->permission_group_id);
        $permission = Permission::where('permissions_label_id', $id)->get();
        return view('permissions.show')
        ->with('group', $group)
        ->with('label', $label)
        ->with('permissions', $permission);
    }

    /**
     * Show the form for editing the specified Permission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $label = Permissionlabel::find($id);
        if (empty($label)) {
            Flash::error('Permission not found');
            return redirect(route('permissions.index'));
        }

        $group = Permissiongroup::all();
        $permission = Permission::where('permissions_label_id', $id)->get();
        return view('permissions.edit')
        ->with('group', $group)
        ->with('label', $label)
        ->with('permissions', $permission);
    }

    /**
     * Update the specified Permission in storage.
     *
     * @param  int              $id
     * @param UpdatePermissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermissionRequest $request)
    {
        $input = $request->all();

        $permission = Permissionlabel::find($id);

        if (empty($permission)) {
            Flash::error('Permission not found');

            return redirect(route('permissions.index'));
        }

        Permissionlabel::whereId($id)->update(['name' => $input['name'], 'permission_group_id' => @$input['permission_group_id']]);
        
        $arr_id = [];
        if(count(@$input['id_permission']) > 0){
            foreach(@$input['id_permission'] as $k => $val){
                if(intval($val) > 0)
                    $action = $this->permissionRepository->update(
                        [
                            'name' => @$input['name_permission'][$k],
                            'guard_name' => @$input['guard_name'],
                            'permissions_label_id' => $id 
                        ]
                    , $val);
                else
                    $action = $this->permissionRepository->create(
                        [
                            'name' => @$input['name_permission'][$k],
                            'guard_name' => @$input['guard_name'],
                            'permissions_label_id' => $id 
                        ]
                    );
                $arr_id[] = $action->id;
            }
        }

        if(count($arr_id) > 0){
            Permission::where('permissions_label_id',$id )->whereNotIn('id', $arr_id)->delete();
        }

        Flash::success('Permission updated successfully.');
        return redirect(route('permissions.index'));
    }

    /**
     * Remove the specified Permission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permission = Permissionlabel::find($id);

        if (empty($permission)) {
            Flash::error('Permission not found');
            return redirect(route('permissions.index'));
        }

        Permissionlabel::whereId($id)->delete();
        Permission::where('permissions_label_id', $id)->delete();

        // $this->permissionRepository->delete($id);

        Flash::success('Permission deleted successfully.');
        return redirect(route('permissions.index'));
    }

    /**
     * Store data Permission from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $permission = $this->permissionRepository->create($item->toArray());
            });
        });

        Flash::success('Permission saved successfully.');

        return redirect(route('permissions.index'));
    }
}
