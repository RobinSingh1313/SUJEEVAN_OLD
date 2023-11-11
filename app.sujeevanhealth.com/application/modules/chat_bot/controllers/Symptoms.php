<?php
class Symptoms extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->userdata("manage-symptoms-chat-bot") != "1"){
            redirect(sitedata("site_admin")."/Dashboard"); 
        }
    }
    public function index(){
        $darta  =   array(
            'title'     =>  "Symptoms Chat Bot",
            "content"   =>  "box_configuration",
            "til"       =>  "Auto Box",
            "vtil"      =>  ""
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("botauto_question","Question","required");
            $this->form_validation->set_rules("module","Module","required");
            $this->form_validation->set_rules("healthcategory","Health Category","required");
            $this->form_validation->set_rules("healthcategorysub","Health Sub Category","required");
            if($this->form_validation->run() == TRUE){
                $insk   =   $this->symptoms_model->create_symptoms();
                if($insk){
                    $this->session->set_flashdata("suc","Symptoms Chat Bot successfully");
                    redirect(sitedata("site_admin")."/Symptoms-Chat-Bot"); 
                }else{
                    $this->session->set_flashdata("err","Symptoms Chat Bot has been not done.Please try again");
                    redirect(sitedata("site_admin")."/Symptoms-Chat-Bot"); 
                }
            }
        }
        $orderby        =   $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =   $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"symptomsid";  
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
            $this->common_model->exceldownload("Symptoms Chat Bot",$conditions);
        }
        $darta['module']	=	$this->common_model->viewModules($conditions);
        $darta["pageurl"]   =   $pageurl    =   "SYMPTONSCOT"; 
        $darta["rview"]       =   "0";
        $darta["urlvalue"]    =   adminurl("viewSymptomsbot/");
        $this->load->view("inner_template",$darta);
    }
    public function viewSymptomsbot(){
        $conditions =   array();
        $page       =   $this->uri->segment('3');
        $offset     =   (!$page)?"0":$page;
        
        $dta["pageurl"]   =   $pageurl    =   "SYMPTONSCOT";
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
        $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"symptomsid"; 
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->symptoms_model->cntviewSymptomsbot($conditions);  
            $config['base_url']     =   adminurl('viewSymptomsbot');
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
        $dta["view"]            =   $view   =   $this->symptoms_model->viewSymptomsbot($conditions); 
        $dta["urlvalue"]        =   adminurl("viewSymptomsbot/");
        $dta["totalrows"]       =   $totalRec-count($view);
        $dta["offset"]          =   $offset;
        $this->load->view("botconfig_ajax",$dta);
    }
    public function activedeactive(){
            $vsp    =   "0";
            if($this->session->userdata("active-deactive-symptoms-chat-bot") != '1'){
                $vsp    =   "0";
            }else{
                $status     =   $this->input->post("status");
                $uri        =   $this->input->post("fields"); 
                $parsm["whereCondition"]    =   "symptoms_id = '".$uri."'";
                $vue    =   $this->symptoms_model->getSymptomsbot($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->symptoms_model->activedeactive($uri,$status); 
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
            if($this->session->userdata("delete-symptoms-chat-bot") != '1'){
                $vsp    =   "0";
            }else{
                $uri    =   $this->uri->segment("3");
                $parsm["whereCondition"]    =   "symptoms_id = '".$uri."'";
                $vue    =   $this->symptoms_model->getSymptomsbot($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->symptoms_model->delete_botauto($uri); 
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
            if($this->session->userdata("update-symptoms-chat-bot") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
            }
            $uri    =   $this->uri->segment("3"); 
            $parsm["whereCondition"]    =   "symptoms_id = '".$uri."'";
            $vue    =   $this->symptoms_model->getSymptomsbot($parsm);
            if(is_array($vue) && count($vue) > 0){
                    $dt     =   array(
                            "title"     =>  "Update Symptoms Chat Bot",
                            "content"   =>  "botconfig_update",
                            "icon"      =>  "mdi mdi-account",
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Symptoms-Chat-Bot")."'>Symptoms Chat Bot</a></li>",
                            "view"      =>  $vue
                    ); 
                    if($this->input->post("submit")){
                        $this->form_validation->set_rules("botauto_question","Question","required");
                        $this->form_validation->set_rules("module","Module","required");
                        $this->form_validation->set_rules("healthcategory","Health Category","required");
                        $this->form_validation->set_rules("healthcategorysub","Health Sub Category","required");
                        if($this->form_validation->run() == TRUE){
                            $bt     =   $this->symptoms_model->update_symptoms($uri);
                            if($bt > 0){
                                $this->session->set_flashdata("suc","Updated Symptoms Chat Bot Successfully.");
                                redirect(sitedata("site_admin")."/Symptoms-Chat-Bot");
                            }else{
                                $this->session->set_flashdata("err","Not Updated Symptoms Chat Bot.Please try again.");
                                redirect(sitedata("site_admin")."/Symptoms-Chat-Bot");
                            }
                        }
                    }
                    $dt['module']	=	$this->common_model->viewModules();
                    $this->load->view("inner_template",$dt);
            }else{
                    $this->session->set_flashdata("war","Chat room box does not exists."); 
                    redirect(sitedata("site_admin")."/Symptoms-Chat-Bot");
            }
    }
    public function __destruct() {
            $this->db->close();
    }
}