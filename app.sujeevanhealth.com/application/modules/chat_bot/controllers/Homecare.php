<?php
class Homecare extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->userdata("manage-homecare-chat-bot") != "1"){
            redirect(sitedata("site_admin")."/Dashboard"); 
        }
    }
    public function index(){
            
        $darta  =   array(
            'title'     =>  "Homecare Chat Bot",
            "content"   =>  "homecare/box_configuration",
            "til"       =>  "Auto Box",
            "vtil"      =>  "",
            "module"    =>  $this->db->query("select moduleid,module_name from  modules Where module_acde = 'Active' and module_open = '1'")->result()
        );
        if($this->input->post("submit")){
            $this->form_validation->set_rules("botauto_question","Question","required");
            $this->form_validation->set_rules("submodule","Sub Module","required");
            $this->form_validation->set_rules("order","Order","required");
            if($this->form_validation->run() == TRUE){
                $insk   =   $this->homecare_chat_model->create_homecare();
                if($insk){
                    $this->session->set_flashdata("suc","Homecare Chat Bot successfully");
                    redirect(sitedata("site_admin")."/Homecare-Chat-Bot"); 
                }else{
                    $this->session->set_flashdata("err","Homecare Chat Bot has been not done.Please try again");
                    redirect(sitedata("site_admin")."/Homecare-Chat-Bot"); 
                }
            }
        }
        $orderby        =   $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
        $tipoOrderby    =   $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"homecare_chatid";  
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
            $this->common_model->exceldownload("Homecare Chat Bot",$conditions);
        }
        $darta["pageurl"]   =   $pageurl    =   "SYMPTONSCOT"; 
        $darta["rview"]       =   "0";
        $darta["urlvalue"]    =   adminurl("viewHomecarebot/");
        $this->load->view("inner_template",$darta);
    }
    public function viewHomecarebot(){
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
        $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"homecare_chatid"; 
        if($perpage != $this->config->item("all")){
            $totalRec               =   $this->homecare_chat_model->cntviewHomecarebot($conditions);  
            $config['base_url']     =   adminurl('viewHomecarebot');
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
        $dta["view"]            =   $view   =   $this->homecare_chat_model->viewHomecarebot($conditions); 
        $dta["urlvalue"]        =   adminurl("viewHomecarebot/");
        $dta["totalrows"]       =   $totalRec-count($view);
        $dta["offset"]          =   $offset;
        $this->load->view("homecare/botconfig_ajax",$dta);
    }
    public function activedeactive(){
            $vsp    =   "0";
            if($this->session->userdata("active-deactive-homecare-chat-bot") != '1'){
                $vsp    =   "0";
            }else{
                $status     =   $this->input->post("status");
                $uri        =   $this->input->post("fields"); 
                $parsm["whereCondition"]    =   "homecare_chat_id = '".$uri."'";
                $vue    =   $this->homecare_chat_model->getHomecarebot($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->homecare_chat_model->activedeactive($uri,$status); 
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
            if($this->session->userdata("delete-homecare-chat-bot") != '1'){
                $vsp    =   "0";
            }else{
                $uri    =   $this->uri->segment("3");
                $parsm["whereCondition"]    =   "homecare_chat_id = '".$uri."'";
                $vue    =   $this->homecare_chat_model->getHomecarebot($parsm);
                if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->homecare_chat_model->delete_botauto($uri); 
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
            if($this->session->userdata("update-homecare-chat-bot") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
            }
            $uri    =   $this->uri->segment("3"); 
            $parsm["whereCondition"]    =   "homecare_chat_id = '".$uri."'";
            $vue    =   $this->homecare_chat_model->getHomecarebot($parsm);
            if(is_array($vue) && count($vue) > 0){
                    $dt     =   array(
                            "title"     =>  "Update Homecare Chat Bot",
                            "content"   =>  "homecare/botconfig_update",
                            "icon"      =>  "mdi mdi-account",
                            "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Homecare-Chat-Bot")."'>Homecare Chat Bot</a></li>",
                            "view"      =>  $vue,
                            "module"    =>  $this->db->query("select moduleid,module_name from  modules Where module_acde = 'Active' and module_open = '1'")->result()
                    ); 
                    if($this->input->post("submit")){
                        $this->form_validation->set_rules("botauto_question","Question","required");
                        $this->form_validation->set_rules("submodule","Sub Module","required");
                        $this->form_validation->set_rules("order","Order","required");
                        if($this->form_validation->run() == TRUE){
                            $bt     =   $this->homecare_chat_model->update_homecare($uri);
                            if($bt > 0){
                                $this->session->set_flashdata("suc","Updated Homecare Chat Bot Successfully.");
                                redirect(sitedata("site_admin")."/Homecare-Chat-Bot");
                            }else{
                                $this->session->set_flashdata("err","Not Updated Homecare Chat Bot.Please try again.");
                                redirect(sitedata("site_admin")."/Homecare-Chat-Bot");
                            }
                        }
                    }
                    $this->load->view("inner_template",$dt);
            }else{
                    $this->session->set_flashdata("war","Chat room box does not exists."); 
                    redirect(sitedata("site_admin")."/Homecare-Chat-Bot");
            }
    }
    public function __destruct() {
            $this->db->close();
    }
}