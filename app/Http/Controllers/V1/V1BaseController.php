<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\BackendService;
use Illuminate\Validation\UnauthorizedException;

class V1BaseController extends Controller
{
	protected $api;

	public function __construct(BackendService $backend_service ) {
		$this->api = $backend_service;
		$this->middleware(function ($request, $next) {
			if(session()->has('auth')){
				$this->api->setToken(session('auth')['accessToken']);
			}
			return $next($request);
		});
	}

	protected function permitted($route){
		if(session()->has('user.routePermissions')){
			if(in_array($route, array_keys(session()->get('user.routePermissions')))){
				return;
			}
		}
		throw new UnauthorizedException('You are not authorized, please check your permissions');
	}

	protected function isPermitted($route){
		if(session()->has('user.routePermissions')){
			if(in_array($route, array_keys(session()->get('user.routePermissions')))){
				return true;
			}
		}
		return false;
	}

}
