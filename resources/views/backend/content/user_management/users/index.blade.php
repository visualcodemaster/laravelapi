@extends('layouts.backend-master')
@section('styles')
@stop
@section('content')
    <h1 class="page-title"> Users
        <small>Users Detail & Modification</small>
    </h1>
    <div class="row">
        <div class="col">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Users
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box green">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col text-right">
                                    <a href="{{route('users.create')}}" class="btn btn-info">Add New User</a>
                                </div>

                            </div>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissable" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <h4>List of all the Users</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                    <table id="userList"
                                           class="table table-striped- table-bordered table-hover table-checkable">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>email</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--End Test--}}
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#userList').DataTable({
                processing:true,
                serverSide:true,
                ajax:'{{route('users.index')}}',
                columns:[
                    {data:'id',name:'id'},
                    {data:'name',name:'name'},
                    {data:'email',name:'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop
