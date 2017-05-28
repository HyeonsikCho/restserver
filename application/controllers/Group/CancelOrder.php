<?php

/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-05-28
 * Time: ¿ÀÈÄ 5:02
 */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class CancelOrder extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Group/Groups_model');
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

    public function send($param)
    {
        $json = array();
        $json['newtoken'] = parent::checkIfValidToken($param['token']);
        $param['GroupID'] = $this->Users_model->getGroupIDfromToken($param['token']);

        //unset($param['token']);

        if($this->Groups_model->CancelOrder($param)) {
            $json['value'] = 'success';
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'fail';
            $this->response(array('result' => $json));
        }
    }
}