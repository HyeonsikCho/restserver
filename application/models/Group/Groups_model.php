<?php

/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-04-30
 * Time: ���� 11:09
 */
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Groups_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function SelectGroups($param) {
        $query = $this->db->select('GroupID')
            ->like('GroupID', $param['keyword'], 'both')
            ->where('MemberID', $param['ID'])
            ->distinct()
            ->get('pc_group');

        if($query) {
            $result = array();
            $i = 0;
            foreach ($query->result() as $row)
            {
                $result[$i++] = $row->GroupID;
            }
            return $result;
        } else {
            return null;
        }
    }

    public function getCompleteOrders($param)
    {
        $this->db->select('*');
        $this->db->from('pc_orderlist');
        $this->db->where('GroupID', $param['group_id']);
        $this->db->where('CustomerIDX', $param['CustomerIDX']);
        $this->db->where('OrderState', '620');
        $query = $this->db->get();

        if ($query) {
            $orders = array();
            foreach ($query->result() as $row) {
                $order = array();
                $order["OrderName"] = $row->OrderName;
                $order["Memo"] = $row->Memo;
                $order["OrderDate"] = $row->OrderDate;
                $order["Price"] = $row->Price;
                $order["OrderIDX"] = $row->OrderIDX;
                $order["Category"] = $row->Category;

                array_push($orders, $order);
            }

            return $orders;
        } else {
            return null;
        }

        return $query->result();
    }

    public function getOrders($param) {
        $this->db->select('pc_orderlist.*, pc_customer.*, pc_category.Name as Category');
        $this->db->from('pc_orderlist');
        $this->db->join('pc_customer', 'pc_customer.CustomerIDX = pc_orderlist.CustomerIDX', 'inner');
        $this->db->join('pc_category', 'pc_orderlist.Category = pc_category.ID', 'inner');
        $this->db->where('pc_customer.GroupID', $param['group_id']);
        $this->db->where('pc_orderlist.OrderState', '320');

        $query = $this->db->get();

        if($query) {
            $result = array();
            $orders = array();
            $i = 0;

            foreach ($query->result() as $row)
            {
                if(!array_key_exists($row->CustomerIDX, $result)) {
                    $result[$row->CustomerIDX]["Name"] = $row->Name;
                    $result[$row->CustomerIDX]["Address1"] = $row->Address1;
                    $result[$row->CustomerIDX]["Address2"] = $row->Address2;
                    $result[$row->CustomerIDX]["HP"] = $row->HP;
                    $result[$row->CustomerIDX]["Point"] = $row->Point;
                    $result[$row->CustomerIDX]["Orders"] = array();
                }

                $order = array();
                $order["OrderName"] = $row->OrderName;
                $order["Memo"] = $row->Memo;
                $order["OrderDate"] = $row->OrderDate;
                $order["Price"] = $row->Price;
                $order["OrderIDX"] = $row->OrderIDX;
                $order["Category"] = $row->Category;
                $order["Orderer"] = $row->Name;

                array_push($result[$row->CustomerIDX]["Orders"], $order);
            }

            return $result;
        } else {
            return null;
        }

        return $query->result();
    }

    public function addOrder($param) {
        $query = $this->db->insert('pc_orderlist', $param);

        if($query) {
            return true;
        } else {
            return false;
        }
    }

    public function cancelOrder($param) {
        $this->db->set('OrderState', '999');
        $this->db->where('OrderIDX', $param['OrderIDX']);
        $query = $this->db->update('pc_orderlist');

        if($query) {
            return true;
        } else {
            return false;
        }
    }

    public function payConfirmOrder($param) {
        $this->db->set('OrderState', '420');
        $this->db->where('OrderIDX', $param['OrderIDX']);
        $query = $this->db->update('pc_orderlist');

        if($query) {
            return true;
        } else {
            return false;
        }
    }

    public function deliveryCompleteOrder($param) {
        $this->db->set('OrderState', '620');
        $this->db->where('OrderIDX', $param['OrderIDX']);
        $query = $this->db->update('pc_orderlist');

        if($query) {
            return true;
        } else {
            return false;
        }
    }

    public function IsExistGroupID($gid) {
        $query = $this->db->select('count(*) as cnt')
            ->where('GroupID', $gid)
            ->get('pc_group');

        if($query->row()->cnt == 1)
        {
            return true;
        } else {
            return false;
        }
    }
}