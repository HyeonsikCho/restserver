<?php

/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-04-19
 * Time: ???? 11:40
 * Content : ·Î±×ÀÎ
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class SelectGroups extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User/Users_model');
        $this->load->model('Group/Groups_model');
    }

    public function index_get() {
        $param = array();
        foreach ($this->get() as $key => $value) {
            $param[$key] = $this->input->get($key);
        }

        $this->send($param);
    }

    public function index_post() {
        $param = array();
        foreach ($this->post() as $key => $value) {
            $param[$key] = $this->input->post($key);
        }

        $this->send($param);
    }

    public function send($param) {
        $json = array();
        $json['newtoken'] = parent::checkIfValidToken($param['token']);

        $param['ID'] = $this->Users_model->getIDfromToken($param['token']);

        $json['group'] = $this->Groups_model->SelectGroups($param);

        $json["code"] = "0000";
        $json["value"] = "succeeded";
        $this->response(array('result' => $json), 200);
    }
}