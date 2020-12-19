<?php


namespace App\Exceptions\Traits;


use App\Exceptions\BadLoginCredentialException;
use App\Exceptions\ResourceAlreadyExistsException;
use App\Exceptions\SomethingWentWrongException;
use App\Exceptions\UserNotActiveException;
use BadMethodCallException;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionResponse {
	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Auth\AuthenticationException  $exception
	 * @return \Illuminate\Http\Response
	 */
	private function AuthenticationException(AuthenticationException $exception)
	{
		return $this->CommonErrorExceptionResponse(
			'AuthenticationException',
			'Unauthenticated',
			array('You are not authenticated',
				$exception->getMessage()
			),
			array('Please login to the system', 'Check if your account is activated'),
			401
		);

	}

	/**
	 * @param \Illuminate\Database\Eloquent\ModelNotFoundException $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	private function ModelNotFoundException(ModelNotFoundException $exception){
		return $this->CommonErrorExceptionResponse(
			'ModelNotFoundException',
			'Resource for '.str_replace('App\\Model\\', '', $exception->getModel()).' not found',
			array('Model resource for '. $exception->getModel() .' not found',
				$exception->getMessage()
			),
			array('Check if the resource is available'),
			404
		);

	}

	/**
	 *
	 * @param \BadMethodCallException $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	private function BadMethodCallException(BadMethodCallException $exception) {

		return $this->CommonErrorExceptionResponse(
			'BadMethodCallException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Methods does not found'),
			500
		);

	}

	/**
	 * @param \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	private function MethodNotAllowedHttpException(MethodNotAllowedHttpException $exception ) {
		return $this->CommonErrorExceptionResponse(
			'MethodNotAllowedHttpException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Use only the allowed methods'),
			405
		);
	}

	private function UnauthorizedException(UnauthorizedException $exception) {
		return $this->CommonErrorExceptionResponse(
			'UnauthorizedException',
			'You do not have proper permission to perform this task',
			array($exception->getMessage()),
			array('Please check if you have the proper permissions'),
			403
		);
	}

	private function AuthorizationException(AuthorizationException $exception){
		return $this->CommonErrorExceptionResponse(
			'UnauthorizedException',
			'You do not have proper permission to perform this task',
			array($exception->getMessage()),
			array('Please check if you have the proper permissions'),
			403
		);
	}
	private function AccessDeniedHttpException(AccessDeniedHttpException $exception){
		return $this->CommonErrorExceptionResponse(
			'UnauthorizedException',
			'You do not have proper permission to perform this task',
			array($exception->getMessage()),
			array('Please check if you have the proper permissions'),
			403
		);
	}

	private function UserNotActiveException(UserNotActiveException $exception){
		return $this->CommonErrorExceptionResponse(
			'UserNotActiveException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Please check if your account is properly activated'),
			401
		);
	}

	private function BadLoginCredentialException(BadLoginCredentialException $exception){
		return $this->CommonErrorExceptionResponse(
			'BadLoginCredentialException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Please check the login credentials'),
			401
		);
	}

	private function SomethingWentWrongException(SomethingWentWrongException $exception) {
		return $this->CommonErrorExceptionResponse(
			'SomethingWentWrongException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Please try again or contact info@doorhub.io if error persist!'),
			500
		);
	}

	private function ResourceAlreadyExistsException(ResourceAlreadyExistsException $exception ) {
		return $this->CommonErrorExceptionResponse(
			'ResourceAlreadyExistsException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Please check your payload data again'),
			409
		);
	}
	private function CommonErrorExceptionResponse($exceptionName, $message, $messages, $suggestions, $code){
		return response()->json([
			'message' => $message,
			'errors' => [
				$exceptionName => [
					'messages'    => $messages,
					'suggestions' => $suggestions
				]
			]
		], $code);
	}

	private function QueryException(QueryException $exception){
		return $this->CommonErrorExceptionResponse(
			'ResourceAlreadyExistsException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Please check your payload data again'),
			409
		);
	}

	private function BadRequestHttpException(BadRequestHttpException $exception){
		return $this->CommonErrorExceptionResponse(
			'BadRequestHttpException',
			$exception->getMessage(),
			array($exception->getMessage()),
			array('Please check your payload data again'),
			400
		);
	}
}
