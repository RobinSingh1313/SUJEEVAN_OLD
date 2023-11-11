<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Hospital_specialities extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-hospital_specialities") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_hospital_specialitiesnametype(){
        $cpsl   =       $this->hospital_specialities_model->unique_id_check_hospital_specialities();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function hospital_specialitiesnametype(){
        $vsp	=	$this->hospital_specialities_model->unique_id_check_hospital_specialities();
        if($vsp){
                $this->form_validation->set_message("hospital_specialitiesnametype","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Hospital Specialities",
                "vtil"      =>  "",
                "content"   =>  "hospital_specialities"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("hospital_specialitiesnametype","Hospital Specialities Name ","required|callback_hospital_specialitiesnametype");
                if($this->form_validation->run()){
                    $ins    = $this->hospital_specialities_model->create_hospital_specialities();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Hospital Specialities Successfully.");
                        redirect(sitedata("site_admin")."/Hospital-Specialities");
                    }else{
                        $this->session->set_flashdata("err","Not Created Hospital Specialities.Please try again");
                        redirect(sitedata("site_admin")."/Hospital-Specialities");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"hospital_specialitiesid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Hospital_specialities";
        $dta["urlvalue"]  =   adminurl("viewHospital-Specialities/");
        $this->load->view("inner_template",$dta);
    }
    public function viewhospital_specialities(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Hospital_specialities";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"hospital_specialitiesid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->hospital_specialities_model->cntviewHospital_specialities($conditions);  
            $config['base_url']     =   adminurl('viewHospital-Specialities');
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
        $dta["urlvalue"]           	=   adminurl('viewHospital-Specialities/');
        $dta["view"]               	=   $view	=	$this->hospital_specialities_model->viewHospital_specialities($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewHospital-Specialities/");
        $this->load->view("ajax_hospital_specialities",$dta);
    }
    public function update_hospital_specialities(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Hospital Specialities ",
                         "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Hospital-Specialities")."'>Hospital Specialities</a></li>",
                        "content"	=>	"update_hospital_specialities"
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("hospital_specialitiesnametype","Hospital Specialities Name ","required");
            if($this->form_validation->run()){
                $ins    = $this->hospital_specialities_model->update_hospital_specialities($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Hospital Specialities Successfully.");
                    redirect(sitedata("site_admin")."/Hospital-Specialities");
                }else{
                    $this->session->set_flashdata("err","Not Updated Hospital Specialities.Please try again");
                    redirect(sitedata("site_admin")."/Hospital-Specialities");
                }
            }                        
        }
        $conditions     =   array();
        $conditions["whereCondition"]   =   "hospital_specialities_id = '".$uri."'";
        $data['view']	=	$this->hospital_specialities_model->getHospital_specialities($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_hospital_specialities(){
        $vsp    =   "0";
        if($this->session->userdata("delete-hospital_specialities") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "hospital_specialities_id = '".$uri."'";
		    $vue    =   $this->hospital_specialities_model->getHospital_specialities($params);
            if(count($vue) > 0){
                $bt     =   $this->hospital_specialities_model->delete_hospital_specialities($uri); 
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
        if($this->session->userdata("active-deactive-hospital_specialities") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "hospital_specialities_id = '".$uri."'";
		    $vue    =   $this->hospital_specialities_model->getHospital_specialities($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->hospital_specialities_model->activedeactive($uri,$status); 
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