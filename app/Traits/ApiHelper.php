<?php

namespace App\Traits;


use Carbon\Carbon;
use http\Env\Request;

trait ApiHelper
{
    public function successResponse($code, $data, $message = false, $extra = false)
    {
	    $result = [
		    'success' => true,
		    'message' => $message,
		    'data' => $data,
	    ];
        if($extra){
		    foreach ($extra as $key => $value){
			    $result[$key] = $value;
		    }
        }
	    return response()->json($result, $code);
    }

    public function errorResponse($code, $data=false, $message = false, $extra = false)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $data
        ], $code);
    }

	/*public function mappingArray($array, $key, $value = false) {
		$mappingArray = array();
		if(is_array($array)) {
			if ($value) {
				foreach ($array as $elements) {
					$mappingArray[$elements[$key]] = $elements[$value];
				}
			} else {

				foreach ($array as $elements) {
					$mappingArray[$elements[$key]] = $elements;
				}
			}
		}
		return $mappingArray;
	}*/
	public function getApiKey( $request ) {
		$apiKey = null;
		if($request->bearerToken()){
			$apiKey = $request->bearerToken();
		}else if($request->header('X-Api-Key')){
			if(strpos($request->header('X-Api-Key'),'Bearer') === 0){
				$apiKey = explode(' ', $request->header('X-Api-Key'))[1];
			}else{
				$apiKey = $request->header('X-Api-Key');
			}
			//$apiKey = $request->header('X-Api-Key');
			/*dd($apiKey);*/
		}else if($request->header('X-Verify-Token')){
			$apiKey = $request->header('X-Verify-Token');
		}
		else{
			$apiKey = $request->header('Authorization');
		}
		return $apiKey;
	}

    /**
     * Fetching api token from WebShipper payload
     *
     * @param $request
     * @return mixed|string
     */
    public function getApiKeyWebShipper($request)
    {
        $apiKey = null;
        if ($request->carrier_attributes) {
            if($request->carrier_attributes['api_token']) {
                $apiKey = $request->carrier_attributes['api_token'];
            }
        }
        return $apiKey;
    }

	/**
	 * @param $time
	 *
	 * @return false|float
	 */
	public function toMinutes($time) {
		$hours = intval(Carbon::parse($time)->format('H'));
		$minutes = intval(Carbon::parse($time)->format('i'));
		$seconds = intval(Carbon::parse($time)->format('s'));

		return round( $hours * 60 + $minutes + $seconds / 60, 2);
	}
}
