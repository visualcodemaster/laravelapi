<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() ==true) {
            $users = User::all();
            return DataTables::of($users)
                ->addColumn('action', function ($user) {
                    $url = route('users.edit',$user->id);
                    $urlAttachRole = route('users.attach.role.index',$user->id);
                    return "
                            <a href='$url' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit</a>
                            <a href='$urlAttachRole' class='btn btn-xs btn-primary'><i class='flaticon flaticon-attachment'></i> Attach Role</a>
                            ";
                })
                ->make(true);
        }
        return view('backend.content.user_management.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('backend.content.user_management.users.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
         $user  = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);
        $user->roles()->attach(2);
        return redirect(route('users.index'))->with('success','User Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('backend.content.user_management.users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password')?Hash::make(request('password')) : $user->password;
        $user->save();
        return redirect(route('users.index'))->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
