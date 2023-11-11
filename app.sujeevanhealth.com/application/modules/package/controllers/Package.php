<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Package extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-package") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_packagenametype(){
        $cpsl   =       $this->package_model->unique_id_check_package();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function packagenametype(){
        $vsp	=	$this->package_model->unique_id_check_package();
        if($vsp){
                $this->form_validation->set_message("packagenametype","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Package",
                "vtil"      =>  "",
                "content"   =>  "package"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("packagenametype","Package Name ","required|callback_packagenametype");
                if($this->form_validation->run()){
                    $ins    = $this->package_model->create_package();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Package Successfully.");
                        redirect(sitedata("site_admin")."/Package");
                    }else{
                        $this->session->set_flashdata("err","Not Created Package.Please try again");
                        redirect(sitedata("site_admin")."/Package");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"packageid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Package";
        $dta["urlvalue"]  =   adminurl("viewPackage/");
        $this->load->view("inner_template",$dta);
    }
    public function viewpackage(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Package";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"packageid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->package_model->cntviewPackage($conditions);  
            $config['base_url']     =   adminurl('viewPackage');
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
        $dta["urlvalue"]           	=   adminurl('viewPackage/');
        $dta["view"]               	=   $view	=	$this->package_model->viewPackage($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewPackage/");
        $this->load->view("ajax_package",$dta);
    }
    public function update_package(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Package ",
                         "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Package")."'>Package</a></li>",
                        "content"	=>	"update_package"
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("packagenametype","Package Name ","required");
            if($this->form_validation->run()){
                $ins    = $this->package_model->update_package($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Package Successfully.");
                    redirect(sitedata("site_admin")."/Package");
                }else{
                    $this->session->set_flashdata("err","Not Updated Package.Please try again");
                    redirect(sitedata("site_admin")."/Package");
                }
            }                        
        }
        $conditions     =   array();
        $conditions["whereCondition"]   =   "package_id = '".$uri."'";
        $data['view']	=	$this->package_model->getPackage($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_package(){
        $vsp    =   "0";
        if($this->session->userdata("delete-package") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "package_id = '".$uri."'";
		    $vue    =   $this->package_model->getPackage($params);
            if(count($vue) > 0){
                $bt     =   $this->package_model->delete_package($uri); 
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
        if($this->session->userdata("active-deactive-package") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "package_id = '".$uri."'";
		    $vue    =   $this->package_model->getPackage($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->package_model->activedeactive($uri,$status); 
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