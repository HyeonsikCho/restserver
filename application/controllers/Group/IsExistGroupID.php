<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-05-06
 * Time: ¿ÀÀü 11:19
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class IsExistGroupID extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Group/Groups_model');
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


    public function send($gid) {
        if($this->Groups_model->IsExistGroupID($param)) {
            $json['value'] = 'successed';
            $json['exist'] = true;
        } else {
            $json['value'] = 'successed';
            $json['exist'] = false;
        }

        $this->response(array('result' => $json));
    }
}

