<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Botconfiguration extends CI_Controller{
        public function __construct() {
            parent::__construct();
            if($this->session->userdata("chat-room-configuration") != "1"){
                redirect(sitedata("site_admin")."/Dashboard"); 
            }
        }
        public function index(){
            $darta  =   array(
                'title'     =>  "Auto Box Configuration",
                "content"   =>  "box_configuration",
                "til"       =>  "Auto Box",
                "vtil"      =>  ""
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("botauto_tags","Tags Input","required");
                $this->form_validation->set_rules("botauto_answer","Answer","required");
                if($this->form_validation->run() == TRUE){
                    $insk   =   $this->botconfiguation_model->createbot();
                    if($insk){
                        $this->session->set_flashdata("suc","Auto Box configuration successfully");
                        redirect(sitedata("site_admin")."/Chat-Room-Configuration"); 
                    }else{
                        $this->session->set_flashdata("err","Auto Box configuration has been not done.Please try again");
                        redirect(sitedata("site_admin")."/Chat-Room-Configuration"); 
                    }
                }
            }
            $orderby        =   $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
            $tipoOrderby    =   $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"botautotagid";  
            $conditions     =   array();
            if(!empty($orderby) && !empty($tipoOrderby)){ 
                $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
            } 
            $keywords   =   $this->input->get('keywords'); 
            if(!empty($keywords)){
                $conditions['keywords'] = $keywords;
            }
            $darta["pageurl"]   =   $pageurl    =   "BOTCONGI"; 
            $darta["rview"]       =   "0";
            $darta["urlvalue"]    =   adminurl("viewBotconfig/");
            $this->load->view("inner_template",$darta);
        }
        public function viewBotconfig(){
            $conditions =   array();
            $page       =   $this->uri->segment('3');
            $offset     =   (!$page)?"0":$page;
            
            $dta["pageurl"]   =   $pageurl    =   "BOTCONGI";
            $dta["offset"]    =   $offset;
            $keywords       =   $this->input->post('keywords');
            if(!empty($keywords)){
                $dta['keywords']        = $keywords;
                $conditions['keywords'] = $keywords;
            }  
            $this->session->set_userdata("arr".$pageurl,$dta);
            $totalRec       =    0;
            $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination"); 
            $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
            $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"botautotagid"; 
            if($perpage != $this->config->item("all")){
                $totalRec               =   $this->botconfiguation_model->cntviewBots($conditions);  
                $config['base_url']     =   adminurl('viewBotconfig');
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
            $dta["view"]            =   $view   =   $this->botconfiguation_model->viewBots($conditions); 
            $dta["urlvalue"]        =   adminurl("viewBotconfig/");
            $dta["totalrows"]       =   $totalRec-count($view);
            $dta["offset"]          =   $offset;
            $this->load->view("botconfig_ajax",$dta);
        }
        public function activedeactive(){
                $vsp    =   "0";
                if($this->session->userdata("active-deactive-chat-bot") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields"); 
                    $parsm["whereCondition"]    =   "botautotag_id = '".$uri."'";
                    $vue    =   $this->botconfiguation_model->getBots($parsm);
                    if(is_array($vue) && count($vue) > 0){
                            $bt     =   $this->botconfiguation_model->activedeactive($uri,$status); 
                            if($bt > 0){
                                $vsp    =   1;
                            }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function deleteebot(){
                $vsp    =   "0";
                if($this->session->userdata("delete-chat-bot") != '1'){
                    $vsp    =   "0";
                }else{
                    $uri    =   $this->uri->segment("3");
                    $parsm["whereCondition"]    =   "botautotag_id = '".$uri."'";
                    $vue    =   $this->botconfiguation_model->getBots($parsm);
                    if(is_array($vue) && count($vue) > 0){
                            $bt     =   $this->botconfiguation_model->delete_botauto($uri); 
                            if($bt > 0){
                                $vsp    =   1;
                            }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function updatebot(){
                if($this->session->userdata("update-chat-bot") != '1'){
                        redirect(sitedata("site_admin")."/Dashboard");
                }
                $uri    =   $this->uri->segment("3"); 
                $parsm["whereCondition"]    =   "botautotag_id = '".$uri."'";
                $vue    =   $this->botconfiguation_model->getBots($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $dt     =   array(
                                "title"     =>  "Update Chat Room Configuration",
                                "content"   =>  "botconfig_update",
                                "icon"      =>  "mdi mdi-account",
                                "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Chat-Room-Configuration")."'>Chat Room Configuration</a></li>",
                                "view"      =>  $vue
                        ); 
                        if($this->input->post("submit")){
                            $this->form_validation->set_rules("botauto_tags","Tags Input","required");
                            $this->form_validation->set_rules("botauto_answer","Answer","required");
                            if($this->form_validation->run() == TRUE){
                                $bt     =   $this->botconfiguation_model->update_botauto($uri);
                                if($bt > 0){
                                    $this->session->set_flashdata("suc","Updated chat room configuration Successfully.");
                                    redirect(sitedata("site_admin")."/Chat-Room-Configuration");
                                }else{
                                    $this->session->set_flashdata("err","Not Updated chat room configuration.Please try again.");
                                    redirect(sitedata("site_admin")."/Chat-Room-Configuration");
                                }
                            }
                        }
                        $this->load->view("inner_template",$dt);
                }else{
                        $this->session->set_flashdata("war","Chat room box does not exists."); 
                        redirect(sitedata("site_admin")."/Chat-Room-Configuration");
                }
        }
        public function __destruct() {
                $this->db->close();
        }
}