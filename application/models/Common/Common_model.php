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