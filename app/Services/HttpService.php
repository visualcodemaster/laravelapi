<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class HttpService extends Service {

	private $response;
	public function sendRequest($method, $data) {
		try{
			$client = new Client(
				['verify' => false]
			);
			$params['headers'] = $data['headers'];
			if(isset($data['json'])){
				$params['json'] = $data['json'];
			}
			$this->response = $client->request($method, $data['url'], $params);
			return $this->response;
		}catch (RequestException $exception){
			Log::info($exception->getMessage());
			return false;
		}
	}

	public function getResponse(){
		return $this->response;
	}

	public function getResponseStatusCode(){
		return $this->response->getStatusCode();
	}

	public function getBody(  ) {
		return $this->response->getBody();
	}

	public function getContents(  ) {
		return $this->response->getBody()->getContents();
	}
}
