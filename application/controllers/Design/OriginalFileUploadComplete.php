<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-07
 * Time: 오전 11:35
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;


class OriginalFileUploadComplete extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User/Users_model');
        $this->load->model('Design/Designs_model');
        $this->load->model('Customer/Customers_model');
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
        $json['newtoken'] = parent::checkIfValidToken($param['token']);
        $param['GroupID'] = $this->Users_model->getGroupIDfromToken($param['token']);

        if($this->Designs_model->OriginalFileUploadComplete($param)) {
            $json['value'] = 'successed';
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $this->response(array('result' => $json));
        }
    }
}