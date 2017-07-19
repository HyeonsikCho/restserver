<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-16
 * Time: ¿ÀÈÄ 8:21
 */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetAllStates extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common/Common_model');
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

        $states = $this->Common_model->GetAllStates($param);
        if($states != null) {
            $json['value'] = 'successed';
            $json['states'] = $states;
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $json['states'] = "";
            $this->response(array('result' => $json));
        }
    }
}