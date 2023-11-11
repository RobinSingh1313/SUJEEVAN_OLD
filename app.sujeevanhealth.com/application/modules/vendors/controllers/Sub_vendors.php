<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sub_vendors extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-sub-vendors") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_sub_vendors(){
        $data  = array(
                        "title"		=>	"Create Sub Vendors ",
                     	"vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Sub-Vendors")."'>Sub Vendors</a></li>",
                        "content"	=>	"create_sub_vendors"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("sub_vendor_name","Sub Vendors Name ","required|callback_sub_vendors_name");
                $this->form_validation->set_rules("vendor","Vendors","required");
                if($this->form_validation->run()){
                    $ins    = $this->sub_vendors_model->create_sub_vendors();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Sub Vendors Successfully.");
                        redirect(sitedata("site_admin")."/Sub-Vendors");
                    }else{
                        $this->session->set_flashdata("err","Not Created Sub Vendors.Please try again");
                        redirect(sitedata("site_admin")."/Sub-Vendors");
                    }
            }                        
        }
        $this->load->view("inner_template",$data);
    }
    public function sub_vendors_name(){
        $vsp	=	$this->sub_vendors_model->unique_id_check_sub_vendors();
        if($vsp){
                $this->form_validation->set_message("sub_vendors_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Sub Vendors",
                "vtil"      =>  "",
                "content"   =>  "sub_vendors"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"vendorsubmoduleid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Sub_vendors";
        $dta["urlvalue"]  =   adminurl("viewSubVendors/");

        $this->load->view("inner_template",$dta);
    }
    public function viewsub_vendors(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Sub_vendors";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"vendorsubmoduleid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->sub_vendors_model->cntviewSub_vendor($conditions);  
            $config['base_url']     =   adminurl('viewSubVendors');
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
        $dta["urlvalue"]           	=   adminurl('viewSubVendors/');
        $dta["view"]               	=   $view	=	$this->sub_vendors_model->viewSub_vendor($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewSubVendors/");
        $this->load->view("ajax_sub_vendors",$dta);
    }
    public function update_sub_vendors(){
        if($this->session->userdata("update-sub-vendor") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "vendorsubmodule_id = '".$uri."'";
        $view	=	$this->sub_vendors_model->getSub_vendor($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  	= array(
                            "view"		=>	$view,
                            "title"		=>	"Update Sub Vendors",
                            "vtil"     =>      "<li class='breadcrumb-item'><a href='". adminurl("Sub-Vendors")."'>Sub Vendors</a></li>",
                            "content"	=>	"create_sub_vendors"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("sub_vendor_name","Sub_vendors Name ","required");
                $this->form_validation->set_rules("vendor","Vendor","required");
                if($this->form_validation->run()){
                    $ins    = $this->sub_vendors_model->update_sub_vendors($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Sub Vendors Successfully.");
                        redirect(sitedata("site_admin")."/Sub-Vendors");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Sub Vendors.Please try again");
                        redirect(sitedata("site_admin")."/Sub-Vendors");
                    }
                }                        
            }
            $conditions     =   array();
            $data['module']	=	$this->common_model->viewModules($conditions);
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Sub Vendors does not exists");
            redirect(sitedata("site_admin")."/Sub-Vendors");
        }
    }
    public function  delete_sub_vendors(){
        $vsp    =   "0";
        if($this->session->userdata("delete-sub-vendor") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "vendorsubmodule_id = '".$uri."'";
		    $vue    =   $this->sub_vendors_model->getSub_vendor($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->sub_vendors_model->delete_sub_vendors($uri); 
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
        if($this->session->userdata("active-deactive-sub-vendor") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "vendorsubmodule_id = '".$uri."'";
		    $vue    =   $this->sub_vendors_model->getSub_vendor($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->sub_vendors_model->activedeactive($uri,$status); 
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