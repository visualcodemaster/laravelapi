@extends('layouts.backend-master')
@section('styles')
{{--    <link href="{{ URL::asset('theme/vendors/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" href="{{URL::asset('theme/global/sumoselect/sumoselect.css')}}" rel="stylesheet" type="text/css">
    <style>
        .SumoSelect {
            color: black;
            width: 90%;
        }
    </style>
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
                    <div class="m-separator m-separator--space m-separator--dashed"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Edit Permissions for {{$role->name}}</h4>
                            <div class="card">
                                <div class="card-header">Role</div>
                                <div class="card-body">
                                    {{ Form::open(array('url' => route('roles.permissions.store', $role->id), 'class' => 'form-horizontal')) }}
                                    <ul>
                                        <div class="row">
                                            @foreach($actions as $action)
                                                <div class="col-md-4">
                                                    <?php $first= array_values($action)[0];
                                                    $firstname =explode(".", $first)[0];
                                                    ?>
                                                    {{Form::label($firstname, $firstname, ['class' => 'form col-md-8 capital_letter'])}}
                                                    <select name="permissions[]" class="select" multiple="multiple">
                                                        @foreach($action as $act)
                                                                {{array_key_exists($act, $rolesPermissions)}}
                                                            <option value="{{$act}}" {{array_key_exists($act, $rolesPermissions)?"selected":""}}>
                                                                <?php
                                                                $rest = explode(".", $act);
                                                                ?>
                                                                @foreach($rest as $item)
                                                                    {{$item}}
                                                                @endforeach
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div> <br>

                                        <div class="form-group row">
                                            <div class="col-sm-offset-2 col-sm-3">
                                                <a href="{{route('roles.index')}}" class="btn btn-dark form-control">Back to list</a>
                                            </div>
                                            <div class="col-sm-offset-2 col-sm-3">
                                                {!! Form::submit('Submit', ['class' => 'btn btn-success form-control']) !!}
                                            </div>
                                        </div>
                                    </ul>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


@stop
@section('scripts')
    <script src="{{URL::asset('theme/global/sumoselect/sumoselect.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.select').SumoSelect({ search: true, selectAll: true, placeholder: 'Nothing selected' });
        });
    </script>
@stop

