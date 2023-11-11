<?php
class Consult_model extends CI_Model{
    public function update_consult($vsp){
            $dat = array( 
                    'consult_module'              =>  $this->input->post('module'),
                    'consult_health_category'     =>  $this->input->post('healthcategory'),
                    'consult_order'     =>  $this->input->post('consult_order'),
                    'consult_health_category'     =>  $this->input->post('healthcategory'),
                    'consult_sub_health'          =>  $this->input->post('healthcategorysub'),
                    'consult_question'            =>  $this->input->post('botauto_question'),
                    'consult_options'             =>  ($this->input->post('botauto_tags') != '')?$this->input->post('botauto_tags'):"",
                    "consult_created_on"          =>  date("Y-m-d H:i:s"),
                    "consult_created_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("consult_chat_box",$dat,array("consult_id" => $vsp));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
    }
    public function create_consult(){
            $data = array( 
                    'consult_order'     =>  $this->input->post('consult_order'),
                    'consult_module'              =>  $this->input->post('module'),
                    
                    'consult_health_category'     =>  ($this->input->post('healthcategory') != '')?$this->input->post('healthcategory'):"",
                    'consult_sub_health'          =>  ($this->input->post('healthcategorysub') != '')?$this->input->post('healthcategorysub'):"",
                    'consult_question'            =>  $this->input->post('botauto_question'),
                    'consult_options'             =>  ($this->input->post('botauto_tags') != '')?$this->input->post('botauto_tags'):"",
                    "consult_created_on"          =>  date("Y-m-d H:i:s"),
                    "consult_created_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->insert("consult_chat_box",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array("consult_id    "=> $vsp."VSRT");	
                $this->db->update("consult_chat_box",$dat,array("consultid" => $vsp));
                return true;   
            }
    }
    public function delete_botauto($uri){
            $data = array(
                    'consult_open'             =>  0,
                    "consult_modified_on"          =>  date("Y-m-d H:i:s"),
                    "consult_modified_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("consult_chat_box",$data,array("consult_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
    }
    public function activedeactive($uri,$status){
            $data = array( 
                    'consult_acde'             =>  $status,
                    "consult_modified_on"          =>  date("Y-m-d H:i:s"),
                    "consult_modified_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("consult_chat_box",$data,array("consult_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
    }
    public function cntviewconsultbot($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->queryconsultbot($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
    }
    public function viewconsultbot($params = array()){
        return $this->queryconsultbot($params)->result_array();
    }
    public function getconsultbot($params = array()){
        return $this->queryconsultbot($params)->row_array();
    }
    public function queryconsultbot($params = array()){
        $dt     =   array(
                        "consult_status"         =>  "1",
                        "consult_open"       =>  "1"
                    );
        $sel    =   "*";
        if(array_key_exists("cnt",$params)){
                $sel    =   "count(*) as cnt";
        }
        if(array_key_exists("columns",$params)){
                $sel    =   $params["columns"];
        }
        $this->db->select("$sel")
                    ->from('consult_chat_box as c')
                    ->join('health_issues_category as fr','fr.healthcategory_open = 1 and fr.healthcategory_status = 1 and fr.healthcategory_id = c.consult_health_category','left')
                    ->join('subcategory_issues as ss','ss.healthsubcategory_open = 1 and ss.healthsubcategory_status = 1 and ss.healthsubcategory_id = c.consult_sub_health','left')
                    ->join('modules as m','m.moduleid = c.consult_module and module_open = 1 and module_status = 1','left')
                    ->where($dt); 
        if(array_key_exists("keywords",$params)){
          $this->db->where("(consult_order LIKE '%".$params["keywords"]."%' or consult_question LIKE '%".$params["keywords"]."%' or consult_options LIKE '%".$params["keywords"]."%' or healthcategory_name LIKE '%".$params["keywords"]."%' or healthsubcategory_name LIKE '%".$params["keywords"]."%' or module_name LIKE '%".$params["keywords"]."%' OR consult_acde = '".$params["keywords"]."'  )");
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