<?php

class Video_type_model extends CI_Model{
        public function create_video_type(){
            $data = array(
                    'video_type_name'                    =>  ucfirst($this->input->post('video_type_name')),
                    "video_type_created_on"               =>  date("Y-m-d h:i:s"),
                    "video_type_created_by"               =>  $this->session->userdata("login_id")
            );
            $this->db->insert("Video_type",$data);
            $vsp   =    $this->db->insert_id();
            if($vsp > 0){
                $dat    =   array(
                                "video_type_id    "=> $vsp."VT"
                            );	
                $this->db->update("Video_type",$dat,"video_typeid='".$vsp."'");
                return true;   
            }
            return false;
        }
        public function cntviewVideo_type($params  = array()){
            $params["columns"]  =   "count(*) as cnt";
            $vsp     =  $this->queryVideo_type($params)->row_array();
            if($vsp != '' && count($vsp) > 0){
                    return $vsp['cnt'];
            }
            return 0;
        }
        public function viewVideo_type($params = array()){
            return $this->queryVideo_type($params)->result_array();
        }
        public function getVideo_type($params = array()){
            return $this->queryVideo_type($params)->row_array();
        }
        public function update_video_type($str){
            $data = array(
                    'video_type_name'                    =>  ucfirst($this->input->post('video_type_name')),
                    "video_type_modified_on"               =>  date("Y-m-d h:i:s"),
                    "video_type_modified_by"               =>  $this->session->userdata("login_id")
            );
            $this->db->update("Video_type",$data,"video_type_id='".$str."'");
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function delete_video_type($uro){
            $dta    =   array(
                "video_type_open"            =>  0, 
                "video_type_modified_on" =>    date("Y-m-d h:i:s"),
                "video_type_modified_by" =>    $this->session->userdata("login_id") 
            );
            $this->db->update("video_type",$dta,array("video_type_id" => $uro));
            $vsp   =    $this->db->affected_rows();
            if($vsp > 0){
                return true;
            }
            return FALSE;
        }
        public function activedeactive($uri,$status){
            $ft     =   array(  
                        "video_type_acde"       =>    $status,
                        "video_type_modified_on" =>    date("Y-m-d h:i:s"),
                        "video_type_modified_by" =>    $this->session->userdata("login_id") 
                   );  
            $this->db->update("video_type",$ft,array("video_type_id" => $uri));
            if($this->db->affected_rows() > 0){
                return TRUE;
            }
            return FALSE;
        }
        public function queryVideo_type($params = array()){
                 $dt     =   array(
                                "video_type_open"         =>  "1",
                                "video_type_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('video_type')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(video_type_name LIKE '%".$params["keywords"]."%' OR video_type_acde LIKE '%".$params["keywords"]."%')");
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