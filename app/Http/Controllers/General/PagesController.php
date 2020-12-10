<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function landing()
    {
        return view('frontend.content.pages.home');
    }
    public function entertainment()
    {
        return view('frontend.content.pages.entertainment');
    }
    public function tech()
    {
        return view('frontend.content.pages.tech');
    }
    public function fashion()
    {
        return view('frontend.content.pages.fashion');
    }
    public function lifestyle()
    {
        return view('frontend.content.pages.lifestyle');
    }
    public function health()
    {
        return view('frontend.content.pages.health');
    }
    public function food()
    {
        return view('frontend.content.pages.food');
    }
    public function vlogs()
    {
        return view('frontend.content.pages.vlogs');
    }
    public function travel()
    {
        return view('frontend.content.pages.travel');
    }
}
