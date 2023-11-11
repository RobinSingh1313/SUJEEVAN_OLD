<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Complaints extends CI_Controller{
        public function __construct() {
            parent::__construct();
            if($this->session->userdata("manage-complaint-management") != '1'){
                redirect(sitedata("site_admin")."/Dashboard"); 
            }
        }
        public function index(){
            $darta  =   array(
                'title'     =>  "Complaint Management",
                "content"   =>  "masters_complaints",
                "vtil"      =>  ''
            );
            $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
            $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"chatroomid";  
            $conditions     =   array();
            if(!empty($orderby) && !empty($tipoOrderby)){ 
                $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
            } 
            $keywords   =   $this->input->get('keywords'); 
            if(!empty($keywords)){
                $conditions['keywords'] = $keywords;
            }
            if($this->input->get("search")){
                $this->common_model->exceldownload("Complaints",$conditions);
            }
            $darta["pageurl"]   =   $pageurl    =   "CHATROOM";
            $darta["rview"]       =   "1";
            $darta["urlvalue"]    =   adminurl("viewChatroom/");
            $this->load->view("engsnaplayout/inner_template",$darta);
        }
        public function createroom(){
            if($this->session->userdata("create-chat-room") != '1'){
                redirect(sitedata("site_admin")."/Dashboard"); 
            }
            $darta  =   array(
                'title'     =>  "Chat Room",
                "content"   =>  "chatroom",
                "vtil"      =>  "<li class='breadcrumb-item'><a href='".adminurl("Complaint-Management")."'>Complaint Management</a></li>"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("chat_room_name","Room Name","required|xss_clean|trim|max_length[50]");
                $this->form_validation->set_rules("chat_room_user","Room User","required|xss_clean|trim|max_length[50]");
                $this->form_validation->set_rules("chat_login_name","Login Name","required|xss_clean|trim|min_length[3]|max_length[50]|callback_check_unique_chat");
                $this->form_validation->set_rules("chat_login_password","Login Password","required|xss_clean|trim|min_length[3]|max_length[50]");
                $this->form_validation->set_rules("chat_language","Language","required|xss_clean|trim");
                $this->form_validation->set_rules("regionname","Region","required");
                if($this->form_validation->run() == true){
                    $thin   =   $this->complaint_model->createchatroom();
                    if($thin){
                        $this->session->set_flashdata("suc","Created chat room user Successfully.");
                        redirect(sitedata("site_admin")."/Complaint-Management");
                    }else{
                        $this->session->set_flashdata("err","Not created chat room user.Please try again.");
                        redirect(sitedata("site_admin")."/Complaint-Management");
                    }
                }
            }
            $this->load->view("engsnaplayout/inner_template",$darta); 
        }
        public function viewChatroom(){
            $conditions =   array();
            $page       =   $this->uri->segment('3');
            $offset     =   (!$page)?"0":$page;
            $dta["pageurl"]   =   $pageurl    =   "CHATROOM";
            $dta["offset"]    =   $offset;
            $keywords       =   $this->input->post('keywords');
            if(!empty($keywords)){
                $dta['keywords']        = $keywords;
                $conditions['keywords'] = $keywords;
            }  
            $this->session->set_userdata("arr".$pageurl,$dta); 
            $totalRec       =    0;
             $jwcond =   "";
            $activestatus =    $this->input->post("activelist")?$this->input->post("activelist"):"";
            if($activestatus != ""){
                $jwcond     .=  "chatroom_acde = '".$activestatus."'";
            }
            if($jwcond != ""){
                $conditions['whereCondition'] = $jwcond;
            }
            $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination"); 
            $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
            $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"chatroomid"; 
            if($perpage != $this->config->item("all")){
                $totalRec               =   $this->complaint_model->cntviewChatroom($conditions);  
                $config['base_url']     =   adminurl('viewChatroom');
                $config['total_rows']   =   $totalRec;
                $config['per_page']     =   $perpage; 
                $config['link_func']    =   'searchFilter';
                $this->ajax_pagination->initialize($config);
                $conditions['start']    =   $offset;  
                $conditions['limit']    =   $perpage;
            }
            if(!empty($orderby) && !empty($tipoOrderby)){ 
                $dta['orderby']        =   $conditions['order_by']      =   $orderby;
                $dta['tipoOrderby']    =   $conditions['tipoOrderby']   =   $tipoOrderby; 
            } 
            $dta["limit"]           =   (int)$offset+1;
            $dta["view"]            =   $view   =   $this->complaint_model->viewChatroom($conditions); 
            $dta["urlvalue"]        =   adminurl("viewChatroom/");
            $dta["totalrows"]       =   $totalRec-count($view);
            $dta["offset"]          =   $offset;
            $this->load->view("chatroom_ajax",$dta);
        }
        public function unique_loginchat_name(){
                $str    =   $this->input->post("chat_login_name");
                $vsp	=   $this->complaint_model->check_unique_chat($str);  
                echo ($vsp)?"false":"true";
        }
        public function check_unique_chat($str){ 
                $vsp	=	$this->complaint_model->check_unique_chat($str); 
                if($vsp){
                        $this->form_validation->set_message("check_unique_chat","Activity Name already exists.");
                        return FALSE;
                }	
                return TRUE; 
        }
        public function createserttings(){
            if($this->session->userdata("chat-room-settings") != '1'){
                redirect(sitedata("site_admin")."/Dashboard"); 
            }
            $darta  =   array(
                'title'     =>  "Chat Room Settings",
                "content"   =>  "room_settings",
                "vtil"      =>  "<li class='breadcrumb-item'><a href='".adminurl("Complaint-Management")."'>Complaint Management</a></li>",
                "view"  =>  $this->common_model->chatbotsettings("1")
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("chat_box_from_timings","From Timings","required");
                $this->form_validation->set_rules("chat_box_to_timings","To Timings","required");
                $this->form_validation->set_rules("chatbox_queue","Chatbox Queue","required");
                $this->form_validation->set_rules("chat_bot_from_timings","Bot From Timings","required");
                $this->form_validation->set_rules("chat_bot_to_timings","Bot To Timings","required");
                if($this->form_validation->run() == true){
                    $thin   =   $this->complaint_model->createbbotstting("1");
                    if($thin){
                        $this->session->set_flashdata("suc","Updated chat box settings Successfully.");
                        redirect(sitedata("site_admin")."/Chat-Room-Settings");
                    }else{
                        $this->session->set_flashdata("err","Not Updated chat box settings.Please try again.");
                        redirect(sitedata("site_admin")."/Chat-Room-Settings");
                    }
                }
            }
            $this->load->view("engsnaplayout/inner_template",$darta);
        }
        public function activedeactive(){
                $vsp    =   "0";
                if($this->session->userdata("active-deactive-chat-room") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields"); 
                    $parsm["whereCondition"]    =   "chatroom_id = '".$uri."'";
                    $vue    =   $this->complaint_model->getChatroom($parsm);
                    if(is_array($vue) && count($vue) > 0){
                            $bt     =   $this->complaint_model->activedeactive($uri,$status); 
                            if($bt > 0){
                                $vsp    =   1;
                            }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function deletechatroom(){
                $vsp    =   "0";
                if($this->session->userdata("delete-chat-room") != '1'){
                    $vsp    =   "0";
                }else{
                    $uri    =   $this->uri->segment("3");
                    $parsm["whereCondition"]    =   "chatroom_id = '".$uri."'";
                    $vue    =   $this->complaint_model->getChatroom($parsm);
                    if(is_array($vue) && count($vue) > 0){
                            $bt     =   $this->complaint_model->delete_chatroom($uri); 
                            if($bt > 0){
                                $vsp    =   1;
                            }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function updatechatroom(){
                if($this->session->userdata("update-chat-room") != '1'){
                        redirect(sitedata("site_admin")."/Dashboard");
                }
                $uri    =   $this->uri->segment("3"); 
                $parsm["whereCondition"]    =   "chatroom_id = '".$uri."'";
                $vue    =   $this->complaint_model->getChatroom($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $dt     =   array(
                                "title"     =>  "Update Chat Room",
                                "content"   =>  "chatroom_update",
                                "icon"      =>  "mdi mdi-account",
                                "vtil"      =>  "<li class='breadcrumb-item'><a href='".adminurl("Complaint-Management")."'>Complaint Management</a></li><li class='breadcrumb-item'><a href='". adminurl("Complaint-Management")."'>Chat Room Configuration</a></li>",
                                "view"      =>  $vue
                        ); 
                        if($this->input->post("submit")){
                            $this->form_validation->set_rules("chat_room_name","Room Name","required|xss_clean|trim|max_length[50]");
                            $this->form_validation->set_rules("chat_room_user","Room User","required|xss_clean|trim|max_length[50]");
                            $this->form_validation->set_rules("chat_loginname","Login Name","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("chat_login_password","Login Password","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("chat_language","Language","required|xss_clean|trim");
                            $this->form_validation->set_rules("regionname","Region","required");
                            if($this->form_validation->run() == TRUE){
                                $bt     =   $this->complaint_model->update_chatroom($uri);
                                if($bt > 0){
                                    $this->session->set_flashdata("suc","Updated chat room details Successfully.");
                                    redirect(sitedata("site_admin")."/Complaint-Management");
                                }else{
                                    $this->session->set_flashdata("err","Not Updated chat room details.Please try again.");
                                    redirect(sitedata("site_admin")."/Complaint-Management");
                                }
                            }
                        }
                        $this->load->view("engsnaplayout/inner_template",$dt);
                }else{
                        $this->session->set_flashdata("war","Chat room box does not exists."); 
                        redirect(sitedata("site_admin")."/Complaint-Management");
                }
        }
        public function __destruct() {
            $this->db->close();
        }
}
