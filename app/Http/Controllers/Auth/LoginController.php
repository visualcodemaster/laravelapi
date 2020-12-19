<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\BackendService;
use App\Traits\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function login(Request $request) {


        // Validation
        $validation = Validator::make( $request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ] );

        if ( $validation->fails() ) {
            return Redirect::back()->withErrors( $validation )->withInput();
        }
        $remember = ($request->remember == 'on') ? true : false;

        if ($user = Auth::attempt($validation->validated(), $remember)) {
            $authuser = auth()->user()->load('roles');
            $permissions = json_decode($authuser->roles->first()->permissions,true);
            session(['permissions' => $permissions]);
            // for api auth need the accessToken and save it to the local storage
            $backendService = new BackendService();
            $response = $backendService->post('login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if($response->getStatusCode() == 200){

                $userData = $backendService->getContent();
                session(['auth' => $userData['auth']]);
                $userDetails = $userData['data'];
                session(['user' => $userDetails]);
                return redirect(route('home.index'));
            }
        }

        return Redirect::back()->withErrors(['global' => 'Invalid password or this user does not exist' ]);

    }


    protected function logout(Request $request) {


        $backendService = new BackendService();
        $response = $backendService->post('logout', []);

        if($response->getStatusCode() == 200){
            session()->forget(['auth', 'user']);
            session()->save();

            auth()->guard()->logout();
            $request->session()->invalidate();

            return redirect(route('login'));
        }
    }
}
