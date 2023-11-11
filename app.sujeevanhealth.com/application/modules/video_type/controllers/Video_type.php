<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Video_type extends CI_Controller{
    public function __construct() {
            parent::__construct();
            if($this->session->userdata("manage-video-type") != '1'){
                redirect(sitedata("site_admin")."/Dashboard");
            }
    }
    public function create_video_type(){
            $data  = array(
                            "title"		=>	"Create Video Type ",
                            "vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Video-Type")."'>Video Type</a></li>",
                            "content"	=>	"create_video_type"
            );
            if($this->input->post("submit")){
                    $this->form_validation->set_rules("video_type_name","Video Type ","required");
                    if($this->form_validation->run()){
                        $ins    = $this->video_type_model->create_video_type();
                        if($ins){
                            $this->session->set_flashdata("suc","Created Video_type Successfully.");
                            redirect(sitedata("site_admin")."/Video-Type");
                        }else{
                            $this->session->set_flashdata("err","Not Created Video_type.Please try again");
                            redirect(sitedata("site_admin")."/Video-Type");
                        }
                }                        
            }
            $this->load->view("inner_template",$data);
    }
    public function index(){
            $dta       =   array(
                    "limit"     =>  '1',
                    "title"     =>  "Video Types",
                    "vtil"      =>  "",
                    "content"   =>  "video_type"
            );
            $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
            $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"video_typeid";  
            $conditions     =   array();
            if(!empty($orderby) && !empty($tipoOrderby)){ 
                $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
            } 
            $keywords   =   $this->input->get('keywords'); 
            if(!empty($keywords)){
                $conditions['keywords'] = $keywords;
            }
            $dta["pageurl"]   =   $pageurl    =   "Video-Type";
            $dta["urlvalue"]  =   adminurl("viewVideoType/");
            $this->load->view("inner_template",$dta);
    }
    public function viewvideo_type(){
            $conditions =   array();
            $page       =   $this->uri->segment('3');
            $offset     =   (!$page)?"0":$page;

            $dta["pageurl"]   =   $pageurl    =   "Video_type";
            $dta["offset"]    =   $offset;
            $keywords       =   $this->input->post('keywords');
            if(!empty($keywords)){
                $dta['keywords']        = $keywords;
                $conditions['keywords'] = $keywords;
            }  
            $this->session->set_userdata("arr".$pageurl,$dta); 
            $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
            $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
            $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"video_typeid";
            if($perpage != $this->config->item("all")){
                $totalRec               =   $this->video_type_model->cntviewVideo_type($conditions);  
                $config['base_url']     =   adminurl('viewVideoType');
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
            $dta["urlvalue"]           	=   adminurl('viewVideoType/');
            $dta["view"]               	=   $view	=	$this->video_type_model->viewVideo_type($conditions) ;
            $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
            $dta["offset"]          =   $offset;
            $dta["urlvalue"]    =   adminurl("viewVideoType/");
            $this->load->view("ajax_video_type",$dta);
    }
    public function update_video_type(){
        $uri    =   $this->uri->segment('3');
        $conditions["whereCondition"]   =   "video_type_id = '".$uri."'";
        $view	=	$this->video_type_model->getVideo_type($conditions);
        if(is_array($view) && count($view) > 0){
        $data   =   array(
            "title"     =>  "Update Video Type",
            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Video-Type")."'>Video Types</a></li>",
            "content"   =>  "update_video_type",
            "view"      =>  $view
        );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("video_type_name","Video_type Title","required");
                if($this->form_validation->run()){
                    $ins    = $this->video_type_model->update_video_type($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Video_type Successfully.");
                        redirect(sitedata("site_admin")."/Video-Type");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Video_type.Please try again");
                        redirect(sitedata("site_admin")."/Video-Type");
                    }
                }                        
            }
            $this->load->view("inner_template",$data);
        }else{
            $this->session->set_flashdata("war","Video Type does not exists");
            redirect(sitedata("site_admin")."/Video-Type");
        }
    }
    public function  delete_video_type(){
        $vsp    =   "0";
        if($this->session->userdata("delete-video-type") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "video_type_id = '".$uri."'";
                        $vue    =   $this->video_type_model->getVideo_type($params);
            if(count($vue) > 0){
                $bt     =   $this->video_type_model->delete_video_type($uri); 
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
        if($this->session->userdata("active-deactive-video-type") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "video_type_id = '".$uri."'";
                        $vue    =   $this->video_type_model->getVideo_type($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->video_type_model->activedeactive($uri,$status); 
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