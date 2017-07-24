<?php

/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-04-19
 * Time: ���� 11:40
 * Content : 로그인
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class Login extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User/Users_model');
    }

    public function index_get()
    {
        $param = array();
        foreach ($this->get() as $key => $value) {
            $param[$key] = $this->input->get($key);
        }

        $this->send($param);
    }

    public function index_post()
    {
        $param = array();
        foreach ($this->post() as $key => $value) {
            $param[$key] = $this->input->post($key);
        }

        $this->send($param);
    }

    public function send($param) {
        $invalidLogin = ['invalid' => $param['user_id']];
        $token = $this->Users_model->Login($param);

        if($token) {
            $json["code"] = "0000";
            $json["value"] = "succeeded";
            $json["token"] = $token['id_token'];
            $json["name"] = $token['name'];
            $this->set_response($token, REST_Controller::HTTP_OK);
            $this->response(array('result' => $json), 200);
        } else {
            $json["code"] = "1111";
            $json["value"] = "failed";
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
            $this->response(array('result' => $json), 200);
        }
    }
}