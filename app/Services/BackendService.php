<?php
namespace App\Services;

use GuzzleHttp\Client;

class BackendService {

	private $api_url;
	private $client;
	private $headers;
	private $response;

	public function __construct() {
		$this->api_url = config('services.backend.api.url').'/'.config('services.backend.api.current_version');
		$this->headers['Accept'] = 'application/json';
		$this->initializeClient();
	}

	public function initializeClient( ) {
		$this->client = new Client([
			'base_uri' => $this->api_url.'/',
            'verify' => false,
            'headers' => $this->headers
		]);
	}

	public function get($url){
		$this->response = $this->client->request('GET', $url);
		return $this->response;
	}

    public function getWithRawRequest($url,array $data  ){
        $this->response = $this->client->request('GET', $url, [
            'json' => $data
        ]);
        return $this->response;
    }

	public function post( $url, array $data ) {
		$this->response = $this->client->request('POST', $url, [
			'json' => $data
		]);
		return $this->response;
	}

	public function put($url, array $data  ) {
		$this->response = $this->client->request('PUT', $url, [
			'json' => $data
		]);
		return $this->response;
	}

	public function patch( $url, array $data ) {
		$this->response = $this->client->request('PATCH', $url, [
			'json' => $data
		]);
		return $this->response;
	}

	public function delete( $url ) {
		$this->response = $this->client->request('DELETE', $url);
		return $this->response;
	}

	public function getDataTable($url){
		$this->response = $this->client->request('GET', $url.'?datatable=true&'.request()->getQueryString())->getBody()->getContents();
		return $this->response;
	}

	public function getContent(){
		return json_decode($this->response->getBody()->getContents(), true);
	}

	public function getResponse(  ) {
		return json_decode($this->response->getBody()->getContents());
	}

	public function getData(  ) {
		return json_decode($this->response->getBody()->getContents())->data;
	}

	public function getMessage(  ) {
		return json_decode($this->response->getBody()->getContents())->message;
	}

	public function setToken( $token ) {
		$this->headers['Authorization'] = 'Bearer '.$token;
		$this->initializeClient();
	}

	public function response(  ) {
		return $this->response;
	}
}
