@extends('layouts.backend-master')
@section('styles')
    <link href="{{ URL::asset('theme/global/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@stop
@section('content')

    <div class="row ">
        <div class="col">
            <div class="card">
                <div class="card-header">Role</div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-3">
                            Role name
                        </label>
                        <div class="col-9">
                            {{ $role->name }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-3">
                            Permissions
                        </label>
                        <div class="col-9">
                            <a class="btn btn-secondary" href="{{route('roles.permissions', $role->id)}}">Permissions</a>
                        </div>
                    </div>
                    <div class="m-separator m-separator--space m-separator--dashed"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>List of Users Attached to this Role</h4>
                                        <table id="tblUsers" class="table table-striped- table-bordered table-hover table-checkable">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>email</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@stop
@section('scripts')
    <script src="{{asset('theme/global/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script>

        $(document).ready(function () {
            $('#tblUsers').DataTable({
                processing:true,
                serverSide:true,
                ajax:'{{route('roles.attached.users',$role->id)}}',
                columns:[
                    {data:'id',name:'id'},
                    {data:'name',name:'name'},
                    {data:'email',name:'email'},
                ]
            });
        });

    </script>
@stop
