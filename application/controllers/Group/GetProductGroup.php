<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-23
 * Time: ¿ÀÈÄ 9:04
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetProductGroup extends REST_Controller
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
        $param['group_id'] = $this->Users_model->getGroupIDfromToken($param['token']);

        $json['Products'] = $this->Groups_model->getProductGroup($param);
        $json['value'] = 'successed';
        $this->response(array('result' => $json));
    }
}