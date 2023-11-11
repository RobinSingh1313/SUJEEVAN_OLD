<?php

class Category_model extends CI_Model{
        public function create_category(){
                $data = array(
                        'category_name'                    =>  ucfirst($this->input->post('category_name')),
                        'category_alias_name'              =>  $this->common_config->cleanstr($this->input->post('category_name')),
                        'category_module_id'               =>  $this->input->post('module'),
                        "category_created_on"               =>  date("Y-m-d h:i:s"),
                        "category_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("category",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "category_id    "=> $vsp."VT"
                                );	
                        $this->db->update("category",$dat,"categoryid='".$vsp."'");
                        return true;   
                 }
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
        public function getCategory($params = array()){
            return $this->queryCategory($params)->row_array();
        }
        public function update_category($str){
            $data = array(
                    'category_name'                    =>  ucfirst($this->input->post('category_name')),
                    'category_alias_name'              =>  $this->common_config->cleanstr($this->input->post('category_name')),
                    'category_module_id'               =>  $this->input->post('module'),
                    "category_modified_on"             =>  date("Y-m-d h:i:s"),
                    "category_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("category",$data,"category_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
    }
        public function delete_category($uro){
                $dta    =   array(
                    "category_open"            =>  0, 
                    "category_modified_on" =>    date("Y-m-d h:i:s"),
                    "category_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("category",$dta,array("category_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "category_acde"       =>    $status,
                            "category_modified_on" =>    date("Y-m-d h:i:s"),
                            "category_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("category",$ft,array("category_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function queryCategory($params = array()){
                 $dt     =   array(
                                "category_open"         =>  "1",
                                "category_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('category as c')
                            ->join('modules as m','m.moduleid = c.category_module_id','LEFT')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(category_name LIKE '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR category_acde = '".$params["keywords"]."'  )");
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
                $str    =       $this->input->post('category_name');
                $str1   =       $this->input->post('module'); 
                $ms     =   "";
                $category_id    =   $this->input->post("category_id");
                if($category_id != ""){
                    $ms     =   " and category_id not like '".$category_id."'";
                }
                $pms["whereCondition"]  =   "category_name = '".$str."' AND category_module_id = '".$str1."' $ms";
                $vsp    =   $this->getCategory($pms);
                if(is_array($vsp) && count($vsp) > 0){
                    return true;
                }
                return false;
        }
}