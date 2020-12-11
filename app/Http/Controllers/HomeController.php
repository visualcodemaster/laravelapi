<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if(!empty($user) ){
            if($user->roles()->first()->slug == 'superadmin') {
                return redirect()->route('admin.dashboard');
            }
            else {
                return redirect()->route('users.dashboard');
            }
        }
        return redirect()->route('landing');
    }
}
