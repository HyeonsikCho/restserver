<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-26
 * Time: ¿ÀÀü 12:28
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class UpdateSpecInfos extends REST_Controller
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

    public function send($param) {
        $json = array();
        $json['newtoken'] = parent::checkIfValidToken($param['token']);

        $json['Sizes'] = $this->Groups_model->updateSpecInfos($param);
        $json['value'] = 'successed';
        $this->response(array('result' => $json));
    }
}