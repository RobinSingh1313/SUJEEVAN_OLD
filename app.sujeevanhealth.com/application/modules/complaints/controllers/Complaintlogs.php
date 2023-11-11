<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Complaintlogs extends CI_Controller{
        public function __construct() {
            parent::__construct();
            if($this->session->userdata("complaints-logs") != '1'){
                redirect(sitedata("site_admin")."/Dashboard"); 
            }
        }
        public function index(){
            $darta  =   array(
                'title'     =>  "Complaint Logs",
                "content"   =>  "complaints-logs",
                "vtil"      =>  "<li class='breadcrumb-item'><a href='".adminurl("Complaint-Management")."'>Complaint Management</a></li>"
            );
            $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
            $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"complaintlogid";  
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
            $darta["urlvalue"]    =   adminurl("viewComplaintlogs/");
            $darta["pageurl"]   =   $pageurl    =   "COMPLAINT";
            $this->load->view("engsnaplayout/inner_template",$darta);
        }
        public function viewComplaintlogs(){
            $conditions =   array();
            $page       =   $this->uri->segment('3');
            $offset     =   (!$page)?"0":$page;
            $dta["pageurl"]   =   $pageurl    =   "COMPLAINT";
            $dta["offset"]    =   $offset;
            $keywords           =   $this->input->post('keywords');
            if(!empty($keywords)){
                $dta['keywords']        = $keywords;
                $conditions['keywords'] = $keywords;
            }  
            $this->session->set_userdata("arr".$pageurl,$dta); 
            $jwcond =   "";
            $activestatus =    $this->input->post("activelist")?$this->input->post("activelist"):"";
            if($activestatus != ""){
                $jwcond     .=  "complaintlog_acde = '".$activestatus."'";
            }
            if($jwcond != ""){
                $conditions['whereCondition'] = $jwcond;
            }
            $totalRec       =    0;
            $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination"); 
            $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
            $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"complaintlogid"; 
            if($perpage != $this->config->item("all")){
                $totalRec               =   $this->complaintlog_model->cntviewComplaintlog($conditions);  
                $config['base_url']     =   adminurl('viewComplaintlogs');
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
            $dta["view"]            =   $view   =   $this->complaintlog_model->viewComplaintlog($conditions); 
            $dta["totalrows"]       =   $totalRec-count($view);
            $dta["offset"]          =   $offset;
            $dta["urlvalue"]        =   adminurl("viewComplaintlogs/");
            $this->load->view("complaints_ajax",$dta);
        }
}
