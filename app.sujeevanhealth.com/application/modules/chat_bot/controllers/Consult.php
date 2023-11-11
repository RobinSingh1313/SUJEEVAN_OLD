<?php
class Consult extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->userdata("manage-consult-chat-bot") != "1"){
            redirect(sitedata("site_admin")."/Dashboard"); 
        }
    }
    public function index(){
        $darta  =   array(
            'title'     =>  "Consult Chat Bot",
            "content"   =>  "consult",
            "til"       =>  "Auto Box",
            "vtil"      =>  ""
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("botauto_question","Question","required");
            $this->form_validation->set_rules("module","Module","required");
            // $this->form_validation->set_rules("healthcategory","Health Category","required");
            // $this->form_validation->set_rules("healthcategorysub","Health Sub Category","required");
            if($this->form_validation->run() == TRUE){
                $insk   =   $this->consult_model->create_consult();
                if($insk){
                    $this->session->set_flashdata("suc","Consult Chat Bot successfully");
                    redirect(sitedata("site_admin")."/Consult-Chat-Bot"); 
                }else{
                    $this->session->set_flashdata("err","Consult Chat Bot has been not done.Please try again");
                    redirect(sitedata("site_admin")."/Consult-Chat-Bot"); 
                }
            }
        }
        $orderby        =   $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =   $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"Consultid";  
        $conditions     =   array();
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
            $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
        } 
        $keywords   =   $this->input->get('keywords'); 
        if(!empty($keywords)){
            $conditions['keywords'] = $keywords;
        }
        if($this->input->get("search")){
            $this->common_model->exceldownload("Consult Chat Bot",$conditions);
        }
        $darta['module']	=	$this->common_model->viewModules($conditions);
        $darta["pageurl"]   =   $pageurl    =   "CONSUTONSCOT"; 
        $darta["rview"]       =   "0";
        $darta["urlvalue"]    =   adminurl("viewConsultbot/");
        $this->load->view("inner_template",$darta);
    }
    public function viewConsultbot(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "CONSUTONSCOT";
        $dta["offset"]    =   $offset;
        $keywords       =   $this->input->post('keywords');
        if(!empty($keywords)){
            $dta['keywords']        = $keywords;
            $conditions['keywords'] = $keywords;
        }  
        $this->session->set_userdata("arr".$pageurl,$dta);
        $totalRec       =    0;
        $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination"); 
        $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
        $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"Consultid"; 
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->consult_model->cntviewConsultbot($conditions);  
            $config['base_url']     =   adminurl('viewConsultbot');
            $config['total_rows']   =   $totalRec;
            $config['per_page']     =   $perpage; 
            $config['link_func']    =   'searchFilter';
            $this->ajax_pagination->initialize($config);
            $conditions['start']    =   $offset;  
            $conditions['limit']    =   $perpage;
        }
        if(!empty($orderby) && !empty($tipoOrderby)){ 
            $dta['orderby']        =   $conditions['order_by']      =   $orderby;
            $dta['tipoOrderby']    =   $conditions['tipoOrderby']   =   $tipoOrderby; 
        } 
        $dta["limit"]           =   (int)$offset+1;
        $dta["view"]            =   $view   =   $this->consult_model->viewConsultbot($conditions);
        $dta["urlvalue"]        =   adminurl("viewConsultbot/");
        $dta["totalrows"]       =   $totalRec-count($view);
        $dta["offset"]          =   $offset;
        $this->load->view("consult_ajax",$dta);
    }
    public function activedeactive(){
            $vsp    =   "0";
            if($this->session->userdata("active-deactive-consult-chat-bot") != '1'){
                $vsp    =   "0";
            }else{
                $status     =   $this->input->post("status");
                $uri        =   $this->input->post("fields"); 
                $parsm["whereCondition"]    =   "consult_id = '".$uri."'";
                $vue    =   $this->consult_model->getConsultbot($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->consult_model->activedeactive($uri,$status); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                }else{
                    $vsp    =   2;
                } 
            } 
            echo $vsp;
    }
    public function deletebot(){
            $vsp    =   "0";
            if($this->session->userdata("delete-consult-chat-bot") != '1'){
                $vsp    =   "0";
            }else{
                $uri    =   $this->uri->segment("3");
                $parsm["whereCondition"]    =   "consult_id = '".$uri."'";
                $vue    =   $this->consult_model->getConsultbot($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->consult_model->delete_botauto($uri); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                }else{
                    $vsp    =   2;
                } 
            } 
            echo $vsp;
    }
    public function updatebot(){
            if($this->session->userdata("update-consult-chat-bot") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
            }
            $uri    =   $this->uri->segment("3"); 
            $parsm["whereCondition"]    =   "consult_id = '".$uri."'";
            $vue    =   $this->consult_model->getConsultbot($parsm);
            if(is_array($vue) && count($vue) > 0){
                    $dt     =   array(
                            "title"     =>  "Update Consult Chat Bot",
                            "content"   =>  "consult_update",
                            "icon"      =>  "mdi mdi-account",
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Consult-Chat-Bot")."'>Consult Chat Bot</a></li>",
                            "view"      =>  $vue
                    ); 
                    if($this->input->post("submit")){
                        $this->form_validation->set_rules("botauto_question","Question","required");
                        $this->form_validation->set_rules("module","Module","required");
                        $this->form_validation->set_rules("healthcategory","Health Category","required");
                        $this->form_validation->set_rules("healthcategorysub","Health Sub Category","required");
                        if($this->form_validation->run() == TRUE){
                            $bt     =   $this->consult_model->update_consult($uri);
                            if($bt > 0){
                                $this->session->set_flashdata("suc","Updated Consult Chat Bot Successfully.");
                                redirect(sitedata("site_admin")."/Consult-Chat-Bot");
                            }else{
                                $this->session->set_flashdata("err","Not Updated Consult Chat Bot.Please try again.");
                                redirect(sitedata("site_admin")."/Consult-Chat-Bot");
                            }
                        }
                    }
                    $dt['module']	=	$this->common_model->viewModules();
                    $this->load->view("inner_template",$dt);
            }else{
                    $this->session->set_flashdata("war","Chat room box does not exists."); 
                    redirect(sitedata("site_admin")."/Consult-Chat-Bot");
            }
    }
    public function __destruct() {
            $this->db->close();
    }
}