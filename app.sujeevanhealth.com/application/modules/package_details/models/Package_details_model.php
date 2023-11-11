<?php

class Package_details_model extends CI_Model{
        public function create_package_details(){
                $data = array(
                        'package_id'                               =>  $this->input->post('package_id'),
                        'package_price'                            =>  $this->input->post('package_price'),
                        'package_discount'                         =>  $this->input->post('package_discount'),
                        'package_date_from'                        =>  $this->input->post('package_from'),
                        'package_date_to'                          =>  $this->input->post('package_to'),
                        "package_details_created_on"               =>  date("Y-m-d h:i:s"),
                        "package_details_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("package_details",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "package_details_id    "=> $vsp."PKD"
                                );	
                        $this->db->update("package_details",$dat,"package_detailsid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewPackage_details($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryPackage_details($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewPackage_details($params = array()){
            return $this->queryPackage_details($params)->result_array();
        }
        public function getPackage_details($params = array()){
            return $this->queryPackage_details($params)->row_array();
        }
        public function update_package_details($str){
                $data = array(
                    'package_id'                               =>  $this->input->post('package_id'),
                    'package_price'                            =>  $this->input->post('package_price'),
                    'package_discount'                         =>  $this->input->post('package_discount'),
                    'package_date_from'                        =>  $this->input->post('package_from'),
                    'package_date_to'                          =>  $this->input->post('package_to'),
                    "package_details_modified_on"             =>  date("Y-m-d h:i:s"),
                    "package_details_modified_by"             =>  $this->session->userdata("login_id")
                );
                $this->db->update("package_details",$data,"package_details_id='".$str."'");
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        public function delete_package_details($uro){
                $dta    =   array(
                    "package_details_open"            =>  0, 
                    "package_details_modified_on" =>    date("Y-m-d h:i:s"),
                    "package_details_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("package_details",$dta,array("package_details_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "package_details_acde"        =>    $status,
                            "package_details_modified_on" =>    date("Y-m-d h:i:s"),
                            "package_details_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("package_details",$ft,array("package_details_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryPackage_details($params = array()){
                 $dt     =   array(
                                "package_details_open"         =>  "1",
                                "package_details_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('package_details as pd')
                            ->join('package as p','pd.package_id = p.package_id and package_open = 1 and package_status = 1','inner')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(package_details_name LIKE '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR package_details_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_package_details(){
                $str    =       $this->input->post('package_details_name');
                $str1   =       $this->input->post('module'); 
                $pms["whereCondition"]  =   "package_details_name = '".$str."' AND package_details_module_id = '".$str1."'";
                $vsp    =   $this->getPackage_details($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}