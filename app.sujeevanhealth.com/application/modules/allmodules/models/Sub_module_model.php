<?php

class Sub_module_model extends CI_Model{
        public function create_sub_module(){
            $data = array(
              		"submodule_isblog"			=>	($this->input->post("submodule_isblog") != "")?$this->input->post("submodule_isblog"):"0",
              		"submodule_isquestions"		=>	($this->input->post("submodule_isquestios") != "")?$this->input->post("submodule_isquestios"):"0",
              		"submodule_isconsult"		=>	($this->input->post("submodule_isconsult") != "")?$this->input->post("submodule_isconsult"):"0",
              		"submodule_ismodule"        =>  ($this->input->post("submodule_ismodule") != "")?$this->input->post("submodule_ismodule"):"0",
              		"submodule_isdesc"          =>  ($this->input->post("submodule_isdesc") != "")?$this->input->post("submodule_isdesc"):"0",
              		"sub_vendor_id"             =>  ($this->input->post("vendor_id") != "")?$this->input->post("vendor_id"):"",
              		"sub_module_desc"           =>  ($this->input->post('sub_module_desc'))??'',
                    'sub_module_name'           =>  ucfirst($this->input->post('sub_module_name')),
                    'sub_module_order'           =>  ($this->input->post('sort_order'))??0,
                    'sub_module_module_id'      =>  $this->input->post('module'),
                    "sub_module_created_on"     =>  date("Y-m-d h:i:s"),
                    "sub_module_created_by"     =>  $this->session->userdata("login_id")
            );
            $target_dir =   $this->config->item("upload_dest")."modules/";
            if(count($_FILES) > 0){
                $fname      =   $_FILES["module_image"]["name"]; 
                if($fname != ''){
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                        $pic =  $fname;
                        $data['sub_module_image']  =   $fname;
                    }
                }
            }
            $this->db->insert("sub_module",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array(
                                "sub_module_id    "=> $vsp."VT"
                            );	
                    $this->db->update("sub_module",$dat,"sub_moduleid='".$vsp."'");
                    return true;   
             }
        }

        public function cntviewSub_module($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querySub_module($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewSub_module($params = array()){
            return $this->querySub_module($params)->result_array();
        }
        public function getSub_module($params = array()){
            return $this->querySub_module($params)->row_array();
        }
        public function update_sub_module($str){
            $data = array(
              		"submodule_isblog"			=>	($this->input->post("submodule_isblog") != "")?$this->input->post("submodule_isblog"):"0",
              		"submodule_isconsult"		=>	($this->input->post("submodule_isconsult") != "")?$this->input->post("submodule_isconsult"):"0",
              		"submodule_isquestions"		=>	($this->input->post("submodule_isquestios") != "")?$this->input->post("submodule_isquestios"):"0",
              		"submodule_ismodule"        =>  ($this->input->post("submodule_ismodule") != "")?$this->input->post("submodule_ismodule"):"0",
              		"submodule_isdesc"          =>  ($this->input->post("submodule_isdesc") != "")?$this->input->post("submodule_isdesc"):"0",
              		"sub_module_desc"           =>  ($this->input->post('sub_module_desc'))??'',
              		"sub_vendor_id"             =>  ($this->input->post("vendor_id") != "")?$this->input->post("vendor_id"):"",
                    'sub_module_name'           =>  ucfirst($this->input->post('sub_module_name')),
                    'sub_module_order'           =>  ($this->input->post('sort_order'))??0,
                    'sub_module_module_id'      =>  $this->input->post('module'),
                    "sub_module_modified_on"    =>  date("Y-m-d h:i:s"),
                    "sub_module_modified_by"    =>  $this->session->userdata("login_id")
            );
            
            $target_dir =   $this->config->item("upload_dest")."modules/";
            if(count($_FILES) > 0){
                $fname      =   $_FILES["module_image"]["name"]; 
                if($fname != ''){
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                        $pic =  $fname;
                        $data['sub_module_image']  =   $fname;
                    }
                }
            }
            $this->db->update("sub_module",$data,array("sub_module_id" => $str));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
        public function delete_sub_module($uro){
                $dta    =   array(
                    "sub_module_open"            =>  0, 
                    "sub_module_modified_on" =>    date("Y-m-d h:i:s"),
                    "sub_module_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("sub_module",$dta,array("sub_module_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "sub_module_acde"       =>    $status,
                            "sub_module_modified_on" =>    date("Y-m-d h:i:s"),
                            "sub_module_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("sub_module",$ft,array("sub_module_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function querySub_module($params = array()){
                 $dt     =   array(
                                "sub_module_open"         =>  "1",
                                "sub_module_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('sub_module as c')
                            ->join('modules as m','m.moduleid = c.sub_module_module_id','LEFT')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(sub_module_name LIKE '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR sub_module_acde = '".$params["keywords"]."'  )");
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
        public function unique_submodule_name(){
                $str    =       $this->input->post('sub_module_name');
                $str1   =       $this->input->post('module'); 
                $sub_moduleid   =   $this->input->post("sub_moduleid");
                $mk =   "";
                if($sub_moduleid != ""){
                    $mk =   " and sub_moduleid not like '".$sub_moduleid."'";
                }
                $pms["whereCondition"]  =   "sub_module_name = '".$str."' AND sub_module_module_id = '".$str1."' $mk";
                $vsp    =   $this->querySub_module($pms)->row_array();
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}