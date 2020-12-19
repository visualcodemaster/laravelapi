@extends('layouts.backend-master')
@section('styles')
@stop
@section('content')
    <h1 class="page-title"> Users
        <small>User Details</small>
    </h1>
    <div class="row">
        <div class="col">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                User
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('users.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">User</label>
                                            <div class="col">
                                                <select tabindex="1" id="name" name="name" style="width: 100%;" class="form-control @error('name') is-invalid @enderror">
                                                    <option></option>
                                                    @foreach($users as $user)
                                                        <option value="{!! $user->name !!}">{!! $user->name !!}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div><div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email</label>
                                            <div class="col">
                                                <input type="email" tabindex="2" id="email" name="email" value="{{old('email')}}" style="width: 100%;" class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Password</label>
                                            <div class="col">
                                                <input type="text" tabindex="3" id="password" name="password"  style="width: 100%;" class="form-control @error('password') is-invalid @enderror">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col text-right mr-4">
                                        <button type="submit"  class="btn btn-success">Add</button>

                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#name").select2({
                placeholder:'Enter User Name',
                tags: true
            });
        });
    </script>
@stop
