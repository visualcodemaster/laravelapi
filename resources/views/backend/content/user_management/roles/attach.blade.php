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
                                <form method="post" action="{{route('users.attach.role.store',['user'=>request('user')])}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col form-group">
                                            <label class="form-control-label">Role</label>
                                            <select tabindex="1" id="role" name="role" style="width: 100%;" class="form-control @error('role') is-invalid @enderror">
                                                <option></option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{$user->roles()->first()->id == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <input type="submit" class="btn btn-primary input-lg" value="Add Role"/>
                                            <a href="{{route('users.index')}}" class="btn btn-secondary input-lg">Cancel</a>
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
      $(document).ready(function(){
          $("#role").select2({
              placeholder:'Select Role',
          });
      });
    </script>
@stop
