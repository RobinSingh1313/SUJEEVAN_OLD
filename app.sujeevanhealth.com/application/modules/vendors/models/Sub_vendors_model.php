<?php

class Sub_vendors_model extends CI_Model{
        public function create_sub_vendors(){
                $data = array(
                    'vendorsubmodule_name'            =>  ucfirst($this->input->post('sub_vendor_name')),
                    'vendorsubmodule_alias_name'      =>  $this->common_config->cleanstr($this->input->post('sub_vendor_name')),
                    'vendorsubmodule_vendor_id'       =>  $this->input->post('vendor'),
                    "vendorsubmodule_api"   =>  $this->input->post("vendorsubmodule_api"),
                    "vendorsubmodule_created_on"      =>  date("Y-m-d h:i:s"),
                    "vendorsubmodule_created_by"      =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/modules";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/modules");}
                $target_dir =   $this->config->item("upload_dest")."modules/";
                if(count($_FILES) > 0){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['vendorsubmodule_icon']  =   $fname;
                        }
                    }
                }
                $this->db->insert("vendor_submodule",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "vendorsubmodule_id    "=> $vsp."VT"
                                );	
                    $this->db->update("vendor_submodule",$dat,"vendorsubmoduleid='".$vsp."'");
                    return true;   
                }
                return false;
        }
        public function cntviewSub_vendor($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querySub_vendor($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewSub_vendor($params = array()){
            return $this->querySub_vendor($params)->result_array();
        }
        public function getSub_vendor($params = array()){
            return $this->querySub_vendor($params)->row_array();
        }
        public function update_sub_vendors($str){
            $data = array(
                    'vendorsubmodule_name'                    =>  ucfirst($this->input->post('sub_vendor_name')),
                    'vendorsubmodule_alias_name'              =>  $this->common_config->cleanstr($this->input->post('sub_vendor_name')),
                    'vendorsubmodule_vendor_id'               =>  $this->input->post('vendor'),
                    "vendorsubmodule_modified_on"             =>  date("Y-m-d h:i:s"),
                    "vendorsubmodule_api"                     =>  $this->input->post("vendorsubmodule_api"),
                    "vendorsubmodule_modified_by"             =>  $this->session->userdata("login_id")
            );
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/modules";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/modules");}
            $target_dir =   $this->config->item("upload_dest")."modules/";
            if(count($_FILES) > 0){
                $fname      =   $_FILES["module_image"]["name"]; 
                if($fname != ''){
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                        $pic =  $fname;
                        $data['vendorsubmodule_icon']  =   $fname;
                    }
                }
            }
            $this->db->update("vendor_submodule",$data,"vendorsubmodule_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function delete_sub_vendors($uro){
                $dta    =   array(
                    "vendorsubmodule_open"            =>  0, 
                    "vendorsubmodule_modified_on" =>    date("Y-m-d h:i:s"),
                    "vendorsubmodule_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("vendor_submodule",$dta,array("vendorsubmodule_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "vendorsubmodule_acde"       =>    $status,
                            "vendorsubmodule_modified_on" =>    date("Y-m-d h:i:s"),
                            "vendorsubmodule_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("vendor_submodule",$ft,array("vendorsubmodule_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function querySub_vendor($params = array()){
                 $dt     =   array(
                                "vendorsubmodule_status"     =>  "1",
                                "vendorsubmodule_open"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('vendor_submodule as c')
                            ->join('vendors as m','m.vendor_id = c.vendorsubmodule_vendor_id and m.vendor_open = 1 and vendor_status = 1','INNER')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(vendorsubmodule_name LIKE '%".$params["keywords"]."%' OR vendor_name LIKE '%".$params["keywords"]."%' OR vendorsubmodule_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_sub_vendors(){
                $str    =       $this->input->post('vendorsubmodule_name');
                $str1   =       $this->input->post('vendor'); 
                $pms["whereCondition"]  =   "vendorsubmodule_name = '".$str."' AND vendorsubmodule_vendor_id = '".$str1."'";
                $vsp    =   $this->getSub_vendor($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}