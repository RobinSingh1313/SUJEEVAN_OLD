<?php

class Package_model extends CI_Model{
        public function create_package(){
                $data = array(
                        'package_name'                    =>  ucfirst($this->input->post('packagenametype')),
                        'package_alias_name'              =>  $this->common_config->cleanstr($this->input->post('packagenametype')),
                        "package_created_on"               =>  date("Y-m-d h:i:s"),
                        "package_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("package",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "package_id    "=> $vsp."PK"
                                );	
                        $this->db->update("package",$dat,"packageid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewPackage($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryPackage($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewPackage($params = array()){
            return $this->queryPackage($params)->result_array();
        }
        public function getPackage($params = array()){
            return $this->queryPackage($params)->row_array();
        }
        public function update_package($str){
            $data = array(
                    'package_name'                    =>  ucfirst($this->input->post('packagenametype')),
                    'package_alias_name'              =>  $this->common_config->cleanstr($this->input->post('packagenametype')),
                    "package_modified_on"             =>  date("Y-m-d h:i:s"),
                    "package_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("package",$data,"package_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function delete_package($uro){
            $dta    =   array(
                "package_open"            =>  0, 
                "package_modified_on" =>    date("Y-m-d h:i:s"),
                "package_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("package",$dta,array("package_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "package_acde"       =>    $status,
                            "package_modified_on" =>    date("Y-m-d h:i:s"),
                            "package_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("package",$ft,array("package_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryPackage($params = array()){
                 $dt     =   array(
                                "package_open"         =>  "1",
                                "package_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('package as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(package_name LIKE '%".$params["keywords"]."%' OR package_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_package(){
                $str    =       $this->input->post('package_name');
                $pms["whereCondition"]  =   "package_name = '".$str."'";
                $vsp    =   $this->getPackage($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}