<?php
class Symptoms_model extends CI_Model{
    public function update_symptoms($vsp){
            $dat = array( 
                    'symptoms_module'              =>  $this->input->post('module'),
                    'symptoms_health_category'     =>  $this->input->post('healthcategory'),
                    'symptoms_order'     =>  $this->input->post('symptoms_order'),
                    'symptoms_health_category'     =>  $this->input->post('healthcategory'),
                    'symptoms_sub_health'          =>  $this->input->post('healthcategorysub'),
                    'symptoms_question'            =>  $this->input->post('botauto_question'),
                    'symptoms_auto_start'             =>  ($this->input->post('symptoms_auto_start') != '')?1:"0",
                    'symptoms_options'             =>  ($this->input->post('botauto_tags') != '')?$this->input->post('botauto_tags'):"",
                    "symptoms_created_on"          =>  date("Y-m-d H:i:s"),
                    "symptoms_created_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("symptoms_chat_box",$dat,array("symptoms_id" => $vsp));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
    }
    public function create_symptoms(){
            $data = array( 
                    'symptoms_order'     =>  $this->input->post('symptoms_order'),
                    'symptoms_module'              =>  $this->input->post('module'),
                    'symptoms_health_category'     =>  $this->input->post('healthcategory'),
                    'symptoms_sub_health'          =>  $this->input->post('healthcategorysub'),
                    'symptoms_question'            =>  $this->input->post('botauto_question'),
                    'symptoms_auto_start'             =>  ($this->input->post('symptoms_auto_start') != '')?1:"0",
                    'symptoms_options'             =>  ($this->input->post('botauto_tags') != '')?$this->input->post('botauto_tags'):"",
                    "symptoms_created_on"          =>  date("Y-m-d H:i:s"),
                    "symptoms_created_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->insert("symptoms_chat_box",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array("symptoms_id    "=> $vsp."VSRT");	
                $this->db->update("symptoms_chat_box",$dat,array("symptomsid" => $vsp));
                return true;   
            }
    }
    public function delete_botauto($uri){
            $data = array(
                    'symptoms_open'             =>  0,
                    "symptoms_modified_on"          =>  date("Y-m-d H:i:s"),
                    "symptoms_modified_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("symptoms_chat_box",$data,array("symptoms_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
    }
    public function activedeactive($uri,$status){
            $data = array( 
                    'symptoms_acde'             =>  $status,
                    "symptoms_modified_on"          =>  date("Y-m-d H:i:s"),
                    "symptoms_modified_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("symptoms_chat_box",$data,array("symptoms_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
    }
    public function cntviewSymptomsbot($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->querySymptomsbot($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
    }
    public function viewSymptomsbot($params = array()){
        return $this->querySymptomsbot($params)->result_array();
    }
    public function getSymptomsbot($params = array()){
        return $this->querySymptomsbot($params)->row_array();
    }
    public function querySymptomsbot($params = array()){
        $dt     =   array(
                        "symptoms_status"         =>  "1",
                        "symptoms_open"       =>  "1"
                    );
        $sel    =   "*";
        if(array_key_exists("cnt",$params)){
                $sel    =   "count(*) as cnt";
        }
        if(array_key_exists("columns",$params)){
                $sel    =   $params["columns"];
        }
        $this->db->select("$sel")
                    ->from('symptoms_chat_box as c')
                    ->join('health_issues_category as fr','fr.healthcategory_open = 1 and fr.healthcategory_status = 1 and fr.healthcategory_id = c.symptoms_health_category','inner')
                    ->join('subcategory_issues as ss','ss.healthsubcategory_open = 1 and ss.healthsubcategory_status = 1 and ss.healthsubcategory_id = c.symptoms_sub_health','inner')
                    ->join('modules as m','m.moduleid = c.symptoms_module and module_open = 1 and module_status = 1','inner')
                    ->where($dt); 
        if(array_key_exists("keywords",$params)){
          $this->db->where("(symptoms_order LIKE '%".$params["keywords"]."%' or symptoms_question LIKE '%".$params["keywords"]."%' or symptoms_options LIKE '%".$params["keywords"]."%' or healthcategory_name LIKE '%".$params["keywords"]."%' or healthsubcategory_name LIKE '%".$params["keywords"]."%' or module_name LIKE '%".$params["keywords"]."%' OR symptoms_acde = '".$params["keywords"]."'  )");
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