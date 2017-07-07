<?php
/**
 * Created by PhpStorm.
 * User: Hyeonsik Cho
 * Date: 2017-07-07
 * Time: 오후 2:34
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetDesignOrders extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Design/Designs_model');
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
        $param['group_id'] = $this->Users_model->getGroupIDfromToken($param['token']);

        $json['orders'] = $this->Designs_model->getDesignOrders($param);
        $json['value'] = 'successed';
        $this->response(array('result' => $json));
    }
}