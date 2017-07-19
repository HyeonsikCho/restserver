<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-17
 * Time: ¿ÀÀü 1:27
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetAllTempletes extends REST_Controller {
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

        $templetes = $this->Common_model->GetAllTempletes($param);
        if($templetes != null) {
            $json['value'] = 'successed';
            $json['templetes'] = $templetes;
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $json['templetes'] = "";
            $this->response(array('result' => $json));
        }
    }
}