@extends('layouts.backend-master')
@section('page_level_styles')
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
                            <form action="{{route('users.update',['user'=>$user->id])}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Name</label>
                                            <div class="col">
                                                <input type="text" id="name" value="{{$user->name ?? old('name')}}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Owner">
                                                @error('name')
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
                                            <label class="control-label col-md-3">Email</label>
                                            <div class="col">
                                                <input type="email" tabindex="1" id="email" name="email" value="{{$user->email ?? old('email')}}" style="width: 100%;" class="form-control @error('email') is-invalid @enderror">
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
                                                <input type="password" tabindex="1" id="password" name="password" value="{{$account->password ?? old('password')}}" style="width: 100%;" class="form-control @error('password') is-invalid @enderror">
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
                                        <button type="submit"  class="btn btn-success">Update</button>
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
@section('page_level_scripts')
@stop
