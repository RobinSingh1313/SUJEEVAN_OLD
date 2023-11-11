<?php

class Hospital_specialities_model extends CI_Model{
        public function create_hospital_specialities(){
                $data = array(
                        'hospital_specialities_name'                    =>  ucfirst($this->input->post('hospital_specialitiesnametype')),
                        'hospital_specialities_alias_name'              =>  $this->common_config->cleanstr($this->input->post('hospital_specialitiesnametype')),
                        "hospital_specialities_created_on"               =>  date("Y-m-d h:i:s"),
                        "hospital_specialities_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("hospital_specialities",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "hospital_specialities_id    "=> $vsp."ML"
                                );	
                        $this->db->update("hospital_specialities",$dat,"hospital_specialitiesid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewHospital_specialities($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryHospital_specialities($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewHospital_specialities($params = array()){
            return $this->queryHospital_specialities($params)->result_array();
        }
        public function getHospital_specialities($params = array()){
            return $this->queryHospital_specialities($params)->row_array();
        }
        public function update_hospital_specialities($str){
            $data = array(
                    'hospital_specialities_name'                    =>  ucfirst($this->input->post('hospital_specialitiesnametype')),
                    'hospital_specialities_alias_name'              =>  $this->common_config->cleanstr($this->input->post('hospital_specialitiesnametype')),
                    "hospital_specialities_modified_on"             =>  date("Y-m-d h:i:s"),
                    "hospital_specialities_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("hospital_specialities",$data,"hospital_specialities_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function delete_hospital_specialities($uro){
            $dta    =   array(
                "hospital_specialities_open"            =>  0, 
                "hospital_specialities_modified_on" =>    date("Y-m-d h:i:s"),
                "hospital_specialities_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("hospital_specialities",$dta,array("hospital_specialities_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "hospital_specialities_acde"       =>    $status,
                            "hospital_specialities_modified_on" =>    date("Y-m-d h:i:s"),
                            "hospital_specialities_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("hospital_specialities",$ft,array("hospital_specialities_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryHospital_specialities($params = array()){
                 $dt     =   array(
                                "hospital_specialities_open"         =>  "1",
                                "hospital_specialities_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('hospital_specialities as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(hospital_specialities_name LIKE '%".$params["keywords"]."%' OR hospital_specialities_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_hospital_specialities(){
                $str    =       $this->input->post('hospital_specialities_name');
                $pms["whereCondition"]  =   "hospital_specialities_name = '".$str."'";
                $vsp    =   $this->getHospital_specialities($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}