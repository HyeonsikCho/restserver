<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-02
 * Time: ¿ÀÀü 2:03
 */

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class SearchAddress extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
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

        $this->load->view('searchAddress.html');
    }
}