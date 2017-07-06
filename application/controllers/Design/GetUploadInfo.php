<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-06
 * Time: ¿ÀÈÄ 9:19
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class GetUploadInfo extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User/Users_model');
        $this->load->model('Design/Designs_model');
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

        $param['Worker'] = $this->Users_model->getIDfromToken($param['token']);
        $param['DayIDX'] = $this->Designs_model->GetOriginalFileDayIDX($param);

        $json['StorageFileName'] = $param['StorageFileName'] =
            date("Ymd") . "-" . $param['DayIDX'] . "." . pathinfo($param['FileName'], PATHINFO_EXTENSION);
        $json['StorageFilePath'] = $param['StorageFilePath'] =
            date("Ymd") . "/" . $param['DayIDX'];

        unset($param['token']);
        unset($param['GroupID']);

        if($this->Designs_model->InsertOriginalFileUploadInfo($param)) {
            $json['value'] = 'successed';
            $this->response(array('result' => $json));
        } else {
            $json['value'] = 'failed';
            $this->response(array('result' => $json));
        }
    }
}