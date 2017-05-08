<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-05-06
 * Time: ¿ÀÀü 11:29
 */


require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class IsExistMemberID extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User/Users_model');
    }

    public function index_get() {
        $id = $this->get('member_id');

        $this->send($id);
    }

    public function index_post() {
        $id = $this->post('member_id');

        $this->send($id);
    }


    public function send($id) {
        if($this->Users_model->IsExistAccount($id)) {
            $json['value'] = 'successed';
            $json['exist'] = true;
        } else {
            $json['value'] = 'successed';
            $json['exist'] = false;
        }

        $this->response(array('result' => $json));
    }
}