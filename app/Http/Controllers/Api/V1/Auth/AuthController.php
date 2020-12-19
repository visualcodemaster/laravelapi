<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\ApiV1Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Services\User\UserService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions;


class AuthController extends ApiV1Controller
{
	use ApiResponse;
	private $userService;



	public function __construct( UserService $userService ) {
		$this->userService = $userService;
	}


	public function login( UserLoginRequest $request ) {
		$validated = $request->validated();

		if(!Auth::attempt($validated)) {
			throw new Exceptions\BadLoginCredentialException('Login credentials are not correct');
		}else{
				$tokenResult = auth()->user()->createToken( 'ApiUserAuthAccessToken' );
				return ( new UserResource( auth()->user() ) )->additional( [
					'auth' => [
						'accessToken' => $tokenResult->accessToken,
						'tokenType'   => 'Bearer',
						'expiresAt'   => Carbon::parse(
							$tokenResult->token->expires_at
						)->toIso8601String(),
					]
				] );
			}
	}

	public function logout( Request $request ) {
		auth()->user()->token()->revoke();
		return $this->success(200, false, "You are logged out");
	}

	public function register( Request $request ) {
		$this->userService->create($request);
	}

}
