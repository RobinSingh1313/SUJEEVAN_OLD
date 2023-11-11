<?php

class Health_category_model extends CI_Model{
        public function create_category(){
                $data = array(
                        'healthcategory_name'                    =>  ucfirst($this->input->post('category_name')),
                        'healthcategory_alias_name'              =>  $this->common_config->cleanstr($this->input->post('category_name')),
                        'healthcategory_module_id'               =>  $this->input->post('module'),
                        "healthcategory_created_on"               =>  date("Y-m-d H:i:s"),
                        "healthcategory_created_by"               =>  $this->session->userdata("login_id")
                );
                $target_dir =   $this->config->item("upload_dest")."healthcategory/";
                if(count($_FILES) > 0)
                {
                    //print_r($_FILES["image"]["name"]);exit;
                    $fname      =   $_FILES["image"]["name"]; 
                    if($fname != '')
                    {
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) 
                    {
                        $pic =  $fname;
                        $data['healthcategory_image']  =   $fname;
                    }
                    }
                }
                $this->db->insert("health_issues_category",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array("healthcategory_id" => $vsp."VT");	
                    $this->db->update("health_issues_category",$dat,array("healthcategoryid" => $vsp));
                    return true;   
                 }
        }
        public function create_assign_specialization(){
                $data = array(
                        'spec_id'                    =>  $this->input->post('specialization'),
                        'healthcategory_id'                    =>  $this->input->post('health_category'),
                        'subhealthcategory_id'                    =>  $this->input->post('health_sub_category'),
                        "created_on"               =>  date("Y-m-d H:i:s"),
                        "created_by"               =>  $this->session->userdata("login_id"),
                        "updated_by"               =>  date("Y-m-d H:i:s"),
                        "updated_by"               =>  $this->session->userdata("login_id"),
                        "assign_specialization_open" => 1
                );
               
               
                $this->db->insert("assign_specialization",$data);
                return true; 
                
        }
        public function cntviewCategory($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryCategory($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewCategory($params = array()){
            return $this->queryCategory($params)->result_array();
        }
        public function viewAssignSpecialization($params = array())
        {
            return $this->querySpecial($params)->result_array();
        }
        public function getCategory($params = array()){
            return $this->queryCategory($params)->row_array();
        }
        public function getSpecialization($uri){
            $assign = $this->db->query("select spec_id from assign_specialization where id='".$uri."'")->row();
            $specialization = $this->db->query("select specialization_id,specialization_name from specialization where specialization_id='".$assign->spec_id."'")->row_array();
            return $specialization;
        }
        public function getHealthCategory($uri){
            $assign = $this->db->query("select healthcategory_id from assign_specialization where id='".$uri."'")->row();
            $healthcategory = $this->db->query("select healthcategory_id,healthcategory_name from health_issues_category where healthcategory_id='".$assign->healthcategory_id."'")->row_array();
            return $healthcategory;
        }
        public function getHealthSubCategory($uri){
            $assign = $this->db->query("select subhealthcategory_id from assign_specialization where id='".$uri."'")->row();
            $subhealth = $this->db->query("select healthsubcategory_id,healthsubcategory_name from subcategory_issues where healthsubcategory_id='".$assign->subhealthcategory_id."'")->row_array();
            return $subhealth;
        }
        public function update_category($str){
            $data = array(
                    'healthcategory_name'                    =>  ucfirst($this->input->post('category_name')),
                    'healthcategory_alias_name'              =>  $this->common_config->cleanstr($this->input->post('healthcategory_name')),
                    'healthcategory_module_id'               =>  $this->input->post('module'),
                    "healthcategory_modified_on"             =>  date("Y-m-d H:i:s"),
                    "healthcategory_modified_by"             =>  $this->session->userdata("login_id")
            );
            $target_dir =   $this->config->item("upload_dest")."healthcategory/";
                if(count($_FILES) > 0)
                {
                    //print_r($_FILES["image"]["name"]);exit;
                    $fname      =   $_FILES["image"]["name"]; 
                    if($fname != '')
                    {
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) 
                    {
                        $pic =  $fname;
                        $data['healthcategory_image']  =   $fname;
                    }
                    }
                }
            $this->db->update("health_issues_category",$data,array("healthcategory_id" => $str));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function update_assign_specialization($str){
            $data = array(
                    'spec_id'                    =>  $this->input->post('specialization'),
                    'healthcategory_id'              =>  $this->input->post('health_category'),
                    'subhealthcategory_id'               =>  $this->input->post('sub_health_category'),
                    "updated_on"             =>  date("Y-m-d H:i:s"),
                    "updated_by"             =>  $this->session->userdata("login_id")
            );
           
            $this->db->update("assign_specialization",$data,array("id" => $str));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function delete_category($uro){
                $dta    =   array(
                    "healthcategory_open"        =>  0, 
                    "healthcategory_modified_on" =>    date("Y-m-d H:i:s"),
                    "healthcategory_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("health_issues_category",$dta,array("healthcategory_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        public function delete_assign_specialization($uro){
                $dta    =   array(
                    "assign_specialization_open"        =>  0, 
                    "updated_on" =>    date("Y-m-d H:i:s"),
                    "updated_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("assign_specialization",$dta,array("id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "healthcategory_acde"        =>    $status,
                            "healthcategory_modified_on" =>    date("Y-m-d H:i:s"),
                            "healthcategory_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("health_issues_category",$ft,array("healthcategory_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                // echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryCategory($params = array()){
            $dt     =   array(
                        "healthcategory_open"         =>  "1",
                        "healthcategory_status"       =>  "1"
                    );
            $sel    =   "*";
            if(array_key_exists("cnt",$params)){
                $sel    =   "count(*) as cnt";
            }
            if(array_key_exists("columns",$params)){
                $sel    =   $params["columns"];
            }
            $this->db->select("$sel")
                    ->from('health_issues_category as c')
                    ->join('modules as m','m.moduleid = c.healthcategory_module_id','LEFT')
                    ->where($dt); 
            if(array_key_exists("keywords",$params)){
            $this->db->where("(healthcategory_name LIKE '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR healthcategory_acde = '".$params["keywords"]."'  )");
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
        public function querySpecial($params = array()){
            $dt     =   array(
                        "assign_specialization_open"         =>  "1"
                    );
            $sel    =   "*";
            if(array_key_exists("cnt",$params)){
                $sel    =   "count(*) as cnt";
            }
            if(array_key_exists("columns",$params)){
                $sel    =   $params["columns"];
            }
            $this->db->select("$sel")
                    ->from('assign_specialization as a')
                    ->join('health_issues_category as b','b.healthcategory_id = a.healthcategory_id','LEFT')
                    ->join('subcategory_issues as c','c.healthsubcategory_id = a.subhealthcategory_id','LEFT')
                    ->join('specialization as d','d.specialization_id = a.spec_id','LEFT')
                    ->where($dt); 
            if(array_key_exists("keywords",$params)){
            $this->db->where("(specialization_name LIKE '%".$params["keywords"]."%' OR healthcategory_name LIKE '%".$params["keywords"]."%' OR healthsubcategory_name = '".$params["keywords"]."'  )");
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
        public function unique_id_check_category(){
            $str    =       $this->input->post('healthcategory_name');
            $str1   =       $this->input->post('module'); 
            $ms     =   "";
            $healthcategory_id    =   $this->input->post("healthcategory_id");
            if($healthcategory_id != ""){
                $ms     =   " and healthcategory_id not like '".$healthcategory_id."'";
            }
            $pms["whereCondition"]  =   "healthcategory_name = '".$str."' AND healthcategory_module_id = '".$str1."' $ms";
            $vsp    =   $this->getCategory($pms);
            if(is_array($vsp) && count($vsp) > 0){
                return true;
            }
            return false;
        }
        public function querysubCategory($params = array()){
            $dt     =   array(
                            "healthcategory_open"         =>  "1",
                            "healthcategory_status"       =>  "1"
                        );
            $sel    =   "*";
            if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
            }
            if(array_key_exists("columns",$params)){
                    $sel    =   $params["columns"];
            }
            $this->db->select("$sel")
                        ->from('subcategory_issues as r')
                        ->join('health_issues_category as c','c.healthcategory_id = r.healthsubcategory_health_id','LEFT')
                        ->join('modules as m','m.moduleid = c.healthcategory_module_id','LEFT')
                        ->where($dt); 
            if(array_key_exists("keywords",$params)){
              $this->db->where("(healthcategory_name LIKE '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR healthcategory_acde = '".$params["keywords"]."'  )");
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
        public function cntviewsubCategory($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->querysubCategory($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
        }
        public function viewsubCategory($params = array()){
            return $this->querysubCategory($params)->result_array();
        }
        public function getsubCategory($pms = array()){
            return $this->querysubCategory($pms)->row_array();   
        }
        public function unique_id_check_subcategory(){
            $str    =       $this->input->post('healthcategory_name');
            $str1   =       $this->input->post('module'); 
            $ms     =   "";
            $healthcategory_id    =   $this->input->post("healthcategory_id");
            if($healthcategory_id != ""){
                $ms     =   " and healthcategory_id not like '".$healthcategory_id."'";
            }
            $pms["whereCondition"]  =   "healthcategory_name = '".$str."' AND healthcategory_module_id = '".$str1."' $ms";
            $vsp    =   $this->getsubCategory($pms);
            if(is_array($vsp) && count($vsp) > 0){
                return true;
            }
            return false;
        }
        public function update_subcategory($ur){
            $data = array(
                    "healthsubcategory_health_id"       =>  $this->input->post("healthcategory"),
                    'healthsubcategory_name'            =>  ucfirst($this->input->post('subcategory_name')),
                    'healthsubcategory_alias_name'      =>  $this->common_config->cleanstr($this->input->post('subcategory_name')),
                    "healthsubcategory_modified_on"     =>  date("Y-m-d H:i:s"),
                    "healthsubcategory_modified_by"     =>  $this->session->userdata("login_id")
            );
            $target_dir =   $this->config->item("upload_dest")."modules/";
            if(count($_FILES) > 0){
                $fname      =   $_FILES["module_image"]["name"]; 
                if($fname != ''){
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                        $pic =  $fname;
                        $data['healthsubcategory_image']  =   $fname;
                    }
                }
            }
            $this->db->update("subcategory_issues",$data,array("healthsubcategory_id" => $ur));
            // echo $this->db->last_query();exit;
            // echo "<pre>";print_R($data);exit;
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
        }
        public function activedeactivesubcate($uri,$status){
                $ft     =   array(  
                            "healthsubcategory_acde"        =>    $status,
                            "healthsubcategory_modified_on" =>    date("Y-m-d H:i:s"),
                            "healthsubcategory_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("subcategory_issues",$data,array("healthsubcategory_id" => $ur));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function delete_subcategory($ur){
            $data = array(
                    "healthsubcategory_open"      =>  0,
                    "healthsubcategory_modified_on"     =>  date("Y-m-d H:i:s"),
                    "healthsubcategory_modified_by"     =>  $this->session->userdata("login_id")
            );
            $this->db->update("subcategory_issues",$data,array("healthsubcategory_id" => $ur));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
        }
        public function createsubcategory(){
            $data = array(
                    "healthsubcategory_health_id"       =>  $this->input->post("healthcategory"),
                    'healthsubcategory_name'            =>  ucfirst($this->input->post('subcategory_name')),
                    'healthsubcategory_alias_name'      =>  $this->common_config->cleanstr($this->input->post('subcategory_name')),
                    "healthsubcategory_created_on"      =>  date("Y-m-d H:i:s"),
                    "healthsubcategory_created_by"      =>  $this->session->userdata("login_id")
            );
            $target_dir =   $this->config->item("upload_dest")."modules/";
            if(count($_FILES) > 0){
                $fname      =   $_FILES["module_image"]["name"]; 
                if($fname != ''){
                    $uploadfile =   $target_dir . ($fname);
                    if (move_uploaded_file($_FILES['module_image']['tmp_name'], $uploadfile)) {
                        $pic =  $fname;
                        $data['healthsubcategory_image']  =   $fname;
                    }
                }
            }
            $this->db->insert("subcategory_issues",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array("healthsubcategory_id" => $vsp."SUT");	
                $this->db->update("subcategory_issues",$dat,array("healthsubcategoryid" => $vsp));
                return true;   
            }
            return false;
        }
}