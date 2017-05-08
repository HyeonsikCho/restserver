<?php

/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-04-19
 * Time: ���� 11:58
 * content : 회원가입
 */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class Signin extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User/Users_model');
    }

    public function index_get() {
        $id = $this->get('user_id');
        $pw = $this->get('user_pw');
        $group_id = $this->get('group_id');

        $this->send($group_id, $id, $pw);
    }

    public function index_post() {
        $id = $this->post('user_id');
        $pw = $this->post('user_pw');
        $group_id = $this->post('group_id');

        $this->send($group_id, $id, $pw);
    }


    public function send($group_id, $id, $pw) {
        if($this->Users_model->IsExistAccount($id)) {
            $json['value'] = 'failed';
            $json['cause'] = 'existaccount';
            $this->response(array('result' => $json));
        } else {
            $result = $this->Users_model->Signin($group_id, $id, $pw);
            if ($result) {
                $json['value'] = 'successed';
                $this->response(array('result' => $json));
            } else {

            }
        }
    }
}