<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017-05-09
 * Time: 오후 5:30
 */
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Customers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function InsertCustomer($param) {
        $query = $this->db->insert('pc_customer', $param);

        if($query) {
            return true;
        } else {
            return false;
        }
    }
}