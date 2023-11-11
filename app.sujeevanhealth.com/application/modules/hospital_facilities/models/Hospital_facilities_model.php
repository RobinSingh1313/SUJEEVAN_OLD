<?php

class Hospital_facilities_model extends CI_Model{
        public function create_hospital_facilities(){
                $data = array(
                        'hospital_facilities_name'                    =>  ucfirst($this->input->post('hospital_facilitiesnametype')),
                        'hospital_facilities_alias_name'              =>  $this->common_config->cleanstr($this->input->post('hospital_facilitiesnametype')),
                        "hospital_facilities_created_on"               =>  date("Y-m-d h:i:s"),
                        "hospital_facilities_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("hospital_facilities",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "hospital_facilities_id    "=> $vsp."ML"
                                );	
                        $this->db->update("hospital_facilities",$dat,"hospital_facilitiesid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewHospital_facilities($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryHospital_facilities($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewHospital_facilities($params = array()){
            return $this->queryHospital_facilities($params)->result_array();
        }
        public function getHospital_facilities($params = array()){
            return $this->queryHospital_facilities($params)->row_array();
        }
        public function update_hospital_facilities($str){
            $data = array(
                    'hospital_facilities_name'                    =>  ucfirst($this->input->post('hospital_facilitiesnametype')),
                    'hospital_facilities_alias_name'              =>  $this->common_config->cleanstr($this->input->post('hospital_facilitiesnametype')),
                    "hospital_facilities_modified_on"             =>  date("Y-m-d h:i:s"),
                    "hospital_facilities_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("hospital_facilities",$data,"hospital_facilities_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function delete_hospital_facilities($uro){
            $dta    =   array(
                "hospital_facilities_open"            =>  0, 
                "hospital_facilities_modified_on" =>    date("Y-m-d h:i:s"),
                "hospital_facilities_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("hospital_facilities",$dta,array("hospital_facilities_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "hospital_facilities_acde"       =>    $status,
                            "hospital_facilities_modified_on" =>    date("Y-m-d h:i:s"),
                            "hospital_facilities_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("hospital_facilities",$ft,array("hospital_facilities_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryHospital_facilities($params = array()){
                 $dt     =   array(
                                "hospital_facilities_open"         =>  "1",
                                "hospital_facilities_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('hospital_facilities as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(hospital_facilities_name LIKE '%".$params["keywords"]."%' OR hospital_facilities_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_hospital_facilities(){
                $str    =       $this->input->post('hospital_facilities_name');
                $pms["whereCondition"]  =   "hospital_facilities_name = '".$str."'";
                $vsp    =   $this->getHospital_facilities($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}