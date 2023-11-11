<?php
class Vendor_vital_model extends CI_Model{
    public function queryVital($params = array()){
            $dt     =   array(
                            "vital_open"         =>  "1",
                            "vital_status"       =>  "1"
                        );
            $sel    =   "*";
            if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
            }
            if(array_key_exists("columns",$params)){
                    $sel    =   $params["columns"];
            }
            $this->db->select("$sel")
                        ->from('vital_medications')
                        ->where($dt); 
            if(array_key_exists("keywords",$params)){
              $this->db->where("(vital_diagnosis LIKE '%".$params["keywords"]."%' or vital_cheif_complaints LIKE '%".$params["keywords"]."%' or	vital_illness LIKE '%".$params["keywords"]."%' or vital_past_history LIKE '%".$params["keywords"]."%' or vital_drug_historyLIKE '%".$params["keywords"]."%' or vital_immunisations LIKE '%".$params["keywords"]."%' or vital_family_history LIKE '%".$params["keywords"]."%' or vital_personal_history  LIKE '%".$params["keywords"]."%' or vital_general_examination  LIKE '%".$params["keywords"]."%' or vital_systematic_examination LIKE '%".$params["keywords"]."%' or vital_provisional_diagonsis LIKE '%".$params["keywords"]."%' or vital_investigations  LIKE '%".$params["keywords"]."%' or vital_remarks )");
            }
            if(array_key_exists("whereCondition",$params)){
                    $this->db->where("(".$params["whereCondition"].")");
            }
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
            }
            if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                    $this->db->order_by($params['tipoOrderby'],$params['order_by']);
            } 
          //  $this->db->get();echo $this->db->last_query();exit;
            return $this->db->get();
    }
    public function cntviewVital($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->queryVital($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
    }
    public function viewVital($params = array()){
        return $this->queryVital($params)->result_array();
    }
    public function getVital($params = array()){
        return $this->queryVital($params)->row_array();
    }
}