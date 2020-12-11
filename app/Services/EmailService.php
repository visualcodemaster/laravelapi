<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class EmailService extends  Service {

    public function multipleUserEmail()
    {
//        foreach ($emails as $email){
//            Mail::to($email)->queue(new Job());
//        }
    }
}
