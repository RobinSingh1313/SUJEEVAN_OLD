<?php
class Wellness extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata("manage-wheel-wellness") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
    }
    public function unique_wellness_name(){
        $cpsl   =       $this->wellness_model->unique_id_check_wellness();
        if($cpsl){
            echo "false";exit;
        }
        echo "true";exit;
    }
    public function wellness_name(){
        $vsp	=	$this->wellness_model->unique_id_check_wellness($this->uri->segment("3"));
        if($vsp){
                $this->form_validation->set_message("wellness_name","{field} already exists.");
                return FALSE;
        }
        return TRUE;
    }
    public function index(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Wellness",
                "vtil"      =>  "",
                "til"       =>  "Create Wellness",
                "content"   =>  "wellness"
        );
        if($this->input->post("submit")){
                $this->form_validation->set_rules("wellness_name","Wellness Name","required|callback_wellness_name");
                $this->form_validation->set_rules("wellness_description","Wellness Name","required");
                if($this->form_validation->run()){
                    $ins    = $this->wellness_model->create_wellness();
                    if($ins){
                        $this->session->set_flashdata("suc","Created Wellness Successfully.");
                        redirect(sitedata("site_admin")."/Wellness");
                    }else{
                        $this->session->set_flashdata("err","Not Created Wellness.Please try again");
                        redirect(sitedata("site_admin")."/Wellness");
                    }
            }                        
        }
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"wellnessid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
      	$dta["vslp"]	  =		'1';
        $dta["pageurl"]   =   $pageurl    =   "CareWellness";
        $dta["urlvalue"]  =   adminurl("viewWellness/");
        $this->load->view("inner_template",$dta);
    }
    public function viewWellness(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CareWellness";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"wellnessid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->wellness_model->cntviewWellness($conditions);  
            $config['base_url']     =   adminurl('viewWellness');
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
        $dta["urlvalue"]           	=   adminurl('viewWellness/');
        $dta["view"]               	=   $view	=	$this->wellness_model->viewWellness($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]        =   adminurl("viewWellness/");
        $this->load->view("ajax_wellness",$dta);
    }
    public function update_wellness(){
      	if($this->session->userdata("update-wheel-wellness") != '1'){
            redirect(sitedata("site_admin")."/Dashboard");
        }
        $uri	=	$this->uri->segment('3');
        $conditions["whereCondition"]   =   "wellness_id = '".$uri."'";
        $view	=	$this->wellness_model->getWellness($conditions);
      	if(is_array($view) && count($view) > 0){
            $data  = array(
                            "til"		=>	"Update Wellness",
                            "view"		=>	$view,
                            "title"		=>	"Update Wellness",
                            "vtil"     =>  "<li class='breadcrumb-item'><a href='". adminurl("Wellness")."'>Wellness</a></li>",
                            "content"	=>	"create_wellness"
            );
            if($this->input->post("submit")){
                $this->form_validation->set_rules("wellness_name","Wellness Name","required|callback_wellness_name");
                $this->form_validation->set_rules("wellness_description","Wellness Name","required");
                if($this->form_validation->run()){
                    $ins    = $this->wellness_model->update_wellness($uri);
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Wellness Successfully.");
                        redirect(sitedata("site_admin")."/Wellness");
                    }else{
                        $this->session->set_flashdata("err","Not Updated Wellness.Please try again");
                        redirect(sitedata("site_admin")."/Wellness");
                    }
                }                        
            }
            $this->load->view("inner_template",$data); 
        }else{
            $this->session->set_flashdata("war","Not Updated Wellness.Please try again");
            redirect(sitedata("site_admin")."/Wellness");
        }
    }
    public function  delete_wellness(){
        $vsp    =   "0";
        if($this->session->userdata("delete-wheel-wellness") != '1'){
            $vsp    =   "0";
        }else {
            $uri    =   $this->uri->segment("3");
            $params["whereCondition"]   =   "wellness_id = '".$uri."'";
		    $vue    =   $this->wellness_model->getWellness($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->wellness_model->delete_wellness($uri); 
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
        if($this->session->userdata("active-deactive-wheel-wellness") != '1'){
            $vsp    =   "0";
        }else{
            $status     =   $this->input->post("status");
            $uri        =   $this->input->post("fields");
            $params["whereCondition"]   =   "wellness_id = '".$uri."'";
            $vue    =   $this->wellness_model->getWellness($params);
            if(is_array($vue) && count($vue) > 0){
                $bt     =   $this->wellness_model->activedeactive($uri,$status); 
                if($bt > 0){
                    $vsp    =   1;
                }
            }else{
                $vsp    =   2;
            } 
        } 
        echo $vsp;
    }
    public function wellness_contact(){
        $dta       =   array(
                "limit"     =>  '1',
                "title"     =>  "Wellness",
                "vtil"      =>  "",
                "til"       =>  "Wellness Contact us",
                "content"   =>  "wellness_contact"
        );
        $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"wellnessid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
      	$dta["vslp"]	  =		'1';
        $dta["pageurl"]   =   $pageurl    =   "CareWellness";
        $dta["urlvalue"]  =   adminurl("viewWellnessContact/");
        $this->load->view("inner_template",$dta);
    }
    public function viewWellnessContact(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CareWellness";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta); 
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"wellnessid";
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->wellness_model->cntviewWellnessContact($conditions);  
            $config['base_url']     =   adminurl('viewWellnessContact');
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
        $dta["urlvalue"]           	=   adminurl('viewWellnessContact/');
        $dta["view"]               	=   $view	=	$this->wellness_model->viewWellnessContact($conditions) ;
        $dta["totalrows"]       =   $totalRec-count($view);//print_r($view);exit();
        $dta["offset"]          =   $offset;
        $dta["urlvalue"]        =   adminurl("viewWellnessContact/");
        $this->load->view("ajax_wellness_contact",$dta);
    }
    public function __destruct() {
            $this->db->close();
    }
}