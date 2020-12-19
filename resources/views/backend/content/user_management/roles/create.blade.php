@extends('layouts.backend-master')
@section('styles')

@stop
@section('content')

        <div class="row ">
            <div class="col">
                <div class="card">
                    <div class="card-header">Roles</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{route('roles.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col form-group">
                                            <label class="form-control-label">Role</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}" placeholder="Name"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <input type="submit" class="btn btn-primary input-lg" value="Add Role"/>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

@stop
@section('scripts')
    <script>
      $(document).ready(function(){});
    </script>
@stop
