<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-06
 * Time: ���� 9:24
 */

class Designs_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function GetOriginalFileDayIDX($param) {
        $today = date("Y-m-d");
        $query = $this->db->select('*')
            ->like('RegiDate', $today)
            ->get('pc_originalfile_history');

        $count = $query->num_rows();

        return $count+1;
    }

    public function getDesignHistories($param){
        $this->db->select('*');
        $this->db->from('pc_originalfile_history');
        $this->db->where('OrderIDX', $param['OrderIDX']);

        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query) {
            $orders = array();
            foreach ($query->result() as $row) {
                $order = array();
                $order["IDX"] = $row->IDX;
                $order["OrderIDX"] = $row->OrderIDX;
                $order["FileName"] = $row->FileName;
                $order["FileSize"] = $row->FileSize;
                $order["DayIDX"] = $row->DayIDX;
                $order["StorageFilePath"] = $row->StorageFilePath;
                $order["StorageFileName"] = $row->StorageFileName;
                $order["Content"] = $row->Content;
                $order["Worker"] = $row->Worker;
                $order["ProgressRate"] = $row->ProgressRate;
                $order["RegiDate"] = $row->RegiDate;

                array_push($orders, $order);
            }

            return $orders;
        } else {
            return null;
        }
    }

    public function getDesignOrders($param) {
        $this->db->select('pc_customer.Name, pc_orderlist.*');
        $this->db->from('pc_orderlist');
        $this->db->join('pc_customer', 'pc_customer.CustomerIDX = pc_orderlist.CustomerIDX', 'inner');
        $this->db->where('pc_orderlist.GroupID', $param['group_id']);

        if(in_array('kind',$param)) {
            $this->db->where('Category', $param['kind']);
        }

        if(in_array('CustomerIDX',$param)) {
            $this->db->where('CustomerIDX', $param['CustomerIDX']);
        }

        $this->db->where('OrderState', '420');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query) {
            $orders = array();
            foreach ($query->result() as $row) {
                $order = array();
                $order["Orderer"] = $row->Name;
                $order["OrderName"] = $row->OrderName;
                $order["Memo"] = $row->Memo;
                $order["OrderDate"] = $row->OrderDate;
                $order["Price"] = $row->Price;
                $order["OrderIDX"] = $row->OrderIDX;
                $order["Category"] = $row->Category;
                $order["Address1"] = $row->Address1;
                $order["Address2"] = $row->Address2;
                $order["Zipcode"] = $row->Zipcode;

                array_push($orders, $order);
            }

            return $orders;
        } else {
            return null;
        }
    }

    public function InsertOriginalFileUploadInfo($param) {
        $query = $this->db->insert('pc_originalfile_history', $param);
        $IDX = $this->db->insert_id();
        if($IDX) {
            return $IDX;
        } else {
            return false;
        }
    }

    public function OriginalFileUploadComplete($param) {
        $this->db->set('InUse', 'Y');
        $this->db->where('IDX', $param['IDX']);
        $query = $this->db->update('pc_originalfile_history');

        if($query) {
            return true;
        } else {
            return false;
        }
    }
}