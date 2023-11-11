<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Specialization_model extends CI_Model{
        public function create_specialization(){
                $data = array(
                        'specialization_name'                    =>  ucfirst($this->input->post('specialization_name')),
                        'specialization_alias_name'              =>  $this->input->post('specialization_name'),
                        'specialization_order'                   => $this->input->post('specialization_order'),
                        "specialization_created_on"               =>  date("Y-m-d h:i:s"),
                        "specialization_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("specialization",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "specialization_id    "=> $vsp."VT"
                                );	
                    $this->db->update("specialization",$dat,"specializationid='".$vsp."'");
                    return true;   
                }
                return false;
        }
        public function cntviewSpecialization($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querySpecialization($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewSpecialization($params = array()){
            return $this->querySpecialization($params)->result_array();
        }
        public function getSpecialization($params = array()){
            return $this->querySpecialization($params)->row_array();
        }
        public function update_specialization($str){
            $data = array(
                    'specialization_name'                    =>  ucfirst($this->input->post('specialization_name')),
                    'specialization_alias_name'              =>  $this->input->post('specialization_name'),
                    "specialization_modified_on"             =>  date("Y-m-d h:i:s"),
                    "specialization_order"                   =>  $this->input->post('specialization_order'),   
                    "specialization_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("specialization",$data,"specialization_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
        public function delete_specialization($uro){
                $dta    =   array(
                    "specialization_open"        =>    0, 
                    "specialization_modified_on" =>    date("Y-m-d h:i:s"),
                    "specialization_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("specialization",$dta,array("specialization_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "specialization_acde"        =>    $status,
                            "specialization_modified_on" =>    date("Y-m-d h:i:s"),
                            "specialization_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("specialization",$ft,array("specialization_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function querySpecialization($params = array()){
                 $dt     =   array(
                                "specialization_open"         =>  "1",
                                "specialization_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('specialization as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(specialization_name LIKE '%".$params["keywords"]."%' OR specialization_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_specialization(){
                $str    =       $this->input->post('specialization_name');
                $sid    =       $this->input->post('specialization_id');
                $pms["whereCondition"]  =   "specialization_name = '".$str."' and specialization_id not like '".$sid."'";
                $vsp    =   $this->getSpecialization($pms);
                if(is_array($vsp) && count($vsp) > 0){
                return true;
                }
                return false;
                
        }
}