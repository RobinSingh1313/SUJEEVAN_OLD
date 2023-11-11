<?php

class Membership_model extends CI_Model{
        public function create_membership(){
                $data = array(
                        'membership_name'                    =>  ucfirst($this->input->post('membershipnametype')),
                        'membership_alias_name'              =>  $this->common_config->cleanstr($this->input->post('membershipnametype')),
                        'membership_price'                   =>  $this->input->post('membership_price'),
                        'membership_after_disc'              =>  $this->input->post('membership_after_disc'),
                        'membership_sub_module_id'           =>  $this->input->post('homecare_category'),
                        'membership_days'                    =>  $this->input->post('membership_days'),
                        'membership_typee'                   =>  $this->input->post('membership_typee'),
                        'membership_about'                   =>  $this->input->post('membership_about'),
                        "membership_created_on"              =>  date("Y-m-d h:i:s"),
                        "membership_created_by"              =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/membership";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/membership");}
                $target_dir =   $this->config->item("upload_dest")."membership/";
                if(count($_FILES) > 0){
                    if($_FILES["module_image"]){
                        $fname      =   $_FILES["module_image"]["name"]; 
                        if($fname != ''){
                            $uploadfile =   $target_dir . ($fname);
                            if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                                $pic =  $fname;
                                $data['membership_image']  =   $fname;
                            }
                        }
                    }
                }
                $this->db->insert("membership",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "membership_id    "=> $vsp."MEM"
                                );	
                        $this->db->update("membership",$dat,"membershipid='".$vsp."'");
                        return true;   
                 }
        }

        public function cntviewMembership($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryMembership($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewMembership($params = array()){
            return $this->queryMembership($params)->result_array();
        }
        public function getMembership($params = array()){
            return $this->queryMembership($params)->row_array();
        }
        public function update_membership($str){
            $data = array(
                    'membership_name'                    =>  ucfirst($this->input->post('membershipnametype')),
                    'membership_alias_name'              =>  $this->common_config->cleanstr($this->input->post('membershipnametype')),
                    'membership_price'                   =>  $this->input->post('membership_price'),
                    'membership_after_disc'              =>  $this->input->post('membership_after_disc'),
                    'membership_sub_module_id'           =>  $this->input->post('homecare_category'),
                    'membership_days'                    =>  $this->input->post('membership_days'),
                    'membership_typee'                   =>  $this->input->post('membership_typee'),
                    'membership_about'                   =>  $this->input->post('membership_about'),
                    "membership_modified_on"             =>  date("Y-m-d h:i:s"),
                    "membership_modified_by"             =>  $this->session->userdata("login_id")
            );
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/membership";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/membership");}
            $target_dir =   $this->config->item("upload_dest")."membership/";
            if(count($_FILES) > 0){
                if($_FILES["module_image"]){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['membership_image']  =   $fname;
                        }
                    }
                }
            }
            $this->db->update("membership",$data,"membership_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function delete_membership($uro){
            $dta    =   array(
                "membership_open"            =>  0, 
                "membership_modified_on" =>    date("Y-m-d h:i:s"),
                "membership_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("membership",$dta,array("membership_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
    public function activedeactive($uri,$status){
                $ft     =   array(  
                            "membership_acde"       =>    $status,
                            "membership_modified_on" =>    date("Y-m-d h:i:s"),
                            "membership_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("membership",$ft,array("membership_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryMembership($params = array()){
                 $dt     =   array(
                                "membership_open"         =>  "1",
                                "membership_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('membership as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(membership_name LIKE '%".$params["keywords"]."%' OR membership_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_membership(){
                $str    =       $this->input->post('membership_name');
                $pms["whereCondition"]  =   "membership_name = '".$str."'";
                $vsp    =   $this->getMembership($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}