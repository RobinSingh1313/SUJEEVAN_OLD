<?php
class Homecare_model extends CI_Model{
        public function create_package(){
                $data = array(
                        'quotation_by'                  =>  $this->input->post('quotation_by'),
                        'quotation'                     =>  $this->input->post('quotation'),
                        'package_name'                  =>  ucfirst($this->input->post('package_name')),
                        "package_module_id"		        => 7,
                        'package_alias_name'            =>  $this->common_config->cleanstr($this->input->post('package_name')),
                        "package_created_on"            =>  date("Y-m-d h:i:s"),
                        "package_created_by"            =>  $this->session->userdata("login_id")
                );
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/homecare";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/homecare");}
                $target_dir =   $this->config->item("upload_dest")."homecare/";
                if(count($_FILES) > 0){
                    $fname      =   $_FILES["module_image"]["name"]; 
                    if($fname != ''){
                        $uploadfile =   $target_dir . ($fname);
                        if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                            $pic =  $fname;
                            $data['package_image']  =   $fname;
                        }
                    }
                    $quotation_imagefname           =   $_FILES["quotation_image"]["name"]; 
                    if($quotation_imagefname != ''){
                        $uploadfile =   $target_dir . ($quotation_imagefname);
                        if (move_uploaded_file($_FILES['quotation_image']['tmp_name'], $uploadfile)) {
                            $$quotation_pic             =   $quotation_imagefname;
                            $data['quotation_image']    =   $quotation_imagefname;
                        }
                    }
                }
                $this->db->insert("homecare_package",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    	$dat    =   array("package_id"	=> $vsp."VT");	
                        $this->db->update("homecare_package",$dat,"packageid='".$vsp."'");
                        return true;   
                }
        }

        public function cntviewpackage($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querypackage($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewpackage($params = array()){
            return $this->querypackage($params)->result_array();
        }
        public function getpackage($params = array()){
            return $this->querypackage($params)->row_array();
        }
        public function update_package($str){
            $data = array(
                    'quotation_by'                  =>  $this->input->post('quotation_by'),
                    'quotation'                     =>  $this->input->post('quotation'),
                    'package_name'                    =>  ucfirst($this->input->post('package_name')),
                    'package_alias_name'              =>  $this->common_config->cleanstr($this->input->post('package_name')),
                    "package_modified_on"             =>  date("Y-m-d h:i:s"),
                    "package_modified_by"             =>  $this->session->userdata("login_id")
            );
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   $target_dir."/homecare";
            if (file_exists($direct)){
            }else{mkdir($target_dir."/homecare");}
            $target_dir =   $this->config->item("upload_dest")."homecare/";
            if(count($_FILES) > 0){
                $fname      =   $_FILES["module_image"]["name"]; 
                if($fname != ''){
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                        $pic =  $fname;
                        $data['package_image']  =   $fname;
                    }
                }
                $quotation_imagefname           =   $_FILES["quotation_image"]["name"]; 
                if($quotation_imagefname != ''){
                    $uploadfile =   $target_dir . ($quotation_imagefname);
                    if (move_uploaded_file($_FILES['quotation_image']['tmp_name'], $uploadfile)) {
                        $$quotation_pic             =   $quotation_imagefname;
                        $data['quotation_image']    =   $quotation_imagefname;
                    }
                }
            }
            $this->db->update("homecare_package",$data,"package_id='".$str."'");
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
                $this->db->update("homecare_package",$dta,array("package_id" => $uro));
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
                $this->db->update("homecare_package",$ft,array("package_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function querypackage($params = array()){
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
                            ->from('homecare_package as c')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(package_name LIKE '%".$params["keywords"]."%' oR package_acde = '%".$params["keywords"]."%')");
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
                $package_id =   $this->input->post("package_id");
                $str    =   $this->input->post('package_name');
                $ms     =   "";
                if($package_id != ""){
                    $ms  =  " and package_id not like '".$package_id."'";
                }
                $pms["whereCondition"]  =   "package_name = '".$str."' $ms";
                $vsp    =   $this->getpackage($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}