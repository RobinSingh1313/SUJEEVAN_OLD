<?php

class Questions_model extends CI_Model{
        public function create_qa(){
                $data = array(
                        'qa_question'                 =>  $this->input->post('qa_question'),
                        'qa_module_id'                =>  $this->input->post('module'),
                        'qa_healthcategory_id'        =>  $this->input->post('health_category'),
                        'qa_healthsubcategory_id'        =>  $this->input->post('health_sub_category'),
                        "qa_created_on"               =>  date("Y-m-d h:i:s"),
                        "qa_created_by"               =>  $this->input->post("regvendor_id"),
                        "qa_modified_by"               =>  $this->input->post("regvendor_id")
                );
                //print_r($this->session->userdata());exit;
          		if(is_array($_FILES) && count($_FILES) > 0){
                    $target_dir     =   $this->config->item("upload_dest");
                    $direct         =   $target_dir."/answers";
                    if (file_exists($direct)){
                    }else{mkdir($target_dir."/answers");}
                    $tmpFilePath = $_FILES['image']['tmp_name'];
                    if ($tmpFilePath != ""){    
                        $newFilePath = $direct."/".$_FILES['image']['name'];
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $picture       =  $_FILES['image']['name']  ;   
                        }
                      	//$data["qa_image_path"]	=	$picture;
                    }
                }
                $this->db->insert("questions",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    	$dat    =   array("qa_id" => $vsp."QA");	
                        $this->db->update("questions",$dat,"qaid='".$vsp."'");
                        $answer_data = array(
                            'ans_question_id' => $vsp."QA",
                            'ans_answer'      => $this->input->post('qa_answer'),
                            'ans_image'       => $picture,
                            'ans_regvendor_id'=> $this->input->post('regvendor_id'),
                            'created_at'      => date('Y-m-d H:i:s'),
                            'updated_at'      => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert("answers",$answer_data);
                        return true;   
                }
        }
        public function cntviewQa($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryQa($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewQa($params = array()){
            return $this->queryQa($params)->result_array();
        }
        public function viewAns($params = array()){
            return $this->multiple_answers($params)->result_array();
        }
        public function getQa($params = array()){
            return $this->queryQa($params)->row_array();
        }
        public function getAnswer($params = array()){
            return $this->queryAns($params)->row_array();
        }
        public function update_qa($str){
            $data = array(
                'qa_question'           =>  $this->input->post('qa_question'),
                'qa_module_id'             =>  $this->input->post('module'),
                'qa_healthcategory_id'        =>  $this->input->post('health_category'),
                'qa_healthsubcategory_id'        =>  $this->input->post('sub_health_category'),
                "qa_modified_on"        =>  date("Y-m-d h:i:s"),
                "qa_modified_by"        =>  $this->input->post('regvendor_id')
            );
            $picture ="";
            if(is_array($_FILES) && count($_FILES) > 0){
                $target_dir     =   $this->config->item("upload_dest");
                $direct         =   $target_dir."/blog";
                if (file_exists($direct)){
                }else{mkdir($target_dir."/blog");}
                $tmpFilePath = $_FILES['image']['tmp_name'];
                if ($tmpFilePath != ""){    
                    $newFilePath = $direct."/".$_FILES['image']['name'];
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                      $picture       =  $_FILES['image']['name']  ;   
                    }
                    $data["qa_image_path"]	=	$picture;
                }
            }
            $this->db->update("questions",$data,array("qa_id" => $str));
            $answer_data = array(
                            'ans_answer'      => $this->input->post('qa_answer'),
                            'ans_image'       => $picture,
                            'ans_regvendor_id'=> $this->input->post('regvendor_id'),
                            'updated_at'      => date('Y-m-d H:i:s'),
                        );
            $this->db->update("answers",$answer_data,array("answerid" => $this->input->post('answerid')));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    	}
        public function delete_qa($uro){
                $dta    =   array(
                    "qa_open"            =>  0, 
                    "qa_modified_on" =>    date("Y-m-d h:i:s"),
                    "qa_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("questions",$dta,array("qa_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "qa_acde"       =>    $status,
                            "qa_modified_on" =>    date("Y-m-d h:i:s"),
                            "qa_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("questions",$ft,array("qa_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function queryQa($params = array()){
                 $dt     =   array(
                                "qa_open"         =>  "1",
                                "qa_status"       =>  "1"
                            );
                $sel    =   "*";
                $join   =   "left";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                if(array_key_exists("join",$params)){
                        $join    =   $params["join"];
                }

                $this->db->select("$sel")
                            ->from('questions as q')  
                            ->join('modules as m','m.moduleid = q.qa_module_id and m.module_open = 1 and m.module_status = 1','inner')
                            ->join('health_issues_category as h','h.healthcategory_id = q.qa_healthcategory_id and h.healthcategory_open = 1 and h.healthcategory_status = 1','inner')
                            ->join('subcategory_issues as s','s.healthsubcategory_id = q.qa_healthsubcategory_id and s.healthsubcategory_open = 1 and s.healthsubcategory_status = 1','inner')
                            ->join('answers as a','a.ans_question_id=q.qa_id',"$join")
                            ->where($dt); 

                if(array_key_exists("keywords",$params)){
                  $this->db->where("(qa_question LIKE '%".$params["keywords"]."%' or healthcategory_name like '%".$params["keywords"]."%' or qa_acde like '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR healthsubcategory_acde = '".$params["keywords"]."'  )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("group_by", $params)){
                    $this->db->group_by($params['group_by']);
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
        public function queryAns($params = array()){
               
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('answers');  
              
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(qa_question LIKE '%".$params["keywords"]."%' or sub_module_name like '%".$params["keywords"]."%' or qa_acde like '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR qa_acde = '".$params["keywords"]."'  )");
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
        public function multiple_answers($params)
        {
            

                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('answers');  
                          
               
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
              //  $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
}