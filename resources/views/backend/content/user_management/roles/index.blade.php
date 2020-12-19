@extends('layouts.backend-master')
@section('styles')
    <link href="{{ URL::asset('theme/global/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .dataTables_filter { display: none; }
    </style>
@stop
@section('content')
    <h1 class="page-title">
        <small>Roles & Permissions</small>
    </h1>
    <div class="row">
        <div class="col text-right mb-2">
            <a href="{{route('roles.create')}}" class="btn btn-success">Add New Role</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Roles
                            </h3>
                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissable" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="m-portlet__body">
                    <h4>List of all the roles</h4>
                    <div class="row">
                        <div class="col-md-12" >
                            <table id="tblRoles" class="table table-striped- table-bordered table-hover table-checkable">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--End Test--}}
    {{-- Delete Form Starts --}}
    {!! Form::open(['method' => 'delete', 'id' => 'deleteForm']) !!}
    {!! Form::hidden('id', null , ['id' => 'deleteId']) !!}
    {!! Form::close() !!}
    {{-- Delete Form Ends --}}
@stop
@section('scripts')
    <script src="{{asset('theme/global/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            // Hide alerts and errors of datatable
            $.fn.dataTable.ext.errMode = 'none';
            var app_route = '{{route('roles.index')}}';

            // var params = {
            //     'status': $('#active_status option:selected').text(),
            // };

            var table = $('#tblRoles').DataTable({

                // begin first table

                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: app_route,
                    type: 'GET',
                    /*data: function ( d ) {
                        d.status = $('#active_status').val();

                    },*/
                    error: function(data){
                        console.log(data);
                    }
                },
                language: {
                    searchPlaceholder: "Search...",
                    search: "",
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    // {data: 'slug'},

                    {
                        data: null,
                        responsivePriority: 100,
                        orderable: false,
                        searchable: false,
                        render: function ( data, type, row ) {

                            var view_url = '{{route('roles.show', ':id')}}';
                            view_url = view_url.replace(':id', row.id);
                            var edit_url = '{{route('roles.edit', ':id')}}';
                            edit_url = edit_url.replace(':id', row.id);

                            return '<a href="'+view_url+'" class="btn btn-sm btn-clean btn-icon btn-icon-md">'
                                +'<i class="fa fa-eye"></i>'
                                +'</a>'

{{--                                @if(in_array('roles.update', array_keys(session('user')['routePermissions'])))--}}
                                + ' <a href="'+edit_url+'" class="btn btn-sm btn-clean btn-icon btn-icon-md">'
                                +'<i class="la la-edit"></i>'
                                +'</a>'
{{--                                @endif--}}

{{--                                @if(in_array('api.v1.roles.destroy', array_keys(session('user')['routePermissions'])))--}}
                                + ' <a href="javascript:void(0);" class="flaticon-delete deleteRole" data-id="'+data.id+'" id="deleteData"></a>'
{{--                                @endif--}}
                                ;

                        },
                    }
                ],

                order: [[0, "asc"]],

            });
            $(document).on('click', '.deleteRole', function () {
                var currentID = $(this).attr('data-id');
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.value) {
                        var delete_url = '{{route('roles.destroy', ':id')}}';
                        delete_url = delete_url.replace(':id', currentID);
                        console.log(delete_url);
                        $('#deleteForm').attr('action', delete_url);
                        $('#deleteForm')[0].submit();
                        swal.fire(
                            'Deleted!',
                            'Role has been deleted.',
                            'success'
                        )
                    }
                }, currentID);
            });
            // $('#generalSearch').on( 'keyup', function () {
            //     table.search($('#generalSearch').val()).draw();
            // });


            // $('#active_status').on('change', function() {
            //     params.status = $('#active_status option:selected').text();
            //     var new_url = app_route  + '?' + jQuery.param(params);
            //
            //     if (history.pushState) {
            //         window.history.pushState(null, null, new_url);
            //     }else{
            //         document.location.href = new_url;
            //     }
            //     datatable.ajax.reload();
            // });
        });
    </script>
@endsection
