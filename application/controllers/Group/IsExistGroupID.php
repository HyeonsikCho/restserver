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

    public function index_get() {
        $gid = $this->get('group_id');

        $this->send($gid);
    }

    public function index_post() {
        $gid = $this->post('group_id');

        $this->send($gid);
    }


    public function send($gid) {
        if($this->Groups_model->IsExistGroupID($gid)) {
            $json['value'] = 'successed';
            $json['exist'] = true;
        } else {
            $json['value'] = 'successed';
            $json['exist'] = false;
        }

        $this->response(array('result' => $json));
    }
}

