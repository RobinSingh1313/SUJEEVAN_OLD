<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class App_users extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-app-users") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function index(){
                $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "All Modules",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regvendorid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "VENDORAPP";
                $dta["urlvalue"]  =   adminurl("viewAppvendors/");
                $this->load->view("inner_template",$dta);
        }
        public function viewAppvendors(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "VENDORAPP";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                $conditions['group_by']= "r.regvendor_id";
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regvendorid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->vendor_registration_model->cntviewRegistration($conditions);  
                    $config['base_url']     =   adminurl('viewAppvendors');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                    $conditions['start']    =   $offset;
                    $conditions['limit']    =   $perpage;
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =   $conditions['order_by']   =   $orderby;
                        $dta['tipoOrderby']    =   $conditions['tipoOrderby']   =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewAppvendors/');
//                $conditions["columns"]      =   "cpage_title,content_from_name,layout_name,cpage_show_menu,cpage_ac_de,cpage_id";
                $dta["view"]            =   $view	=	$this->vendor_registration_model->viewRegistration($conditions);
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_vendors",$dta);
        }
        public function viewAppCustomers(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERAPP";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"registrationid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->registration_model->cntviewRegistration($conditions);  
                    $config['base_url']     =   adminurl('viewAppCustomers');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                    $conditions['start']    =   $offset;
                    $conditions['limit']    =   $perpage;
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =   $conditions['order_by']   =   $orderby;
                        $dta['tipoOrderby']    =   $conditions['tipoOrderby']   =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewAppCustomers/');
//                $conditions["columns"]      =   "cpage_title,content_from_name,layout_name,cpage_show_menu,cpage_ac_de,cpage_id";
                $dta["view"]            =   $view	=	$this->registration_model->viewRegistration($conditions);
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_customers",$dta);
        }
        public function indexcustomers(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "All APP Customers",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regvendorid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERAPP";
                $dta["urlvalue"]  =   adminurl("viewAppCustomers/");
                $this->load->view("inner_template",$dta);
        }
        public function activedeactive(){
                $vsp    =   "0";
                if($this->session->userdata("active-deactive-module") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields"); 
                    $condii['whereCondition'] ="registration_id = '".$uri."'";
                    $vue    =   $this->registration_model->getRegistration($condii);
                    if(count($vue) > 0){
                            $bt     =   $this->registration_model->activedeactive($uri,$status); 
                            if($bt > 0){
                                $vsp    =   1;
                            }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function assignTelecaller(){
                $uri    =   $this->input->post('id');
                echo $this->registration_model->assignTellecaller($uri,$this->input->post('status'));
        }
        public function assignDoctor(){
                $uri    =   $this->input->post('id');
                echo $this->registration_model->assignDoctor($uri,$this->input->post('status'));
        }
        public function __destruct() {
                $this->db->close();
        }
}