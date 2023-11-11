<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Package_details extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-package-details") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function create_package_details(){
        $data  = array(
                        "title"		=>	"Create Package Details ",
                     	"vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Package-Details")."'>Package Details</a></li>",
                        "content"	=>	"create_package_details"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("package_id","Package Name ","required");
                $this->form_validation->set_rules("package_price","Package Price ","required");
                $this->form_validation->set_rules("package_discount","Package Discount ","required");
                $this->form_validation->set_rules("package_from","Package Valid From ","required");
                $this->form_validation->set_rules("package_to","Package Valid To ","required");
                if($this->form_validation->run()){
                    $ins    = $this->package_details_model->create_package_details();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Package Details Successfully.");
                        redirect(sitedata("site_admin")."/Package-Details");
                    }else{
                        $this->session->set_flashdata("err","Not Created Package Details.Please try again");
                        redirect(sitedata("site_admin")."/Package-Details");
                    }
            }                        
        }
        $conditions     =   array();
        $data['package']	=	$this->package_model->viewPackage($conditions);
        $this->load->view("inner_template",$data);
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Package Details",
                "vtil"      =>  "",
                "content"   =>  "package_details"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"package_detailsid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Package-Details";
        $dta["urlvalue"]  =   adminurl("viewPackageDetails/");
        $this->load->view("inner_template",$dta);
    }
    public function viewpackage_details(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Package-Details";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"package_detailsid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->package_details_model->cntviewPackage_details($conditions);  
            $config['base_url']     =   adminurl('viewPackageDetails');
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
        $dta["urlvalue"]           	=   adminurl('viewPackageDetails/');
        $dta["view"]               	=   $view	=	$this->package_details_model->viewPackage_details($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewPackageDetails/");
        $this->load->view("ajax_package_details",$dta);
    }
    public function update_package_details(){
        if($this->session->userdata("update-package-details") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri    =   $this->uri->segment('3');
        $params["whereCondition"]   =   "package_details_id = '".$uri."'";
	    $view    =   $this->package_details_model->getPackage_details($params);
        if(is_array($view) && count($view) > 0){
            $data  = array(
                            "title"		=>	"Update Package Details",
                             "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Package")."'>Package</a></li>",
                            "content"	=>	"update_package_details.php",
                            "view"      =>  $view
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("package_id","Package Name ","required");
                $this->form_validation->set_rules("package_price","Package Price ","required");
                $this->form_validation->set_rules("package_discount","Package Discount ","required");
                $this->form_validation->set_rules("package_from","Package Valid From ","required");
                $this->form_validation->set_rules("package_to","Package Valid To ","required");
                if($this->form_validation->run()){
                    $ins    = $this->package_details_model->update_package_details($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Package Details Successfully.");
                        redirect(sitedata("site_admin")."/Package-Details");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Package Details.Please try again");
                        redirect(sitedata("site_admin")."/Package-Details");
                    }
                }                        
            }
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","No Package details exists.Please try again");
            redirect(sitedata("site_admin")."/Package-Details");
        }
    }
    public function  delete_package_details(){
        $vsp    =   "0";
        if($this->session->userdata("delete-package-details") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "package_details_id = '".$uri."'";
		    $vue    =   $this->package_details_model->getPackage_details($params);
            if(count($vue) > 0){
                $bt     =   $this->package_details_model->delete_package_details($uri); 
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
        if($this->session->userdata("active-deactive-package-details") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "package_details_id = '".$uri."'";
		    $vue    =   $this->package_details_model->getPackage_details($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->package_details_model->activedeactive($uri,$status); 
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