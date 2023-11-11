<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Complaint_model extends CI_Model{
        public function createbbotstting($rui){
                $data   =   array(
                    "chat_box_from_timings" =>  $this->input->post("chat_box_from_timings"),
                    "chat_box_to_timings"   =>  $this->input->post("chat_box_to_timings"),
                    "chatbox_queue"         =>  $this->input->post("chatbox_queue"),
                    "chatbox_working_days"      =>  implode(",",$this->input->post("chatbox_working_days")),
                    "chat_bot_from_timings"     =>  $this->input->post("chat_bot_from_timings"),
                    "chat_bot_to_timings"       =>  $this->input->post("chat_bot_to_timings"),
                    "chat_modified_on"     =>  date("Y-m-d H:i:s"),
                    "chat_modified_by"     =>  $this->session->userdata("login_id"),
                );
                $ssp    =    $this->db->update("chat_bot_settings",$data,array("chatid" => $rui)); 
                $vsp    =   $this->db->affected_rows();
                if($vsp > 0){
                    return true;
                }
                return false;
        }
        public function delete_chatroom($uri){
                $dta    =   array( 
                                "chatroom_open"         =>      0,
                                "chatroom_created_on"   =>      date("Y-m-d H:i:s"),
                                "chatroom_created_by"   =>      $this->session->userdata("login_id")
                            );
                $vsp    =    $this->db->update("chatroom",$dta,array("chatroom_id" => $uri)); 
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function activedeactive($uri,$status){
                $dta    =   array( 
                                "chatroom_acde"         =>      $status,
                                "chatroom_created_on"   =>      date("Y-m-d H:i:s"),
                                "chatroom_created_by"   =>      $this->session->userdata("login_id")
                            );
                $vsp    =    $this->db->update("chatroom",$dta,array("chatroom_id" => $uri)); 
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }
                return FALSE;
        }
        public function update_chatroom($chatid){
                $dta    =   array( 
                                "chatroom_name"     =>      $this->input->post("chat_room_name"),
                                "chatroom_user"     =>      $this->input->post("chat_room_user"),
                                "chatroom_loginname"     =>      $this->input->post("chat_loginname"),
                                "chatroom_password"      =>      $this->input->post("chat_login_password"),
                                "chatroom_languages"     =>      $this->input->post("chat_language"),
                                "chatroom_regions"       =>      $this->input->post("regionname"),
                                "chatroom_modified_on"   =>      date("Y-m-d H:i:s"),
                                "chatroom_modified_by"   =>      $this->session->userdata("login_id")
                            );
                $vsp    =    $this->db->update("chatroom",$dta,array("chatroom_id" => $chatid)); 
                $vsp    =    $this->db->affected_rows();
                if($vsp > 0){ 
                  	$dta    =   array( 
                                "login_name"      =>    $this->input->post("chat_loginname"),
                                "login_email"     =>    ($this->input->post("useremail")), 
                                "login_md_on"     =>    date("Y-m-d H:i:s"),
                                "login_password"  =>    base64_encode($this->input->post("chat_login_password")),
                                "login_md_by"     =>    $this->session->userdata("login_id")
                            );
                	$this->db->update("login",$dta,array("login_chat_id" => $chatid)); 
                  	return TRUE;
                }
                return FALSE;
        }
        public function createchatroom(){
                $dta    =   array( 
                                "chatroom_name"     =>      $this->input->post("chat_room_name"),
                                "chatroom_user"     =>      $this->input->post("chat_room_user"),
                                "chatroom_loginname"    =>      $this->input->post("chat_login_name"),
                                "chatroom_password"     =>      $this->input->post("chat_login_password"),
                                "chatroom_languages"    =>      $this->input->post("chat_language"),
                                "chatroom_regions"      =>      $this->input->post("regionname"),
                                "chatroom_created_on"   =>      date("Y-m-d H:i:s"),
                                "chatroom_created_by"   =>      $this->session->userdata("login_id")
                            );
                $this->db->insert("chatroom",$dta); 
                $vsp    =    $this->db->insert_id();
                if($vsp > 0){ 
                    $suplid     =   "CTR".$vsp;
                    $vsp    =    $this->db->update("chatroom",array("chatroom_id" => $suplid),array("chatroomid" => $vsp)); 
                  	$ps		=	$this->input->post("chat_login_password");
                    $dta    =   array( 
                                    "login_name"      =>    $this->input->post("chat_login_name"),
                                    "login_email"     =>    $this->input->post("chat_login_name"),
                                    "login_password"  =>    base64_encode($ps),
                                    "login_type"      =>    "5utype",
                      				"login_chat_id"	  =>	$suplid,
                                    "login_cr_on"     =>    date("Y-m-d H:i:s"),
                                    "login_cr_by"     =>    $this->session->userdata("login_id")
                                );
                    $this->db->insert("login",$dta); 
                    $vsp    =    $this->db->insert_id();
                    if($vsp > 0){ 
                        $suplid     =   "LOGN".$vsp;
                        $vsp    =   $this->db->update("login",array("login_id" => $suplid),array("lid" => $vsp)); 
                    }
                    return TRUE;
                }
                return FALSE;
        }
        public function queryChatroom($params = array()){
                $dt         =   array(
                                    "chatroom_open"      =>     '1',
                                    "chatroom_status"    =>     '1'
                            );
                $sel        =   "*";
                if(array_key_exists("cnt",$params)){
                    $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                    $sel    =    $params["columns"];
                }
                $this->db->select($sel)
                            ->from("chatroom as c")
                            ->join("region as re","re.region_id = c.chatroom_regions and re.region_open = 1 and re.region_status = 1","inner")
                            ->where($dt);
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("keywords",$params)){
                        $this->db->where("(chatroom_name LIKE '%".$params["keywords"]."%' OR chatroom_user LIKE '%".$params["keywords"]."%' OR chatroom_loginname LIKE '%".$params["keywords"]."%' OR chatroom_languages LIKE '%".$params["keywords"]."%'  OR chatroom_acde LIKE '%".$params["keywords"]."%')");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                }
//                $this->db->get();echo $this->db->last_query();exit;
                return  $this->db->get();
        }
        public function cntviewChatroom($params  =    array()){
                $params["cnt"]      =   "1";
                $val    =   $this->queryChatroom($params)->row_array();
                if(count($val) > 0){
                    return  $val['cnt'];
                }
                return "0";
        }
        public function viewChatroom($params = array()){
                $vsp    =   $this->queryChatroom($params)->result_array();
                return $vsp;
        }
        public function getChatroom($params = array()){
                return $this->queryChatroom($params)->row_array();
        }
        public function check_unique_chat($uri){
                $params["cnt"]              =   '1';
                $params["whereCondition"]   =   "lower(chatroom_loginname) like '".strtolower($uri)."'";
                $vsl        =   $this->queryChatroom($params)->row_array(); 
                if($vsl["cnt"] ==  0){
                    return FALSE;
                }                       
                return TRUE;
        }
}