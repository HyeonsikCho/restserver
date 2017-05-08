<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017-04-20
 * Time: 오후 1:59
 * Content : 회원정보 수정
 */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class UserInfoUpdate extends REST_Controller
{
    public function __construct()
    {
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
        $json = array();
        $json['newtoken'] = parent::checkIfValidToken($param['token']);

        $param['ID'] = $this->Users_model->getIDfromToken($param['token']);

        if ($this->Users_model->UserInfoUpdate($param) == true) {
            $json['value'] = 'successed';
        } else {
            $json['value'] = 'failed';
        }

        $this->response(array('result' => $json), 200);
    }
}
