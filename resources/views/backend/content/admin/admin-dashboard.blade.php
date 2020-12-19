@extends('layouts.app')

@section('content')
    <div class="row ">
        <div class="col">
            <h3>Hi User, {{\Illuminate\Support\Facades\Auth::user()->name}}</h3>
        </div>
    </div>
@endsection

