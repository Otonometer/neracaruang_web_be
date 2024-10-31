@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css') }}">

<style>
    .show {
        display: inline !important;
    }
</style>
@endsection

@section('contents')
    <section class="content-header">
        <h1 class="pull-left">Access Control</h1>
        <!-- <h1 class="pull-right">
            {{--<button type="button" class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px">
                Save
            </button>--}}
        </h1> -->
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" style="margin-top:15px;padding:0 15px" role="tablist">
                <li role="presentation" class="active"><a href="#bymodel" aria-controls="bymodel" role="tab" data-toggle="tab">Access By Model</a></li>
                <li role="presentation"><a href="#byroute" aria-controls="byroute" role="tab" data-toggle="tab">Access By Route</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="bymodel">
                    <form class="box-body" action="accessControl" method="post">
                        @csrf
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group col-sm-6" style="margin:0">
                                    {!! Form::label('user_role', 'User or Role:') !!}
                                    <!-- {{--{!! Form::select('user_role', array_merge([0 => null], $users->pluck('name', 'id')->toArray(), $roles->pluck('name', 'id')->toArray()), null, ['class' => 'form-control select2']) !!}--}} -->
                                    <select class="user_role form-control select2" name="user_role" required>
                                        <option></option>
                                        @foreach($users as $user)
                                        <option value="user.{{$user->id}}" data-url="type=user&id={{$user->id}}" {{app('request')->input('type') == 'user' && app('request')->input('id') == $user->id ? 'selected' : null}}>User\{{$user->name}}</option>
                                        @endforeach
                                        @foreach($roles as $role)
                                        <option value="role.{{$role->id}}" data-url="type=role&id={{$role->id}}" {{app('request')->input('type') == 'role' && app('request')->input('id') == $role->id ? 'selected' : null}}>Role\{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6 text-right" style="margin:0">
                                    <a class="btn btn-primary" href="{{url('roles/create')}}" style="margin-right:5px">Add Role</a>
                                    <a class="btn btn-primary" href="{{url('users/create')}}">Add User</a>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="margin:0">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th class="text-center">
                                                    Index Any
                                                    <div><input type="checkbox" name="index" id="index" data-access="index"></div>
                                                </th>
                                                <th class="text-center">
                                                    Index Owned
                                                    <div><input type="checkbox" name="index_owned" id="index_owned" data-access="index_owned"></div>
                                                </th>
                                                <th class="text-center">
                                                    Show Any
                                                    <div><input type="checkbox" name="show" id="show" data-access="show"></div>
                                                </th>
                                                <th class="text-center">
                                                    Show Owned
                                                    <div><input type="checkbox" name="show_owned" id="show_owned" data-access="show_owned"></div>
                                                </th>
                                                <th class="text-center">
                                                    Create Owned
                                                    <div><input type="checkbox" name="create_owned" id="create_owned" data-access="create_owned"></div>
                                                </th>
                                                <th class="text-center">
                                                    Store Owned
                                                    <div><input type="checkbox" name="store_owned" id="store_owned" data-access="store_owned"></div>
                                                </th>
                                                <th class="text-center">
                                                    Edit Any
                                                    <div><input type="checkbox" name="edit" id="edit" data-access="edit"></div>
                                                </th>
                                                <th class="text-center">
                                                    Edit Owned
                                                    <div><input type="checkbox" name="edit_owned" id="edit_owned" data-access="edit_owned"></div>
                                                </th>
                                                <th class="text-center">
                                                    Update Any
                                                    <div><input type="checkbox" name="update" id="update" data-access="update"></div>
                                                </th>
                                                <th class="text-center">
                                                    Update Owned
                                                    <div><input type="checkbox" name="update_owned" id="update_owned" data-access="update_owned"></div>
                                                </th>
                                                <th class="text-center">
                                                    Destroy Any
                                                    <div><input type="checkbox" name="destroy" id="destroy" data-access="destroy"></div>
                                                </th>
                                                <th class="text-center">
                                                    Destroy Owned
                                                    <div><input type="checkbox" name="destroy_owned" id="destroy_owned" data-access="destroy_owned"></div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($models as $key => $model)
                                            <tr id="{{$model}}">
                                                <td>
                                                    <input type="hidden" name="model[]" value="{{lcfirst(Str::plural($model))}}">
                                                    {{$model}}
                                                </td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.index]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_index" class="index" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.index]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.index']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.index.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_index_owned" class="index_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.index.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.index.owned']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.show]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_show" class="show" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.show]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.show']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.show.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_show_owned" class="show_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.show.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.show.owned']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.create.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_create_owned" class="create_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.create.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.create.owned']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.store.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_store_owned" class="store_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.store.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.store.owned']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.edit]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_edit" class="edit" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.edit]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.edit']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.edit.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_edit_owned" class="edit_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.edit.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.edit.owned']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.update]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_update" class="update" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.update]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.update']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.update.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_update_owned" class="update_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.update.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.update.owned']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.destroy]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_destroy" class="destroy" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.destroy]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.destroy']) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{lcfirst(Str::plural($model))}}.destroy.owned]" value="off"><input id="{{str_replace('.','_',lcfirst(Str::plural($model)))}}_destroy_owned" class="destroy_owned" type="checkbox" name="permissions[{{lcfirst(Str::plural($model))}}.destroy.owned]" value="on" {{isset($permissions[lcfirst(Str::plural($model)).'.destroy.owned']) ? 'checked' : null}}></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group col-sm-12" style="margin:0">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary pull-right']) !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="byroute">
                    <form class="box-body" action="accessControl" method="post">
                        @csrf
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group col-sm-6" style="margin:0">
                                    {!! Form::label('user_role', 'User or Role:') !!}
                                    <!-- {{--{!! Form::select('user_role', array_merge([0 => null], $users->pluck('name', 'id')->toArray(), $roles->pluck('name', 'id')->toArray()), null, ['class' => 'form-control select2']) !!}--}} -->
                                    <select class="user_role form-control select2" name="user_role" required>
                                        <option></option>
                                        @foreach($users as $user)
                                        <option value="user.{{$user->id}}" data-url="type=user&id={{$user->id}}" {{app('request')->input('type') == 'user' && app('request')->input('id') == $user->id ? 'selected' : null}}>User\{{$user->name}}</option>
                                        @endforeach
                                        @foreach($roles as $role)
                                        <option value="role.{{$role->id}}" data-url="type=role&id={{$role->id}}" {{app('request')->input('type') == 'role' && app('request')->input('id') == $role->id ? 'selected' : null}}>Role\{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6 text-right" style="margin:0">
                                    <a class="btn btn-primary" href="{{url('roles/create')}}" style="margin-right:5px">Add Role</a>
                                    <a class="btn btn-primary" href="{{url('users/create')}}">Add User</a>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="margin:0">
                                        <thead>
                                            <tr>
                                                <th>Route</th>
                                                <th class="text-center">
                                                    Access Any
                                                    <div><input type="checkbox" name="access_any" id="access_any" data-access="access_any"></div>
                                                </th>
                                                <th class="text-center">
                                                    Access Owned
                                                    <div><input type="checkbox" name="access_owned" id="access_owned" data-access="access_owned"></div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($i = 0)
                                            @foreach($routes as $key => $route)
                                            <tr id="{{$route}}">
                                                <td>
                                                    <input type="hidden" name="route[]" value="{{$route}}">
                                                    {{$route}}
                                                </td>
                                                @if(substr($route, -6) != '.index' && substr($route, -5) != '.show' && substr($route, -6) != '.store' && substr($route, -7) != '.create' && substr($route, -5) != '.edit' && substr($route, -7) != '.update' && substr($route, -8) != '.destroy')
                                                <td class="text-center"><input type="hidden" name="permissions[{{$route}}]" value="off"><input id="route_{{str_replace('.','_',$route)}}" class="access_any" data-type="any" type="checkbox" name="permissions[{{$route}}]" value="on" {{isset($permissions[$route]) ? 'checked' : null}}></td>
                                                <td class="text-center"></td>
                                                @elseif(substr($route, -6) == '.store' || substr($route, -7) == '.create')
                                                <td class="text-center"></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{$route}}.owned]" value="off"><input id="route_{{str_replace('.','_',$route)}}_owned" class="access_owned" data-type="owned" type="checkbox" name="permissions[{{$route}}.owned]" value="on" {{isset($permissions[$route.'.owned']) ? 'checked' : null}}></td>
                                                @else
                                                <td class="text-center"><input type="hidden" name="permissions[{{$route}}]" value="off"><input id="route_{{str_replace('.','_',$route)}}" class="access_any" type="checkbox" name="permissions[{{$route}}]" value="on" {{isset($permissions[$route]) ? 'checked' : null}}></td>
                                                <td class="text-center"><input type="hidden" name="permissions[{{$route}}.owned]" value="off"><input id="route_{{str_replace('.','_',$route)}}_owned" class="access_owned" type="checkbox" name="permissions[{{$route}}.owned]" value="on" {{isset($permissions[$route.'.owned']) ? 'checked' : null}}></td>
                                                @endif
                                            </tr>
                                            @php($i++)
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group col-sm-12" style="margin:0">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary pull-right']) !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/toast/jquery.toast.min.js') }}"></script>

