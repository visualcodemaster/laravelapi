<?php
/**
 * All the API controllers should extend this controller
 */
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

	public function pageNotFound( Request $request ) {
		return response()->json([
			'success' => false,
			'message' => 'Page Not Found. If error persists, contact info@doorhub.io',
			'error' => [
				'PageNotFoundException' => [
					'Page not found'
				]
			]
		], 404);
    }
}
