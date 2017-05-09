<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017-05-09
 * Time: 오후 5:29
 */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class AddCustomer extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User/Users_model');
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
        $json = array();
        $json['newtoken'] = parent::checkIfValidToken($param['token']);
        $param['GroupID'] = $this->Users_model->getGroupIDfromToken($param['token']);

        if($this->Customers_model->InsertCustomer($param)) {
            $json['value'] = 'successed';
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $this->response(array('result' => $json));
        }
    }
}