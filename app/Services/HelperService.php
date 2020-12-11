<?php
namespace App\Services;

use App\ChargeMethod;
use App\DriverType;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;

class HelperService extends Service {
    /**
     * convert's hh:mm:ss time format to minutes
     * @param string $time
     * @return float|int
     */
    public function timeToMinutes(string $time){
        $time = explode(':', $time);
        return ($time[0]*60) + ($time[1]) + ($time[2]/60);
    }
}
