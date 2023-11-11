<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Allmodules extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-modules") != '1'){
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
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"moduleid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "MODULES";
                $dta["urlvalue"]  =   adminurl("viewModules/");
                $this->load->view("inner_template",$dta);
        }
        public function viewModules(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "MODULES";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"moduleid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->common_model->cntviewModules($conditions);  
                    $config['base_url']     =   adminurl('viewModules');
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
                $dta["urlvalue"]           	=   adminurl('viewModules/');
//                $conditions["columns"]      =   "cpage_title,content_from_name,layout_name,cpage_show_menu,cpage_ac_de,cpage_id";
                $dta["view"]            =   $view	=	$this->common_model->viewModules($conditions);
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_modules",$dta);
        }
        public function activedeactive(){
            $vsp    =   "0";
            if($this->session->userdata("active-deactive-module") != '1'){
                $vsp    =   "0";
            }else{
                $status     =   $this->input->post("status");
                $uri        =   $this->input->post("fields"); 
                $pms["whereCondition"]    =   "moduleid = '".$uri."'";
                $vue    =   $this->common_model->getModules($pms);
                if(is_array($vue) && count($vue) > 0){
                    $bt     =   $this->common_model->activedeactive($uri,$status); 
                    if($bt > 0){
                        $vsp    =   1;
                    }
                }else{
                    $vsp    =   2;
                } 
            } 
            echo $vsp;
        }
        public function update_module(){
            if($this->session->userdata("update-module") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
            } 
            $uri            =   $this->uri->segment("3"); 
            $pms["whereCondition"]    =   "moduleid = '".$uri."'";
            $vue            =   $this->common_model->getModules($pms);
            if($vue){
                 $data  = array(
                        "title"     =>  "Modules",
                        "content"   =>  "update_module",
                        "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Modules")."'>All Modules</a></li>",
                        "view"      =>  $vue
                );    
                if($this->input->post("submit")){
                    $this->form_validation->set_rules("module_name","Module Name","required");
                    if($this->form_validation->run() == TRUE){
                        $ins    = $this->common_model->update_module($uri);
                        if($ins){
                            $this->session->set_flashdata("suc","Updated page successfully");
                        }
                        else{
                            $this->session->set_flashdata("err","Not updated any page successfully");
                        }
                        redirect(sitedata("site_admin")."/Modules");
                    }
                }
                $this->load->view("inner_template",$data);
            }else{
                    $this->session->set_flashdata("war","Page does not exists."); 
                    redirect(sitedata("site_admin")."/Modules");
            }
        }
        public function __destruct() {
                $this->db->close();
        }
}