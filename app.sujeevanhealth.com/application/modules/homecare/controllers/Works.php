<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Works extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-how-works") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_works(){
        $data  = array(
            "title"	=>  "Create How It Works",
            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Works")."'>How It Works</a></li>",
            "content"	=>  "create_works",
            "til"       =>  "Create How It Works",
            "vissp"     =>  array()
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("package_item","Item Name","required|callback_works_name");
                $this->form_validation->set_rules("package_id","Package","required");
                if($this->form_validation->run()){
                    $ins    = $this->works_model->create_works();
                    if($ins){
                        $this->session->set_flashdata("suc","Created How It Works Successfully.");
                        redirect(sitedata("site_admin")."/Works");
                    }else{
                        $this->session->set_flashdata("err","Not Created How It Works.Please try again");
                        redirect(sitedata("site_admin")."/Works");
                    }
            }                        
        }
        $data["pkgs"]    =      $this->homecare_model->viewpackage();
        $this->load->view("inner_template",$data);
    }
    public function works_name(){
        $vsp	=	$this->works_model->unique_id_check_works();
        if($vsp){
                $this->form_validation->set_message("works_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "How It Works",
                "vtil"      =>  "",
                "content"   =>  "works"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"itemid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Works";
        $dta["urlvalue"]  =   adminurl("viewWorks/");

        $this->load->view("inner_template",$dta);
    }
    public function viewworks(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Works";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"itemid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->works_model->cntviewworks($conditions);  
            $config['base_url']     =   adminurl('viewWorks');
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
        $dta["urlvalue"]           	=   adminurl('viewWorks/');
        $dta["view"]               	=   $view	=	$this->works_model->viewworks($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewWorks/");
        $this->load->view("ajax_works",$dta);
    }
    public function update_works(){
        if($this->session->userdata("update-how-works") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "item_id = '".$uri."'";
        $view	=	$this->works_model->getworks($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  	= array(
                        "view"      =>	$view,
                        "til"       =>	"Update How It Works",
                        "title"     =>	"Update How It Works",
                        "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Works")."'>How It Works</a></li>",
                        "content"   =>	"create_works",
                        "vissp"     =>  $this->works_model->viewsubworks($conditions)
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("package_item","Item Name","required|callback_works_name");
                $this->form_validation->set_rules("package_id","Package","required");
                if($this->form_validation->run()){
                    $ins    = $this->works_model->update_works($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated How It Works Successfully.");
                        redirect(sitedata("site_admin")."/Works");
                    }else{
                        $this->session->set_flashdata("err","Not Updated How It Works.Please try again");
                        redirect(sitedata("site_admin")."/Works");
                    }
                }                        
            }
            $conditions         =   array();
            $data['module']	=   $this->common_model->viewModules($conditions);
            $data["pkgs"]       =   $this->homecare_model->viewpackage();
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","How It Works does not exists");
            redirect(sitedata("site_admin")."/Works");
        }
    }
    public function  delete_works(){
        $vsp    =   "0";
        if($this->session->userdata("delete-how-works") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $conditions["whereCondition"]   =   "item_id = '".$uri."'";
            $vue    =	$this->works_model->getworks($conditions);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->works_model->delete_works($uri); 
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
        if($this->session->userdata("active-deactive-how-works") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "vendorsubmodule_id = '".$uri."'";
		    $vue    =   $this->works_model->getSub_vendor($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->works_model->activedeactive($uri,$status); 
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