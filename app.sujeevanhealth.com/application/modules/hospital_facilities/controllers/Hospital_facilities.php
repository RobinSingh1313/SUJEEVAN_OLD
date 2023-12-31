<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Hospital_facilities extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-hospital_facilities") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_hospital_facilitiesnametype(){
        $cpsl   =       $this->hospital_facilities_model->unique_id_check_hospital_facilities();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function hospital_facilitiesnametype(){
        $vsp	=	$this->hospital_facilities_model->unique_id_check_hospital_facilities();
        if($vsp){
                $this->form_validation->set_message("hospital_facilitiesnametype","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Hospital Facilities",
                "vtil"      =>  "",
                "content"   =>  "hospital_facilities"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("hospital_facilitiesnametype","Hospital Facilities Name ","required|callback_hospital_facilitiesnametype");
                if($this->form_validation->run()){
                    $ins    = $this->hospital_facilities_model->create_hospital_facilities();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Hospital Facilities Successfully.");
                        redirect(sitedata("site_admin")."/Hospital-Facilities");
                    }else{
                        $this->session->set_flashdata("err","Not Created Hospital Facilities.Please try again");
                        redirect(sitedata("site_admin")."/Hospital-Facilities");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"hospital_facilitiesid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Hospital_facilities";
        $dta["urlvalue"]  =   adminurl("viewHospital-Facilities/");
        $this->load->view("inner_template",$dta);
    }
    public function viewhospital_facilities(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Hospital_facilities";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"hospital_facilitiesid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->hospital_facilities_model->cntviewHospital_facilities($conditions);  
            $config['base_url']     =   adminurl('viewHospital-Facilities');
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
        $dta["urlvalue"]           	=   adminurl('viewHospital-Facilities/');
        $dta["view"]               	=   $view	=	$this->hospital_facilities_model->viewHospital_facilities($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewHospital-Facilities/");
        $this->load->view("ajax_hospital_facilities",$dta);
    }
    public function update_hospital_facilities(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Hospital Facilities ",
                         "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Hospital-Facilities")."'>Hospital Facilities</a></li>",
                        "content"	=>	"update_hospital_facilities"
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("hospital_facilitiesnametype","Hospital Facilities Name ","required");
            if($this->form_validation->run()){
                $ins    = $this->hospital_facilities_model->update_hospital_facilities($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Hospital Facilities Successfully.");
                    redirect(sitedata("site_admin")."/Hospital-Facilities");
                }else{
                    $this->session->set_flashdata("err","Not Updated Hospital Facilities.Please try again");
                    redirect(sitedata("site_admin")."/Hospital-Facilities");
                }
            }                        
        }
        $conditions     =   array();
        $conditions["whereCondition"]   =   "hospital_facilities_id = '".$uri."'";
        $data['view']	=	$this->hospital_facilities_model->getHospital_facilities($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_hospital_facilities(){
        $vsp    =   "0";
        if($this->session->userdata("delete-hospital_facilities") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "hospital_facilities_id = '".$uri."'";
		    $vue    =   $this->hospital_facilities_model->getHospital_facilities($params);
            if(count($vue) > 0){
                $bt     =   $this->hospital_facilities_model->delete_hospital_facilities($uri); 
                if($bt > 0){
                    $vsp    =   1;
                }
            }else{
                $vsp    =   2;
            } 
        } 
        echo $vsp;
    }
    public function activedeactive(){
        $vsp    =   "0";
        if($this->session->userdata("active-deactive-hospital_facilities") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "hospital_facilities_id = '".$uri."'";
		    $vue    =   $this->hospital_facilities_model->getHospital_facilities($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->hospital_facilities_model->activedeactive($uri,$status); 
                if($bt > 0){
                    $vsp    =   1;
                }
            }else{
                $vsp    =   2;
            } 
        } 
        echo $vsp;
    }
    public function __destruct() {
            $this->db->close();
    }
}