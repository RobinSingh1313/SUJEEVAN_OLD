<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Complaintlog_model extends CI_Model{
        public function queryComplaintlog($params = array()){
                $dt         =   array(
                                    "complaintlog_open"      =>     '1',
                                    "complaintlog_status"    =>     '1'
                            );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("complaintlog as c")
//                            ->join("region as re","re.region_id = c.complaintlog_regions and re.region_open = 1 and re.region_status = 1","inner")
                            ->where($dt);
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(complaintlog_name LIKE '%".$params["keywords"]."%' OR complaintlog_user LIKE '%".$params["keywords"]."%' OR complaintlog_loginname LIKE '%".$params["keywords"]."%' OR complaintlog_languages LIKE '%".$params["keywords"]."%'  OR complaintlog_acde LIKE '%".$params["keywords"]."%')");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                }
//                $this->db->get();echo $this->db->last_query();exit;
                return  $this->db->get();
        }
        public function cntviewComplaintlog($params  =    array()){
                $params["cnt"]      =   "1";
                $val    =   $this->queryComplaintlog($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function viewComplaintlog($params = array()){
                $vsp    =   $this->queryComplaintlog($params)->result_array();
                return $vsp;
        }
        public function getComplaintlog($params = array()){
                return $this->queryComplaintlog($params)->row_array();
        }
}