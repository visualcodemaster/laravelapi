<?php

namespace App\Exceptions;

use App\Exceptions\Traits\ExceptionResponse;
use App\Traits\ApiHelper;
use BadMethodCallException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Throwable;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response;
use Sentinel;

class Handler extends ExceptionHandler
{
	use ApiHelper;
	use ExceptionResponse;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];


	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param \Exception $exception
	 *
	 * @return void
	 * @throws \Exception
	 */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception) {

    	if($request->is('api/*')){
		    if ($exception instanceof ModelNotFoundException) {
			    return $this->ModelNotFoundException($exception);
		    }
		    if ($exception instanceof BadMethodCallException) {
			    return $this->BadMethodCallException($exception);
		    }
		    if($exception instanceof MethodNotAllowedHttpException){
			    return $this->MethodNotAllowedHttpException($exception);
		    }
		    if($exception instanceof UserNotActiveException){
			    return $this->UserNotActiveException($exception);
		    }
		    if($exception instanceof BadLoginCredentialException){
			    return $this->BadLoginCredentialException($exception);
		    }
		    if($exception instanceof SomethingWentWrongException){
			    return $this->SomethingWentWrongException($exception);
		    }
		    if($exception instanceof UnauthorizedException){
			    return $this->UnauthorizedException($exception);
		    }
		    if($exception instanceof ResourceAlreadyExistsException){
			    return $this->ResourceAlreadyExistsException($exception);
		    }
		    if($exception instanceof AuthorizationException){
				return $this->AuthorizationException($exception);
		    }
		    if($exception instanceof QueryException){
		    	return $this->QueryException($exception);
		    }
		    if($exception instanceof AuthenticationException){
			    return $this->AuthenticationException($exception);
		    }
            if($request->is('api/v1/driver/*')) {
                if ($exception instanceof ValidationException) {
                    return response()->json(['success' => false, 'message' => $exception->validator->getMessageBag()->first(), 'errors' => $exception->validator->getMessageBag()], 422);
                }
            }
            if($exception instanceof BadRequestHttpException){
            	return $this->BadRequestHttpException($exception);
            }
	    }
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }
        if($exception instanceof ClientException){
	        return $this->ClientException($exception);
        }
        if($exception instanceof ValidationException){
	        return response()->json(['message' => $exception->validator->getMessageBag()->first(), 'errors' => $exception->validator->getMessageBag()], 422);
        }

	    if($exception instanceof UnauthorizedException){

		    return response()->view('errors.admin.403', ['exception' => $exception], 403);
	    }
		/*if($exception instanceof ThrottlingException){
			dd('dir');
		}*/

        return parent::render($request, $exception);

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

	private function ClientException($exception){
		$response = json_decode($exception->getResponse()->getBody(true)->getContents());
		//toastr()->error($response->message);

		if($response->message == 'Unauthenticated'){
			auth()->guard()->logout();
			request()->session()->invalidate();
			return redirect()->guest(route('login'));
		}

		if($exception->getResponse()->getStatusCode() == 403){
			if($exception->getMessage()){
				throw new UnauthorizedException($exception->getMessage());
			}else{
				throw new UnauthorizedException('You are not authorized, please check your permissions');
			}

		}

		return Redirect::back()->with(['error' => $response])->withInput();
	}


}
