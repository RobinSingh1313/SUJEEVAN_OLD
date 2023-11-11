<?php
class Vendor_model extends CI_Model{
    public function create_Vendors(){
        $data = array(
                "vendor_profile_create" =>  ($this->input->post('vendor_profile_create')), 
                "vendor_stage_1"        =>  ($this->input->post("vendor_stage_1") != "")?implode(",",$this->input->post("vendor_stage_1")):"",
                "vendor_stage_2"        =>  ($this->input->post("vendor_stage_2") != "")?implode(",",$this->input->post("vendor_stage_2")):"",
                "vendor_module"         =>  $this->input->post("vendor_module")??'',
                "vendor_name"           =>  ucfirst($this->input->post('vendor_name')),
                "vendor_created_on"     =>  date("Y-m-d H:i:s"),
                "vendor_created_by"     =>  $this->session->userdata("login_id")
        );
        $target_dir =   $this->config->item("upload_dest")."modules/";
        if(count($_FILES) > 0){
            $fname      =   $_FILES["module_image"]["name"]; 
            if($fname != ''){
                $uploadfile =   $target_dir . ($fname);
                if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                    $pic =  $fname;
                    $data['vendor_icon']  =   $fname;
                }
            }
            $bkfname      =   $_FILES["vendor_background"]["name"]; 
            if($bkfname != ''){
                $uploadfile =   $target_dir . ($bkfname);
                if (move_uploaded_file($_FILES['vendor_background']['tmp_name'], $uploadfile)) {
                    $pic =  $bkfname;
                    $data['vendor_background']  =   $bkfname;
                }
            }
            $vendor_profile_iconfname      =   $_FILES["vendor_profile_icon"]["name"]; 
            if($vendor_profile_iconfname != ''){
                $uploadfile =   $target_dir . ($vendor_profile_iconfname);
                if (move_uploaded_file($_FILES['vendor_profile_icon']['tmp_name'], $uploadfile)) {
                    $pic =  $fname;
                    $data['vendor_profile_icon']  =   $vendor_profile_iconfname;
                }
            }
        }
        $this->db->insert("vendors",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp > 0){
                    $dat    =   array(
                            "vendor_id    "=> $vsp."VT"
                        );	
                $this->db->update("vendors",$dat,array("vendorid" => $vsp));
                return true;   
       }
    }
    public function cntviewVendors($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->queryVendors($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
    }
    public function viewVendors($params = array()){
        return $this->queryVendors($params)->result_array();
    }
    public function getVendors($params = array()){
        return $this->queryVendors($params)->row_array();
    }
    public function update_vendor($str){
        $data["vendor_profile_create"] = ($this->input->post('vendor_profile_create'));
        $data["vendor_name"] = ucfirst($this->input->post('vendor_name'));
        $data["vendor_modified_on"] = date("Y-m-d H:i:s");
        $data["vendor_module"]  =  ($this->input->post("vendor_module") != "")?implode(",",$this->input->post("vendor_module")):"";
        $data["vendor_stage_1"] =  ($this->input->post("vendor_stage_1") != "")?implode(",",$this->input->post("vendor_stage_1")):"";
        $data["vendor_stage_2"] =  ($this->input->post("vendor_stage_2") != "")?implode(",",$this->input->post("vendor_stage_2")):"";
        $data["vendor_modified_by"] =   $this->session->userdata("login_id");
        $target_dir =   $this->config->item("upload_dest")."modules/";
        if(count($_FILES) > 0){
            $fname      =   $_FILES["module_image"]["name"]; 
            if($fname != ''){
                $uploadfile =   $target_dir . ($fname);
                if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                    $pic =  $fname;
                    $data['vendor_image']  =   $fname;
                }
            }
            $bkfname      =   $_FILES["vendor_background"]["name"]; 
            if($bkfname != ''){
                $uploadfile =   $target_dir . ($bkfname);
                if (move_uploaded_file($_FILES['vendor_background']['tmp_name'], $uploadfile)) {
                    $pic =  $bkfname;
                    $data['vendor_background']  =   $bkfname;
                }
            }
            $vendor_profile_iconfname      =   $_FILES["vendor_profile_icon"]["name"]; 
            if($vendor_profile_iconfname != ''){
                $uploadfile =   $target_dir . ($vendor_profile_iconfname);
                if (move_uploaded_file($_FILES['vendor_profile_icon']['tmp_name'], $uploadfile)) {
                    $pic =  $fname;
                    $data['vendor_profile_icon']  =   $vendor_profile_iconfname;
                }
            }
        }
        $this->db->update("vendors",$data,array("vendor_id" => $str));
        $vsp   =    $this->db->affected_rows();
        if($vsp > 0){
            return true;
        }
        return FALSE;
    }
    public function delete_vendor($uro){
            $dta    =   array(
                "vendor_open"            =>  0, 
                "vendor_modified_on" =>    date("Y-m-d H:i:s"),
                "vendor_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("vendors",$dta,array("vendor_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
    public function activedeactive($uri,$status){
        $ft     =   array(  
                    "vendor_acde"       =>    $status,
                    "vendor_modified_on" =>    date("Y-m-d H:i:s"),
                    "vendor_modified_by" =>    $this->session->userdata("login_id") 
               );  
        $this->db->update("vendors",$ft,array("vendor_id" => $uri));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }
    public function queryVendors($params = array()){
             $dt     =   array(
                            "vendor_open"         =>  "1",
                            "vendor_status"       =>  "1"
                        );
            $sel    =   "*";
            if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
            }
            if(array_key_exists("columns",$params)){
                    $sel    =   $params["columns"];
            }
            $this->db->select("$sel")
                        ->from('vendors as c')
                        ->where($dt); 
            if(array_key_exists("keywords",$params)){
              $this->db->where("(vendor_name LIKE '%".$params["keywords"]."%' or vendor_profile_create LIKE '%".$params["keywords"]."%' OR vendor_acde LIKE '%".$params["keywords"]."%')");
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
//            $this->db->get();echo $this->db->last_query();exit;
            return $this->db->get();
    }
    public function unique_id_check_Vendors(){
            $str    =       $this->input->post('vendor_name');
            $vendor_id  =   $this->input->post("vendor_id");
            $pms["whereCondition"]  =   "vendor_name like '".$str."'";
            if($vendor_id != ""){
                $pms["whereCondition"]  =   "vendor_name like '".$str."' and vendor_id <> '".$vendor_id."'";    
            }
            $vsp    =   $this->getVendors($pms);
            if(is_array($vsp) && count($vsp) > 0){
                return true;
            }
            return false;
    }
}