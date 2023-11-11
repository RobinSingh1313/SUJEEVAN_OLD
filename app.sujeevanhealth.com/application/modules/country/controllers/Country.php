<?php

class Country extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-countries") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function index(){ 
                $dta    =   array( 
                                    "title"     =>  "Countries",
                                    "content"   =>  "country",
                                    "vtil"      =>  "",
                                    "limit"     =>  "1"
                            ); 
                if($this->input->post("submit")){
                    $this->form_validation->set_rules("country_name","Country Name","required|xss_clean|trim|min_length[3]|max_length[50]|callback_check_country_name");
                    $this->form_validation->set_rules("country_currency","Currency","required|xss_clean|trim|min_length[3]|max_length[50]");
                    $this->form_validation->set_rules("country_code","Code","required|xss_clean|trim|min_length[3]|max_length[50]");
                    $this->form_validation->set_rules("country_employee_prefix","Employee Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                    $this->form_validation->set_rules("country_trip_prefix","Trip Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                    $this->form_validation->set_rules("country_piligrim_prefix","Piligrim Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                    $this->form_validation->set_rules("country_piligrimrelative_prefix","Relative Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                    $this->form_validation->set_rules("country_timezone","Country Name","required|xss_clean|trim|min_length[3]|max_length[50]");
                    if($this->form_validation->run() == TRUE){
                        $bt     =   $this->country_model->create_country();
                        if($bt > 0){
                            $this->session->set_flashdata("suc","Created a Country Successfully.");
                        }else{
                            $this->session->set_flashdata("err","Not Created a Country.Please try again.");
                        }
                        redirect(sitedata("site_admin")."/Countries");
                    }
                }  
                $dta["pageurl"]     =   "country";
                $dta["urlvalue"]    =   adminurl("viewCountry/");
                $this->load->view("inner_template",$dta); 
        }
        public function unique_country_name(){
            $str    =   ($this->input->post("countryname") != "")?$this->input->post("countryname"):$this->input->post("country_name");
            $vspl   =   $this->country_model->check_unique_country($str,$this->input->post("countryid"));
            echo ($vspl)?"false":"true";
        }
        public function check_country_name($str){ 
                $vsp	=	$this->country_model->check_unique_country($str,$this->uri->segment("3")); 
                if($vsp){
                    $this->form_validation->set_message("check_country_name","Country Name already exists.");
                    return FALSE;
                }	
                return TRUE; 
        }
        public function delete_country(){
                $vsp    =   "0";
                if($this->session->userdata("delete-country") != '1'){
                    $vsp    =   "0";
                }else {
                    $uri    =   $this->uri->segment("3");
                    $pms["whereCondition"]    =   "country_id = '".$uri."'";
                    $vue    =   $this->country_model->get_country($pms);
                    if(count($vue) > 0){
                        $bt     =   $this->country_model->delete_country($uri); 
                        if($bt > 0){
                            $vsp    =   1;
                        }
                    }else{
                        $vsp    =   2;
                    } 
                } 
                echo $vsp;
        }
        public function update_country(){
                if($this->session->userdata("update-country") != '1'){
                        redirect(sitedata("site_admin")."/Dashboard");
                }
                $uri    =   $this->uri->segment("3"); 
                $psm["whereCondition"]	=	"country_id lIKE '$uri'";
                $vue    =   $this->country_model->get_country($psm);
                if(count($vue) > 0){
                        $dt     =   array(
                                "title"     =>  "Update Country",
                                "content"   =>  "update_country",
                                "vtil"      =>  "<li class='breadcrumb-item'><a href='". adminurl("Countries")."'>Countries</a></li>",
                                "view"      =>  $vue
                        ); 
                        if($this->input->post("submit")){
                           $this->form_validation->set_rules("countryname","Country Name","required|xss_clean|trim|min_length[3]|max_length[50]|callback_check_country_name");
                            $this->form_validation->set_rules("country_currency","Currency","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("country_code","Code","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("country_employee_prefix","Employee Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("country_trip_prefix","Trip Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("country_piligrim_prefix","Piligrim Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("country_piligrimrelative_prefix","Relative Prefix","required|xss_clean|trim|min_length[3]|max_length[50]");
                            $this->form_validation->set_rules("country_timezone","Country Name","required|xss_clean|trim|min_length[3]|max_length[50]");
                            if($this->form_validation->run() == TRUE){
                                $bt     =   $this->country_model->update_country($uri);
                                if($bt > 0){
                                    $this->session->set_flashdata("suc","Updated Country Successfully.");
                                }else{
                                    $this->session->set_flashdata("err","Not Updated Country.Please try again.");
                                }
                                redirect(sitedata("site_admin")."/Countries");
                            }
                        }
                        $this->load->view("inner_template",$dt);
                }else{
                        $this->session->set_flashdata("war","Country does not exists."); 
                        redirect(sitedata("site_admin")."/Countries");
                }
        }
        public function viewCountry(){ 
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                $dta["pageurl"]     =   $pageurl    =   "country";
                $dat["offset"]      =   $offset;
                $keywords       =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dat['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dat);
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");    
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->post('tipoOrderby')?str_replace("+"," ",$this->input->post('tipoOrderby')):"countryid"; 
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->country_model->cntview_country($conditions);  
                    $config['base_url']     =   adminurl('viewCountry');
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
                $dta["view"]            =   $view   =   $this->country_model->view_country($conditions); 
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $dta["countrypage"]     =   "countrypage";
                $dta["urlvalue"]        =   adminurl("viewCountry/");
                $this->load->view("ajax_country",$dta);
        }
        public function activedeactive(){
                $vsp    =   "0";
                if($this->session->userdata("active-deactive-country") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields"); 
                    $psm["whereCondition"]	=	"country_id lIKE '$uri'";
                    $vue    =   $this->country_model->get_country($psm);
                    if(count($vue) > 0){
                            $bt     =   $this->country_model->activedeactive($uri,$status); 
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