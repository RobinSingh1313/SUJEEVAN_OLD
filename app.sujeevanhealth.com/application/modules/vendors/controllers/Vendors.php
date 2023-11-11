<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vendors extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-vendors") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_Vendors(){
        $data  = array(
                        "title"		=>	"Create Vendor",
                     	"vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Vendors")."'>Vendors</a></li>",
                        "content"	=>	"create_vendor"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("vendor_name","Vendors Name","required|callback_check_vendor_name"); 
                if($this->form_validation->run()){
                    $ins    = $this->vendor_model->create_Vendors();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Vendors Successfully.");
                        redirect(sitedata("site_admin")."/Vendors");
                    }else{
                        $this->session->set_flashdata("err","Not Created Vendors.Please try again");
                        redirect(sitedata("site_admin")."/Vendors");
                    }
            }                        
        }
        $this->load->view("inner_template",$data);
    }
    public function unique_vendor_name(){
        $cpsl   =       $this->vendor_model->unique_id_check_Vendors();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function check_vendor_name(){
        $vsp	=	$this->vendor_model->unique_id_check_Vendors();
        if($vsp){
                $this->form_validation->set_message("check_vendor_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Vendors",
                "vtil"      =>  "",
                "content"   =>  "vendors"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"vendorid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Vendors";
        $dta["urlvalue"]  =   adminurl("viewVendors/");
        $this->load->view("inner_template",$dta);
    }
    public function viewVendors(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Vendors";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"vendorid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->vendor_model->cntviewVendors($conditions);  
            $config['base_url']     =   adminurl('viewVendors');
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
        $dta["urlvalue"]           	=   adminurl('viewVendors/');
        $dta["view"]               	=   $view	=	$this->vendor_model->viewVendors($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewVendors/");
        $this->load->view("ajax_vendors",$dta);
    }
    public function update_vendors(){
        $uri    =   $this->uri->segment('3');
        $conditions["whereCondition"]   =   "vendor_id = '".$uri."'";
        $view	=	$this->vendor_model->getVendors($conditions);
        if(is_array($view) && count($view) > 0){
            $data   = array(
                    "title"         =>	"Update Vendors ",
                    "vtil"          =>  "<li class='breadcrumb-item'><a href='". adminurl("Vendors")."'>Vendors</a></li>",
                    "content"       =>	"create_vendor",
                    "view"          =>  $view
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("vendor_name","Vendors Name ","required");
                if($this->form_validation->run()){
                    $ins    = $this->vendor_model->update_vendor($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Vendors Successfully.");
                        redirect(sitedata("site_admin")."/Vendors");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Vendors.Please try again");
                        redirect(sitedata("site_admin")."/Vendors");
                    }
                }                        
            }
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","No Vendor has been exists.");
            redirect(sitedata("site_admin")."/Vendors");
        }
    }
    public function  delete_vendors(){
        $vsp    =   "0";
        if($this->session->userdata("delete-vendor") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "vendor_id = '".$uri."'";
		    $vue    =   $this->vendor_model->getVendors($params);
            if(count($vue) > 0){
                $bt     =   $this->vendor_model->delete_vendor($uri); 
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
        if($this->session->userdata("active-deactive-vendor") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "vendor_id = '".$uri."'";
		    $vue    =   $this->vendor_model->getVendors($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->vendor_model->activedeactive($uri,$status); 
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