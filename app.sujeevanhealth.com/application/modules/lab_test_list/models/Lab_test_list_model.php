<?php

class Lab_test_list_model extends CI_Model{
        public function create_lab_test_list(){
                $data = array(
                        'lab_test_list_name'                    =>  ucfirst($this->input->post('lab_test_listnametype')),
                        'lab_test_list_alias_name'              =>  $this->common_config->cleanstr($this->input->post('lab_test_listnametype')),
                        'lab_test_price'                        =>  $this->input->post('lab_test_price'),
                        "lab_test_list_created_on"               =>  date("Y-m-d h:i:s"),
                        "lab_test_list_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("lab_test_list",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "lab_test_list_id    "=> $vsp."ML"
                                );	
                        $this->db->update("lab_test_list",$dat,"lab_test_listid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewLab_test_list($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryLab_test_list($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewLab_test_list($params = array()){
            return $this->queryLab_test_list($params)->result_array();
        }
        public function getLab_test_list($params = array()){
            return $this->queryLab_test_list($params)->row_array();
        }
        public function update_lab_test_list($str){
            $data = array(
                    'lab_test_list_name'                    =>  ucfirst($this->input->post('lab_test_listnametype')),
                    'lab_test_list_alias_name'              =>  $this->common_config->cleanstr($this->input->post('lab_test_listnametype')),
                    'lab_test_price'                        =>  $this->input->post('lab_test_price'),
                    "lab_test_list_modified_on"             =>  date("Y-m-d h:i:s"),
                    "lab_test_list_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("lab_test_list",$data,"lab_test_list_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function delete_lab_test_list($uro){
            $dta    =   array(
                "lab_test_list_open"            =>  0, 
                "lab_test_list_modified_on" =>    date("Y-m-d h:i:s"),
                "lab_test_list_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("lab_test_list",$dta,array("lab_test_list_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "lab_test_list_acde"       =>    $status,
                            "lab_test_list_modified_on" =>    date("Y-m-d h:i:s"),
                            "lab_test_list_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("lab_test_list",$ft,array("lab_test_list_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryLab_test_list($params = array()){
                 $dt     =   array(
                                "lab_test_list_open"         =>  "1",
                                "lab_test_list_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('lab_test_list as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(lab_test_list_name LIKE '%".$params["keywords"]."%' OR lab_test_list_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_lab_test_list(){
                $str    =       $this->input->post('lab_test_list_name');
                $pms["whereCondition"]  =   "lab_test_list_name = '".$str."'";
                $vsp    =   $this->getLab_test_list($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}