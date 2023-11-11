<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgets extends CI_Controller {
    	public function __construct() {
            parent::__construct();
            if($this->session->userdata("manage-widgets") != "1"){
                redirect(sitedata("site_admin")."/Dashboard");
            }
        }
        public function index()  {
            $dta = array(
                        "title"     => "Widgets",
                        "content"   => "index",
                        "vtil"      =>  "",
                        "limit"     => 1
            );
            if ($this->input->post("submit")) {
                $this->form_validation->set_rules("widget_display_name", "Widget Display Name", 'required|xss_clean|trim|callback_check_widget_name');
                if ($this->form_validation->run() == TRUE) {
                    $insert_location = $this->widget_model->create_widget();
                    if ($insert_location) {
                        $this->session->set_flashdata("suc", "Widget has been added successfully");
                        redirect(sitedata("site_admin")."/Widgets");
                    } else {
                        $this->session->set_flashdata("err", "Widget has been not added.Please try again.");
                        redirect(sitedata("site_admin")."/Widgets");
                    }
                }
            }
            $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
            $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"id";  
            if(!empty($orderby) && !empty($tipoOrderby)){ 
                $dta['orderby']        =   $orderby;
                $dta['tipoOrderby']    =   $tipoOrderby; 
            } 
            $dta["pageurl"]   =   $pageurl    =   "WIDGETS";
            $dta["urlvalue"]           =   adminurl('viewWidget/');
            $this->load->view("inner_template",$dta); 
        }
        public function viewWidget(){
            $conditions =   array();
            $page       =   $this->uri->segment('3');
            $offset     =   (!$page)?"0":$page;
            $keywords   =   $this->input->post('keywords'); 
            if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
            }  
            $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):$this->config->item("pagination");    
            $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
            $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"id";  
            if($perpage != $this->config->item("all")){
                $totalRec               =   $this->widget_model->cntviewWidget($conditions);
                $config['base_url']     =   adminurl('viewWidget');
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
            $conditions['columns']  =   "widget_display_name,widget_ac_de,widget_id";
            $dta["limit"]           =   $offset+1;
            $dta["pageurl"]   		=   $pageurl    =   "WIDGETS";
            $dta["urlvalue"]        =   adminurl('viewWidget/');
            $dta["view"]    		= 	$view 	=	$this->widget_model->view_widget($conditions);
            $dta["totalrows"]       =   $totalRec-count($view);
            $dta["offset"]          =   $offset;
            $this->load->view("ajax_widgets",$dta);
        }
        public function delete_widget(){
                $vsp    =   "0";
                if($this->session->userdata("delete-widget") != '1'){
                    $vsp    =   "0";
                }else {
                    $uri    =   $this->uri->segment("3");
                    $vue    =   $this->widget_model->get_widget($uri);
                    if(count($vue) > 0){
                        $bt     =   $this->widget_model->delete_widget($uri); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function update_widget(){
                if($this->session->userdata("update-widget") != "1"){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
                $uri    =   $this->uri->segment("3"); 
                $vue    =   $this->widget_model->get_widget($uri);
                if(count($vue) > 0){
                    $dt     =   array(
                            "title"     =>  "Update Widget",
                            "content"   =>  "update_widget",
                             "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Widgets")."'>Widgets</a></li>",
                            "view"      =>  $vue
                    ); 
                    if($this->input->post("submit")){
                        $bt     =   $this->widget_model->update_widget($uri);
                        if($bt > 0){
                            $this->session->set_flashdata("suc","Widget has been updated Successfully.");
                        }else{
                            $this->session->set_flashdata("err","Not Updated any widget.Please try again.");
                        } 
                        redirect(sitedata("site_admin")."/Widgets");
                    }
                    $this->load->view("inner_template",$dt);
                }else{
                    $this->session->set_flashdata("war","Widget does not exists."); 
                    redirect(sitedata("site_admin")."/Widgets");
                }
        }
        public function unique_widget_name(){
                $str    =   $this->input->post("widget_display_name");
                $vsp	=   $this->widget_model->unique_id_name($str); 
                echo ($vsp)?"false":"true";
        }
        public function check_widget_name($str){
                $vsp	=	$this->widget_model->unique_id_name($str); 
                if($vsp){
                        $this->form_validation->set_message("check_widget_name","Widget Name already exists.");
                        return FALSE;
                }	
                return TRUE;
        } 
        public function activedeactive(){
            $vsp    =   "0";
            if($this->session->userdata("active-deactive-widget") != '1'){
                $vsp    =   "0";
            }else{
                $status     =   $this->input->post("status");
                $uri        =   $this->input->post("fields"); 
                $vue    =   $this->widget_model->get_widget($uri);
                if(is_array($vue) && count($vue) > 0){
                    $bt     =   $this->widget_model->activedeactive($uri,$status); 
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