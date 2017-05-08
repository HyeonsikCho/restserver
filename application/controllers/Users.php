<?php

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class Users extends REST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('User/Users_model');
	}

	public function index_get() {
		$token = JWT::decode($this->get('token'),"hyeonsik", array('HS256'));
		$this->response(array('result' => $token->id));
	}
}