<script>
    if($('.index').length == $('.index:checked').length) {
        $('#index').prop('checked', true);
    }
    if($('.index_owned').length == $('.index_owned:checked').length) {
        $('#index_owned').prop('checked', true);
    }
    if($('.show').length == $('.show:checked').length) {
        $('#show').prop('checked', true);
    }
    if($('.show_owned').length == $('.show_owned:checked').length) {
        $('#show_owned').prop('checked', true);
    }
    if($('.create_owned').length == $('.create_owned:checked').length) {
        $('#create_owned').prop('checked', true);
    }
    if($('.store_owned').length == $('.store_owned:checked').length) {
        $('#store_owned').prop('checked', true);
    }
    if($('.edit').length == $('.edit:checked').length) {
        $('#edit').prop('checked', true);
    }
    if($('.edit_owned').length == $('.edit_owned:checked').length) {
        $('#edit_owned').prop('checked', true);
    }
    if($('.update').length == $('.update:checked').length) {
        $('#update').prop('checked', true);
    }
    if($('.update_owned').length == $('.update_owned:checked').length) {
        $('#update_owned').prop('checked', true);
    }
    if($('.destroy').length == $('.destroy:checked').length) {
        $('#destroy').prop('checked', true);
    }
    if($('.destroy_owned').length == $('.destroy_owned:checked').length) {
        $('#destroy_owned').prop('checked', true);
    }
    if(($('.access_any').length + $('[data-type="owned"]').length) == ($('.access_any:checked').length + $('[data-type="owned"]:checked').length)) {
        $('#access_any').prop('checked', true);
    }
    if($('.access_owned').length == $('.access_owned:checked').length) {
        $('#access_owned').prop('checked', true);
    }

    $('.user_role').on('change', function() {
        if($(this).find('option:selected').data('url')) {
            location = "{{url('/accessControl')}}?"+$(this).find('option:selected').data('url');
        }
    });

    $('#index, #index_owned, #show, #show_owned, #create_owned, #store_owned, #edit, #edit_owned, #update, #update_owned, #destroy, #destroy_owned, #access_any, #access_owned').on('change', function() {
        var id = $(this).attr("id");

        if(id == 'index' || id == 'show' || id == 'edit' || id == 'update' || id == 'destroy') {
            $(document).find('#'+id+'_owned').prop('checked', false);
            $(document).find('.'+id+'_owned').prop('checked', false);
        }
        if(id == 'index_owned' || id == 'show_owned' || id == 'edit_owned' || id == 'update_owned' || id == 'destroy_owned') {
            $(document).find('#'+id.replace('_owned','')).prop('checked', false);
            $(document).find('.'+id.replace('_owned','')).prop('checked', false);
        }
        if(id == 'access_any') {
            $(document).find('#access_owned').prop('checked', false);
            $(document).find('.access_owned').prop('checked', false);
            $(document).find('[data-type="owned"]').prop('checked', true);
        }
        if(id == 'access_owned') {
            $(document).find('#access_any').prop('checked', false);
            $(document).find('.access_any').prop('checked', false);
        }

        if($(this).prop('checked')) {
            $('.'+$(this).data('access')).prop('checked', true);
            if($(this).data('access') == 'access_any') {
                $(document).find('[data-type="owned"]').prop('checked', true);
            }
        } else {
            $('.'+$(this).data('access')).prop('checked', false);
            if($(this).data('access') == 'access_any') {
                $(document).find('[data-type="owned"]').prop('checked', false);
            }
        }
    });
    $('.index, .index_owned, .show, .show_owned, .create_owned, .store_owned, .edit, .edit_owned, .update, .update_owned, .destroy, .destroy_owned, .access_any, .access_owned').on('change', function() {
        var cls = $(this).attr("class");

        if(cls == 'index' || cls == 'show' || cls == 'edit' || cls == 'update' || cls == 'destroy') {            
            $(document).find('[name="'+cls+'_owned"]').prop('checked', false);
            $(document).find('[name="permissions['+$(this).attr('id').replace(/_/g,'.')+'.owned]"]').prop('checked', false);
        }
        if(cls == 'index_owned' || cls == 'show_owned' || cls == 'edit_owned' || cls == 'update_owned' || cls == 'destroy_owned') {            
            $(document).find('[name="'+cls.replace('_owned','')+'"]').prop('checked', false);
            $(document).find('[name="permissions['+$(this).attr('id').replace('_owned','').replace(/_/g,'.')+']"]').prop('checked', false);
        }
        if(cls == 'access_any') {
            $('#access_owned').prop('checked', false);
            $(document).find('[name="permissions['+$(this).attr('id').replace('route_','').replace(/_/g,'.')+'.owned]"]').prop('checked', false);
        }
        if(cls == 'access_owned') {
            $('#access_any').prop('checked', false);
            if($(this).data('type') != 'owned') {
                $(document).find('[name="permissions['+$(this).attr('id').replace('route_','').replace('_owned','').replace(/_/g,'.')+']"]').prop('checked', false);
            }
        }

        if($(this).data('type') == 'owned') {
            if(
                $(document).find('[data-type="owned"]:checked').length == $(document).find('[data-type="owned"]').length &&
                $(document).find('.access_any:checked').length > 0 && $(document).find('.access_any:checked').length == $(document).find('.access_any').length
                ) {
                $('#access_any').prop('checked', true);
            } else {
                $('#access_any').prop('checked', false);
            }

            if(
                $(document).find('[data-type="owned"]:checked').length == $(document).find('[data-type="owned"]').length &&
                $(document).find('.access_owned:checked').length > 0 && $(document).find('.access_owned:checked').length == $(document).find('.access_owned').length
                ) {
                $('#access_owned').prop('checked', true);
            } else {
                $('#access_owned').prop('checked', false);
            }
        } else {
            if(
                cls == 'access_any' &&
                $(document).find('[data-type="owned"]:checked').length == $(document).find('[data-type="owned"]').length &&
                $(document).find('.access_any:checked').length == $(document).find('.access_any').length
                ) {
                $('#access_any').prop('checked', true);
            } else if(
                cls == 'access_owned' &&
                $(document).find('[data-type="owned"]:checked').length == $(document).find('[data-type="owned"]').length &&
                $(document).find('.access_owned:checked').length == $(document).find('.access_owned').length
                ) {
                $('#access_owned').prop('checked', true);
            } else {
                var classLength = $('.'+cls).length;
                var classChecked = $('.'+cls+':checked').length;

                if(classLength != classChecked) {
                    $('#'+cls).prop('checked', false);
                } else {
                    $('#'+cls).prop('checked', true);
                }
            }
        }

        var permissions = {};
        var key = $(this).attr('id').replace('route_','').replace(/_/g,'.');
        var opKey = null;
        if(key.endsWith('.owned')) {
                ($(this).attr('id').endsWith('.create.owned') && $(this).attr('id').endsWith('.store.owned'))
            if($(this).data('type') != 'owned' && !key.endsWith('.create.owned') && !key.endsWith('.store.owned')) {
                opKey = key.replace('.owned','');
            }
        } else {
            if($(this).data('type') != 'any') {
                opKey = key+'.owned';
            }
        }
        permissions[key] = $(this).prop('checked') == true ? 'on' : 'off';
        if(opKey) {
            permissions[opKey] = 'off';
        }
        
        if($('.user_role').val() && permissions) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url("accessControl") }}',
                type: 'post',
                data: {
                    user_role : $('.user_role').val(),
                    permissions: permissions
                }
            }).success(function(res) {
                $.toast({
                    heading: 'Access Control',
                    text: 'Permission saved successfully',
                    position: 'bottom-right',
                    stack: false
                });
                console.log(res);
                // location = '{{ url()->current() }}';
            }).error(function(res) {
                console.log(res);
                // location = '{{ url()->current() }}';
            });
        } else {
            alert('User or role must be selected to store an permission asynchronously')
        }
    });
</script>
@endsection
