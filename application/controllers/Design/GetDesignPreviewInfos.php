<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-09
 * Time: ���� 9:48
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetDesignPreviewInfos extends REST_Controller
{
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

        $json['previewinfos'] = $this->Designs_model->getDesignPreviews($param);
        $json['value'] = 'successed';
        $this->response(array('result' => $json));
    }
}