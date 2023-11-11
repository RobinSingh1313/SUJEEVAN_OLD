<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Banners_model extends CI_Model{
        public function create_banner(){
                $data = array(
                        'banner_name'                    =>  ($this->input->post('banner_name'))?ucfirst($this->input->post('banner_name')):'',
                        'module_id'                         =>  ($this->input->post('module'))??'',
                        'banner_alias_name'              =>  ($this->input->post('banner_name'))?$this->common_config->cleanstr($this->input->post('banner_name')):'',
                        "banner_created_on"               =>  date("Y-m-d h:i:s"),
                        "banner_created_by"               =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/banner";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/banner");}
                $target_dir =   $this->config->item("upload_dest")."banner/";
                if(count($_FILES) > 0){
                    if($_FILES["module_image"]){
                        $fname      =   $_FILES["module_image"]["name"]; 
                        if($fname != ''){
                            $vsp        =   explode(".",$fname);
                            $fname      =   "BAN_".time().".".$vsp['1'];
                            $uploadfile =   $target_dir . basename($fname);
                            if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                                $pic =  $fname;
                                $data['banner_image']  =   $fname;
                            }
                        }
                    }
                        
                }
                $this->db->insert("banners",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "banner_id    "=> $vsp."VT"
                                );	
                    $this->db->update("banners",$dat,"bannerid='".$vsp."'");
                    return true;   
                }
                return false;
        }
        public function cntviewBanner($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querybanner($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewBanner($params = array()){
            return $this->queryBanner($params)->result_array();
        }
        public function getBanner($params = array()){
            return $this->queryBanner($params)->row_array();
        }
        public function update_banner($str){
            $data = array(
                    'banner_name'                    =>  ($this->input->post('banner_name'))?ucfirst($this->input->post('banner_name')):'',
                    'module_id'                      =>  ($this->input->post('module'))??'',
                    'banner_alias_name'              =>  ($this->input->post('banner_name'))?$this->common_config->cleanstr($this->input->post('banner_name')):'',
                    "banner_modified_on"             =>  date("Y-m-d h:i:s"),
                    "banner_modified_by"             =>  $this->session->userdata("login_id")
            );
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/banner";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/banner");}
            $target_dir =   $this->config->item("upload_dest")."banner/";
            if(count($_FILES) > 0){
                if($_FILES["module_image"]){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                            $vsp        =   explode(".",$fname);
                            $fname      =   "BAN_".time().".".$vsp['1'];
                            $uploadfile =   $target_dir . basename($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['banner_image']  =   $fname;
                        }
                    }
                }
            }
            $this->db->update("banners",$data,"banner_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
		}
        public function delete_banner($uro){
                $dta    =   array(
                    "banner_open"        =>    0, 
                    "banner_modified_on" =>    date("Y-m-d h:i:s"),
                    "banner_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("banners",$dta,array("banner_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "banner_acde"        =>    $status,
                            "banner_modified_on" =>    date("Y-m-d h:i:s"),
                            "banner_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("banners",$ft,array("banner_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryBanner($params = array()){
                 $dt     =   array(
                                "banner_open"         =>  "1",
                                "banner_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('banners as c')
                            ->join('modules as m','c.module_id= m.moduleid','left')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(banner_name LIKE '%".$params["keywords"]."%' OR banner_acde like '".$params["keywords"]."'  )");
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
        public function unique_id_check_banner($uri = ""){
                $str    =       $this->input->post('banner_name');
                $mks    =       '';
                if($uri != ""){
                    $mks    =       "and banner_id <> '$uri'";
                }
                $pms["whereCondition"]  =   "banner_name = '".$str."' $mks";
                $vsp    =   $this->getBanner($pms);
                if(is_array($vsp) && count($vsp) > 0){
                return true;
                }
                return false;
        }
        
}