<?php
/**
 * Created by PhpStorm.
 * User: hyeonsik
 * Date: 2017-07-06
 * Time: ¿ÀÈÄ 9:24
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

    public function InsertOriginalFileUploadInfo($param) {
        $query = $this->db->insert('pc_originalfile_history', $param);
        if($query) {
            return true;
        } else {
            return false;
        }
    }
}