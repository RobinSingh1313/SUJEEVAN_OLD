<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wellness_model extends CI_Model{
        public function create_wellness(){
                $data = array(
                        'wellness_name'                    =>  ucfirst($this->input->post('wellness_name')),
                        'wellness_description'                    =>  ($this->input->post('wellness_description')),
                        'wellness_alias_name'              =>  $this->common_config->cleanstr($this->input->post('wellness_name')),
                        "wellness_created_on"               =>  date("Y-m-d h:i:s"),
                        "wellness_created_by"               =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/wellness";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/wellness");}
                $target_dir =   $this->config->item("upload_dest")."wellness/";
                if(count($_FILES) > 0){
                    if($_FILES["module_image"]){
                        $fname      =   $_FILES["module_image"]["name"]; 
                        if($fname != ''){
                            $uploadfile =   $target_dir . ($fname);
                            if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                                $pic =  $fname;
                                $data['wellness_image']  =   $fname;
                            }
                        }
                    }
                    if($_FILES["main_image"]){
                        $fname_main      =   $_FILES["main_image"]["name"]; 
                        if($fname_main != ''){
                            $uploadfile =   $target_dir . ($fname_main);
                            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadfile)) {
                                $pic =  $fname_main;
                                $data['wellness_main_image']  =   $fname_main;
                            }
                        }
                    }
                        
                }
                $this->db->insert("wheel_of_wellness",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "wellness_id    "=> $vsp."VT"
                                );	
                    $this->db->update("wheel_of_wellness",$dat,"wellnessid='".$vsp."'");
                    return true;   
                }
                return false;
        }
        public function cntviewWellness($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querywellness($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewWellness($params = array()){
            return $this->queryWellness($params)->result_array();
        }
        public function getWellness($params = array()){
            return $this->queryWellness($params)->row_array();
        }
        public function update_wellness($str){
            $data = array(
                    'wellness_name'                    =>  ucfirst($this->input->post('wellness_name')),
                    'wellness_description'                    =>  ($this->input->post('wellness_description')),
                    'wellness_alias_name'              =>  $this->common_config->cleanstr($this->input->post('wellness_name')),
                    "wellness_modified_on"             =>  date("Y-m-d h:i:s"),
                    "wellness_modified_by"             =>  $this->session->userdata("login_id")
            );
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/wellness";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/wellness");}
            $target_dir =   $this->config->item("upload_dest")."wellness/";
            if(count($_FILES) > 0){
                if($_FILES["module_image"]){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['wellness_image']  =   $fname;
                        }
                    }
                }
                if($_FILES["main_image"]){
                    $fname_main      =   $_FILES["main_image"]["name"]; 
                    if($fname_main != ''){
                        $uploadfile =   $target_dir . ($fname_main);
                        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname_main;
                            $data['wellness_main_image']  =   $fname_main;
                        }
                    }
                }
            }
            $this->db->update("wheel_of_wellness",$data,"wellness_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
		}
        public function delete_wellness($uro){
                $dta    =   array(
                    "wellness_open"        =>    0, 
                    "wellness_modified_on" =>    date("Y-m-d h:i:s"),
                    "wellness_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("wheel_of_wellness",$dta,array("wellness_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "wellness_acde"        =>    $status,
                            "wellness_modified_on" =>    date("Y-m-d h:i:s"),
                            "wellness_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("wheel_of_wellness",$ft,array("wellness_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryWellness($params = array()){
                 $dt     =   array(
                                "wellness_open"         =>  "1",
                                "wellness_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('wheel_of_wellness as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(wellness_name LIKE '%".$params["keywords"]."%' OR wellness_acde like '".$params["keywords"]."'  )");
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
        public function unique_id_check_wellness($uri = ""){
                $str    =       $this->input->post('wellness_name');
                $mks    =       '';
                if($uri != ""){
                    $mks    =       "and wellness_id <> '$uri'";
                }
                $pms["whereCondition"]  =   "wellness_name = '".$str."' $mks";
                $vsp    =   $this->getWellness($pms);
                if(is_array($vsp) && count($vsp) > 0){
                return true;
                }
                return false;
        }
        public function cntviewWellnessContact($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryWellnessContact($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewWellnessContact($params = array()){
            return $this->queryWellnessContact($params)->result_array();
        }
        public function getWellnessContact($params = array()){
            return $this->queryWellnessContact($params)->row_array();
        }
        public function queryWellnessContact($params = array()){
                 $dt     =   array(
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('wellness_contact as wc')
                            ->join('wheel_of_wellness as ww','wc.wellness_contact_wellness_id = ww.wellness_id','LEFT')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(wellness_contact_first_name LIKE '%".$params["keywords"]."%' OR wellness_contact_last_name like '".$params["keywords"]."'  OR wellness_contact_mobile like '".$params["keywords"]."' OR wellness_contact_email like '".$params["keywords"]."' OR wellness_contact_wellness_id like '".$params["keywords"]."' )");
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
}