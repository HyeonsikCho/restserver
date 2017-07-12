<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-06-01
 * Time: ¿ÀÀü 12:29
 */

require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function GetAllCategories() {
        $this->db->select('*');
        $query = $this->db->get('pc_category');

        if($query) {
            $result = array();

            foreach ($query->result() as $row)
            {
                $info = array(
                    'ID'=>$row->ID,
                    'Name'=>$row->Name
                );
                array_push($result, $info);
            }

            return $result;
        } else {
            return false;
        }
    }

    public function GetBusinessType($param) {
        $this->db->select('BusinessType');
        $this->db->where('Category', $param['category']);
        $query = $this->db->get('pc_image_category');

        if($query) {
            $result = array();

            foreach ($query->result() as $row)
            {
                $info = array(
                    'BusinessType'=>$row->BusinessType
                );
                array_push($result, $info);
            }

            return $result;
        } else {
            return false;
        }
    }

    public function UpdateOrderInfo($param) {
        if(array_key_exists('OrderName', $param))
            $this->db->set('OrderName', $param['OrderName']);

        if(array_key_exists('Zipcode', $param))
            $this->db->set('Zipcode', $param['Zipcode']);

        if(array_key_exists('Address1', $param))
            $this->db->set('Address1', $param['Address1']);

        if(array_key_exists('Address2', $param))
            $this->db->set('Address2', $param['Address2']);

        if(array_key_exists('Price', $param))
            $this->db->set('Price', $param['Price']);

        if(array_key_exists('Memo', $param))
            $this->db->set('Memo', $param['Memo']);

        if(array_key_exists('Category', $param))
            $this->db->set('Category', $param['Category']);

        if(array_key_exists('IsPayed', $param)) {
            $this->db->set('IsPayed', $param['IsPayed']);
            $this->db->set('OrderState', '420');
        }


        $this->db->where('OrderIDX', $param['OrderIDX']);

        return $this->db->update('pc_orderlist');
    }

    public function GetTempleteImage($param) {
        $this->db->select('*');
        $this->db->where('category', $param['category']);
        //$this->db->where('businesstype', $param['businesstype']);
        $query = $this->db->get('pc_templete_image', 30);

        if($query) {
            $result = array();

            foreach ($query->result() as $row)
            {
                $info = array(
                    'name'=>$row->name,
                    'category'=>$row->category,
                    'businesstype'=>$row->businesstype,
                    'path'=>$row->path,
                    'size'=>$row->size,
                    'ext'=>$row->ext,
                    'DPJumunNo'=>$row->DPJumunNo,
                    'size'=>$row->size,
                    'price'=>$row->price
                );
                array_push($result, $info);
            }

            return $result;
        } else {
            return false;
        }
    }
}