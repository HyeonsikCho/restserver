<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-05-10
 * Time: ¿ÀÈÄ 11:53
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetCustomers extends REST_Controller {

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

        unset($param['token']);

        $customers = $this->Customers_model->GetCustomers($param);

        if($customers != null) {
            $json['value'] = 'successed';
            $json['customers'] = $customers;
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $json['customers'] = "";
            $this->response(array('result' => $json));
        }
    }
}