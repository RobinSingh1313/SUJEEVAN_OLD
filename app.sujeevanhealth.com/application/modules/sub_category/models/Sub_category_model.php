<?php

class Sub_category_model extends CI_Model{
        public function create_sub_category(){
                $data = array(
                        'sub_category_name'                    =>  ucfirst($this->input->post('sub_category_name')),
                        'sub_category_alias_name'              =>  $this->common_config->cleanstr($this->input->post('sub_category_name')),
                        'sub_category_module_id'               =>  $this->input->post('module'),
                        'category_id'                          =>  $this->input->post('category'),
                        "sub_category_created_on"               =>  date("Y-m-d h:i:s"),
                        "sub_category_created_by"               =>  $this->session->userdata("login_id")
                );
                $this->db->insert("sub_category",$data);
                $vsp   =    $this->db->insert_id();
                if($vsp > 0){
                    $dat    =   array(
                                    "sub_category_id    "=> $vsp."VT"
                                );	
                    $this->db->update("sub_category",$dat,"sub_categoryid='".$vsp."'");
                    return true;   
                }
                return false;
        }
        public function cntviewSub_category($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->querySub_category($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewSub_category($params = array()){
            return $this->querySub_category($params)->result_array();
        }
        public function getSub_category($params = array()){
            return $this->querySub_category($params)->row_array();
        }
        public function update_sub_category($str){
            $data = array(
                    'sub_category_name'                    =>  ucfirst($this->input->post('sub_category_name')),
                    'sub_category_alias_name'              =>  $this->common_config->cleanstr($this->input->post('sub_category_name')),
                    'sub_category_module_id'               =>  $this->input->post('module'),
                    'category_id'                          =>  $this->input->post('category'),
                    "sub_category_modified_on"             =>  date("Y-m-d h:i:s"),
                    "sub_category_modified_by"             =>  $this->session->userdata("login_id")
            );
            $this->db->update("sub_category",$data,"sub_category_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function delete_sub_category($uro){
                $dta    =   array(
                    "sub_category_open"            =>  0, 
                    "sub_category_modified_on" =>    date("Y-m-d h:i:s"),
                    "sub_category_modified_by" =>    $this->session->userdata("login_id") 
                );
                $this->db->update("sub_category",$dta,array("sub_category_id" => $uro));
                $vsp   =    $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return FALSE;
            }
        public function activedeactive($uri,$status){
                $ft     =   array(  
                            "sub_category_acde"       =>    $status,
                            "sub_category_modified_on" =>    date("Y-m-d h:i:s"),
                            "sub_category_modified_by" =>    $this->session->userdata("login_id") 
                       );  
                $this->db->update("sub_category",$ft,array("sub_category_id" => $uri));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                echo $this->db->last_query();exit;
                return FALSE;
        }
        public function querySub_category($params = array()){
                 $dt     =   array(
                                "sub_category_open"         =>  "1",
                                "sub_category_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('sub_category as c')
                            ->join('modules as m','m.moduleid = c.sub_category_module_id','LEFT')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(sub_category_name LIKE '%".$params["keywords"]."%' OR module_name LIKE '%".$params["keywords"]."%' OR sub_category_acde = '".$params["keywords"]."'  )");
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
        public function unique_id_check_sub_category(){
                $str    =       $this->input->post('sub_category_name');
                $str1   =       $this->input->post('module'); 
                $str2   =       $this->input->post('category'); 
                $pms["whereCondition"]  =   "sub_category_name = '".$str."' AND sub_category_module_id = '".$str1."' AND category_id ='".$str2."'";
                $vsp    =   $this->getSub_category($pms);
                if(is_array($vsp) && count($vsp) > 0){
                return true;
                }
                return false;
        }
}