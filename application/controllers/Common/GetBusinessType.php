<?php
/**
 * Created by PhpStorm.
 * User: Hyeonsik Cho
 * Date: 2017-06-01
 * Time: ¿ÀÈÄ 11:17
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetBusinessType extends REST_Controller {
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

        $businesstype = $this->Common_model->GetBusinessType($param);
        if($businesstype != null) {
            $json['value'] = 'successed';
            $json['businesstype'] = $businesstype;
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $json['businesstype'] = "";
            $this->response(array('result' => $json));
        }
    }
}