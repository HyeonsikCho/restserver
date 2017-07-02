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

    public function UpdateCustomer($param) {
        $this->db->where('CustomerIDX', $param['CustomerIDX']);
        $query = $this->db->update('pc_customer', $param);

        if($query) {
            return true;
        } else {
            return false;
        }
    }

    public function GetCustomers($param) {
        $this->db->select('*');
        $this->db->where('GroupID', $param['GroupID']);
        $this->db->like('Name', $param['keyword']);
        $query = $this->db->get('pc_customer');

        if($query) {
            $result = array();

            foreach ($query->result() as $row)
            {
                $info = array(
                    'CustomerIDX'=>$row->CustomerIDX,
                    'Name'=>$row->Name,
                    'HP' => $row->HP,
                    'Address1' => $row->Address1,
                    'Address2' => $row->Address2,
                    'Memo' => $row->Memo,
                    'Zipcode' => $row->Zipcode
                );
                array_push($result, $info);
            }

            return $result;
        } else {
            return null;
        }
    }
}