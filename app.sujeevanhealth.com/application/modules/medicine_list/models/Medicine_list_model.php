<?php

class Medicine_list_model extends CI_Model{
        public function create_medicine_list(){
                $data = array(
                        'medicine_list_name'                    =>  ucfirst($this->input->post('medicine_listnametype')),
                        'medicine_list_alias_name'              =>  $this->common_config->cleanstr($this->input->post('medicine_listnametype')),
                        'medicine_brand'                        =>  ucfirst($this->input->post('medicine_brand')),
                        "medicine_list_created_on"               =>  date("Y-m-d h:i:s"),
                        "medicine_list_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("medicine_list",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "medicine_list_id    "=> $vsp."ML"
                                );	
                        $this->db->update("medicine_list",$dat,"medicine_listid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewMedicine_list($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryMedicine_list($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewMedicine_list($params = array()){
            return $this->queryMedicine_list($params)->result_array();
        }
        public function getMedicine_list($params = array()){
            return $this->queryMedicine_list($params)->row_array();
        }
        public function update_medicine_list($str){
            $data = array(
                    'medicine_list_name'                    =>  ucfirst($this->input->post('medicine_listnametype')),
                    'medicine_list_alias_name'              =>  $this->common_config->cleanstr($this->input->post('medicine_listnametype')),
                    'medicine_brand'                        =>  ucfirst($this->input->post('medicine_brand')),
                    "medicine_list_modified_on"             =>  date("Y-m-d h:i:s"),
                    "medicine_list_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("medicine_list",$data,"medicine_list_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function delete_medicine_list($uro){
            $dta    =   array(
                "medicine_list_open"            =>  0, 
                "medicine_list_modified_on" =>    date("Y-m-d h:i:s"),
                "medicine_list_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("medicine_list",$dta,array("medicine_list_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "medicine_list_acde"       =>    $status,
                            "medicine_list_modified_on" =>    date("Y-m-d h:i:s"),
                            "medicine_list_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("medicine_list",$ft,array("medicine_list_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryMedicine_list($params = array()){
                 $dt     =   array(
                                "medicine_list_open"         =>  "1",
                                "medicine_list_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('medicine_list as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(medicine_list_name LIKE '%".$params["keywords"]."%' OR medicine_list_acde = '".$params["keywords"]."' OR medicine_brand LIKE '%".$params["keywords"]."%'  )");
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
        public function unique_id_check_medicine_list(){
                $str    =       $this->input->post('medicine_list_name');
                $pms["whereCondition"]  =   "medicine_list_name = '".$str."'";
                $vsp    =   $this->getMedicine_list($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}