<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('backend.content.admin.admin-dashboard');
    }

    public function userDashboard()
    {
        return view('backend.content.users.users-dashboard');
    }
}
