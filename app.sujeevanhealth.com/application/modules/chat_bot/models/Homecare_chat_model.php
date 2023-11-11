<?php
class Homecare_chat_model extends CI_Model{
    public function update_homecare($vsp){
            $dat = array( 
                    'homecare_chat_module'              =>  $this->input->post('module_id'),
                    'homecare_chat_order'               =>  $this->input->post('order'),
                    'homecare_chat_question'            =>  $this->input->post('botauto_question'),
                    'homecare_chat_options'             =>  ($this->input->post('botauto_tags') != '')?$this->input->post('botauto_tags'):"",
                    'homecare_chat_sub_module'          =>  $this->input->post('submodule'),
                    "homecare_chat_created_on"          =>  date("Y-m-d H:i:s"),
                    "homecare_chat_created_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("homecare_chat_box",$dat,array("homecare_chat_id" => $vsp));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
    }
    public function create_homecare(){
            $data = array( 
                    'homecare_chat_module'              =>  $this->input->post('module_id'),
                    'homecare_chat_order'               =>  $this->input->post('order'),
                    'homecare_chat_question'            =>  $this->input->post('botauto_question'),
                    'homecare_chat_options'             =>  ($this->input->post('botauto_tags') != '')?$this->input->post('botauto_tags'):"",
                    'homecare_chat_sub_module'          =>  $this->input->post('submodule'),
                    "homecare_chat_created_on"          =>  date("Y-m-d H:i:s"),
                    "homecare_chat_created_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->insert("homecare_chat_box",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array("homecare_chat_id    "=> $vsp."VSRT");	
                $this->db->update("homecare_chat_box",$dat,array("homecare_chatid" => $vsp));
                return true;   
            }
    }
    public function delete_botauto($uri){
            $data = array(
                    'homecare_chat_open'             =>  0,
                    "homecare_chat_modified_on"          =>  date("Y-m-d H:i:s"),
                    "homecare_chat_modified_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("homecare_chat_box",$data,array("homecare_chat_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
    }
    public function activedeactive($uri,$status){
            $data = array( 
                    'homecare_chat_acde'             =>  $status,
                    "homecare_chat_modified_on"          =>  date("Y-m-d H:i:s"),
                    "homecare_chat_modified_by"          =>  $this->session->userdata("login_id")
            );
            $this->db->update("homecare_chat_box",$data,array("homecare_chat_id" => $uri));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){	
                return true;   
            }
            return false;
    }
    public function cntviewHomecarebot($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->queryHomecarebot($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
    }
    public function viewHomecarebot($params = array()){
        return $this->queryHomecarebot($params)->result_array();
    }
    public function getHomecarebot($params = array()){
        return $this->queryHomecarebot($params)->row_array();
    }
    public function queryHomecarebot($params = array()){
        $dt     =   array(
                        "homecare_chat_status"         =>  "1",
                        "homecare_chat_open"       =>  "1"
                    );
        $sel    =   "*";
        if(array_key_exists("cnt",$params)){
                $sel    =   "count(*) as cnt";
        }
        if(array_key_exists("columns",$params)){
                $sel    =   $params["columns"];
        }
        $this->db->select("$sel")
                    ->from('homecare_chat_box as hc')
                    ->join('sub_module as sm','sm.sub_module_id = hc.homecare_chat_sub_module','left')
                    ->where($dt); 
        if(array_key_exists("keywords",$params)){
          $this->db->where("(homecare_chat_order LIKE '%".$params["keywords"]."%' or homecare_chat_question LIKE '%".$params["keywords"]."%' or homecare_chat_options LIKE '%".$params["keywords"]."%' or healthcategory_name LIKE '%".$params["keywords"]."%' or healthsubcategory_name LIKE '%".$params["keywords"]."%' or module_name LIKE '%".$params["keywords"]."%' OR homecare_chat_acde = '".$params["keywords"]."'  )");
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