<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Membership extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-membership") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_membershipnametype(){
        $cpsl   =       $this->membership_model->unique_id_check_membership();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function membershipnametype(){
        $vsp	=	$this->membership_model->unique_id_check_membership();
        if($vsp){
                $this->form_validation->set_message("membershipnametype","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Membership",
                "vtil"      =>  "",
                "content"   =>  "membership"
        ); 
        $dta['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
        if($this->input->post("submit")){
                $this->form_validation->set_rules("membershipnametype","Membership Name ","required|callback_membershipnametype");
            $this->form_validation->set_rules("homecare_category","Homecare Category ","required");
                if($this->form_validation->run()){
                    $ins    = $this->membership_model->create_membership();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Membership Successfully.");
                        redirect(sitedata("site_admin")."/Membership");
                    }else{
                        $this->session->set_flashdata("err","Not Created Membership.Please try again");
                        redirect(sitedata("site_admin")."/Membership");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"membershipid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        $dta["pageurl"]   =   $pageurl    =   "Membership";
        $dta["urlvalue"]  =   adminurl("viewMembership/");
        $this->load->view("inner_template",$dta);
    }
    public function viewmembership(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "Membership";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"membershipid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->membership_model->cntviewMembership($conditions);  
            $config['base_url']     =   adminurl('viewMembership');
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
        $dta["urlvalue"]           	=   adminurl('viewMembership/');
        $dta["view"]               	=   $view	=	$this->membership_model->viewMembership($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]    =   adminurl("viewMembership/");
        $this->load->view("ajax_membership",$dta);
    }
    public function update_membership(){
        $uri=$this->uri->segment('3');
        $data  = array(
                        "title"		=>	"Update Membership ",
                         "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Membership")."'>Membership</a></li>",
                        "content"	=>	"update_membership"
        );
        $data['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
        if($this->input->post("submit")){
            $this->form_validation->set_rules("membershipnametype","Membership Name ","required");
            $this->form_validation->set_rules("homecare_category","Homecare Category ","required");
            if($this->form_validation->run()){
                $ins    = $this->membership_model->update_membership($uri);
                if($ins){
                    $this->session->set_flashdata("suc","Updated Membership Successfully.");
                    redirect(sitedata("site_admin")."/Membership");
                }else{
                    $this->session->set_flashdata("err","Not Updated Membership.Please try again");
                    redirect(sitedata("site_admin")."/Membership");
                }
            }                        
        }
        $conditions     =   array();
        $conditions["whereCondition"]   =   "membership_id = '".$uri."'";
        $data['view']	=	$this->membership_model->getMembership($conditions);
        $this->load->view("inner_template",$data);
    }
    public function  delete_membership(){
        $vsp    =   "0";
        if($this->session->userdata("delete-membership") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "membership_id = '".$uri."'";
		    $vue    =   $this->membership_model->getMembership($params);
            if(count($vue) > 0){
                $bt     =   $this->membership_model->delete_membership($uri); 
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
        if($this->session->userdata("active-deactive-membership") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "membership_id = '".$uri."'";
		    $vue    =   $this->membership_model->getMembership($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->membership_model->activedeactive($uri,$status); 
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