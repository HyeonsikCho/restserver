<?php
/**
 * Created by PhpStorm.
 * User: Hyeonsik Cho
 * Date: 2017-07-17
 * Time: 오전 10:58
 */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetPreviewInfos extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Design/Designs_model');
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

        $previews = $this->Designs_model->GetPreviewInfos($param);
        if($previews != null) {
            $json['value'] = 'successed';
            $json['previews'] = $previews;
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $json['previews'] = "";
            $this->response(array('result' => $json));
        }
    }
}