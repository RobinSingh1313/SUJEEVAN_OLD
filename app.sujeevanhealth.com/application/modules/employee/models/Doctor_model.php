<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Doctor_model extends CI_Model{
        public function create_doctor(){
                $data = array(
                        'doctor_name'                       =>  ucfirst($this->input->post('doctor_name')),
                        'doctor_experience'                 =>  ($this->input->post('doctor_experience'))??'',
                        'doctor_specialization'             =>  ($this->input->post('doctor_specialization'))??'',
                        'doctor_education'                  =>  ($this->input->post('doctor_education'))??'',
                        'doctor_language'                   =>  ($this->input->post('doctor_language'))??'',
                        'doctor_alias_name'                 =>  $this->common_config->cleanstr($this->input->post('doctor_name')),
                        "doctor_created_on"                 =>  date("Y-m-d h:i:s"),
                        "doctor_created_by"                 =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/doctor";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/doctor");}
                $target_dir =   $this->config->item("upload_dest")."doctor/";
                if(count($_FILES) > 0){
                    if($_FILES["module_image"]){
                        $fname      =   $_FILES["module_image"]["name"]; 
                        if($fname != ''){
                            $uploadfile =   $target_dir . ($fname);
                            if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                                $pic =  $fname;
                                $data['doctor_image']  =   $fname;
                            }
                        }
                    }
                        
                }
                $this->db->insert("doctor",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "doctor_id    "=> $vsp."DOCT"
                                );	
                    $this->db->update("doctor",$dat,"doctorid='".$vsp."'");
                    $dta    =   array(
                                    "login_name"        =>  $this->input->post("user_name"),
                                    "login_email"       =>  $this->input->post("email"),
                                    "login_password"    =>  base64_encode ($this->input->post("password")),
                                    "login_type"        =>  "6utype",
                                    "profile_id"        =>  $vsp."DOCT",
                                    "login_cr_on"       =>  date("Y-m-d h:i:s"),
                                    "login_cr_by"       =>  $this->session->userdata("login_id")
                            );
                    $this->db->insert("login",$dta);
                    $vsp    =   $this->db->insert_id();
                    if($vsp){
                        $dat=array(
                                    "login_id" 				        => $vsp.'login'
                            );		
                        $this->db->update("login",$dat,"lid ='".$vsp."'");
                        return TRUE;
                    }
                }
                return false;
        }
        public function cntviewDoctor($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querydoctor($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewDoctor($params = array()){
            return $this->queryDoctor($params)->result_array();
        }
        public function getDoctor($params = array()){
            return $this->queryDoctor($params)->row_array();
        }
        public function update_doctor($str){
            $data = array(
                    'doctor_name'                       =>  ucfirst($this->input->post('doctor_name')),
                    'doctor_experience'                 =>  ($this->input->post('doctor_experience'))??'',
                    'doctor_specialization'             =>  ($this->input->post('doctor_specialization'))??'',
                    'doctor_education'                  =>  ($this->input->post('doctor_education'))??'',
                    'doctor_language'                   =>  ($this->input->post('doctor_language'))??'',
                    'doctor_alias_name'                 =>  $this->common_config->cleanstr($this->input->post('doctor_name')),
                    "doctor_modified_on"                =>  date("Y-m-d h:i:s"),
                    "doctor_modified_by"                =>  $this->session->userdata("login_id")
            );
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/doctor";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/doctor");}
            $target_dir =   $this->config->item("upload_dest")."doctor/";
            if(count($_FILES) > 0){
                if($_FILES["module_image"]){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['doctor_image']  =   $fname;
                        }
                    }
                }
            }
            $this->db->update("doctor",$data,"doctor_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                $dta    =   array( 
                                    "login_name"            => $this->input->post("user_name"),
                                    "login_email"           => $this->input->post("email"),
                                    "login_password"        => base64_encode ($this->input->post("password")),
                                    "login_type"            => "6utype",
                                    "login_md_on"           => date("Y-m-d h:i:s"),
                                    "login_md_by"           => $this->session->userdata("login_id")
                            );
                $this->db->update("login",$dta,array("profile_id" => $str));
                if($this->db->affected_rows() >  0){
                       return $this->db->affected_rows();
                }
                return true;
            }
            return FALSE;
		}
        public function delete_doctor($uro){
                $dta    =   array(
                    "doctor_open"        =>    0, 
                    "doctor_modified_on" =>    date("Y-m-d h:i:s"),
                    "doctor_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("doctor",$dta,array("doctor_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "doctor_acde"        =>    $status,
                            "doctor_modified_on" =>    date("Y-m-d h:i:s"),
                            "doctor_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("doctor",$ft,array("doctor_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryDoctor($params = array()){
                 $dt     =   array(
                                "doctor_open"         =>  "1",
                                "doctor_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('doctor as c')
                            ->join('login as l','l.profile_id = c.doctor_id','Left')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(doctor_name LIKE '%".$params["keywords"]."%' OR doctor_acde like '".$params["keywords"]."'  )");
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
        public function unique_id_check_doctor($uri = ""){
                $str    =       $this->input->post('doctor_name');
                $mks    =       '';
                if($uri != ""){
                    $mks    =       "and doctor_id <> '$uri'";
                }
                $pms["whereCondition"]  =   "doctor_name = '".$str."' $mks";
                $vsp    =   $this->getDoctor($pms);
                if(is_array($vsp) && count($vsp) > 0){
                return true;
                }
                return false;
        }
        public function cntviewDoctorContact($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryDoctorContact($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewDoctorContact($params = array()){
            return $this->queryDoctorContact($params)->result_array();
        }
        public function getDoctorContact($params = array()){
            return $this->queryDoctorContact($params)->row_array();
        }
        public function queryDoctorContact($params = array()){
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
                            ->from('doctor_contact as wc')
                            ->join('doctor as ww','wc.doctor_contact_doctor_id = ww.doctor_id','LEFT')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(doctor_contact_first_name LIKE '%".$params["keywords"]."%' OR doctor_contact_last_name like '".$params["keywords"]."'  OR doctor_contact_mobile like '".$params["keywords"]."' OR doctor_contact_email like '".$params["keywords"]."' OR doctor_contact_doctor_id like '".$params["keywords"]."' )");
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