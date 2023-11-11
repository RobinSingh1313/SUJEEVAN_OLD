<?php

class Users extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-users") != '1'){
                        redirect("Sujeevan-Admin/Dashboard");
               }
        }
        public function index(){ 
                $dta    =   array( 
                                    "title"     =>  "Users",
                                    "content"   =>  "user",
                                    "icon"      =>  "random",
                                    "limit"     =>  "1"
                            );
                
                if($this->input->post("submit")){
                        $this->form_validation->set_rules("user_name","User Name","required|xss_clean|trim|min_length[3]|max_length[50]|callback_check_user_name");
                        $this->form_validation->set_rules("email","Email","required|callback_check_email");
                        $this->form_validation->set_rules("password","Password","required");
                        $this->form_validation->set_rules("role","Role","required");
                        if($this->form_validation->run() == TRUE){
                                $bt     =   $this->users_model->create_user();
                                if($bt > 0){
                                        $this->session->set_flashdata("suc","Created a User Successfully.");
                                        redirect("Sujeevan-Admin/users");
                                }else{
                                        $this->session->set_flashdata("err","Not Created a User.Please try again.");
                                        redirect("Sujeevan-Admin/users");
                                }
                        }
                }
                $dta['role']    = $this->role_model->view_role();
                $dta["pageurl"]   =   $pageurl    =   "users";
                $dta['urlvalue']    = base_url('Sujeevan-Admin/viewUser/');
                $dta["view"]           =    $this->users_model->view_user();
                $this->load->view("inner_template",$dta); 
        }

        public function unique_user_name(){
                echo $this->users_model->unique_user($this->input->post("user_name"));
        }
        public function check_user_name($str){ 
                $vsp	=	$this->users_model->check_unique_user($str); 
                if($vsp){
                        $this->form_validation->set_message("check_user_name","User Name already exists.");
                        return FALSE;
                }	
                return TRUE; 
        }
        public function check_email($str){ 
                $vsp	=	$this->users_model->check_email($str); 
                if($vsp){
                        $this->form_validation->set_message("check_email","Email already exists.");
                        return FALSE;
                }	
                return TRUE; 
        }
        public function activedeactive(){
            $vsp    =   "0";
            if($this->session->userdata("active-deactive-users") != '1'){
                $vsp    =   "0";
            }else{
                $status     =   $this->input->post("status");
                $uri        =   $this->input->post("fields");
                $vue        =   $this->users_model->get_user($uri);
                if(is_array($vue) && count($vue) > 0){
                    $bt     =   $this->users_model->activedeactive($uri,$status); 
                    if($bt > 0){
                        $vsp    =  '1';
                    }
                }else{
                    $vsp    =   '2';
                } 
            } 
            echo $vsp;
        }
        public function delete_user(){
                if($this->session->userdata("delete-users") != '1'){
                        redirect("/Sujeevan-Admin");
                }
                $uri    =   $this->uri->segment("3");
                $vue    =   $this->users_model->get_user($uri);
                if(count($vue) > 0){
                        $bt     =   $this->users_model->delete_user($uri); 
                        if($bt > 0){
                                $this->session->set_flashdata("suc","Deleted User Successfully.");
                                redirect("/Sujeevan-Admin/users");
                        }else{
                                $this->session->set_flashdata("err","Not Deleted User.Please try again.");
                                redirect("/Sujeevan-Admin/users");
                        }
                }else{
                        $this->session->set_flashdata("war","User does not exists."); 
                        redirect("/Sujeevan-Admin/users");
                }
        }
        public function update_user(){
//                
                $uri    =   $this->uri->segment("3"); 
                $vue    =   $this->users_model->get_user($uri);
                
                $role   = $this->role_model->view_role();
                if(count($vue) > 0){
                        $dt     =   array(
                                "title"     =>  "Update User",
                                "content"   =>  "up_user",
                                "view"      =>  $vue,
                                "role"      => $role
                        ); 
                        if($this->input->post("submit")){
                                $this->form_validation->set_rules("user_name","User Name","required");
                                $this->form_validation->set_rules("email","Email","required");
                                $this->form_validation->set_rules("password","Password","required");
                                $this->form_validation->set_rules("role","Role","required");
                                if($this->form_validation->run() == TRUE){
                                        $bt     =   $this->users_model->update_user($uri);
                                        if($bt > 0){
                                                $this->session->set_flashdata("suc","Updated User Successfully.");
                                                redirect("/Sujeevan-Admin/users/");
                                        }else{
                                                $this->session->set_flashdata("err","Not Updated User.Please try again.");
                                                redirect("/Sujeevan-Admin/users/");    
                                        }
                                }
                        }
                        $this->load->view("inner_template",$dt);
                }else{
                        $this->session->set_flashdata("war","User does not exists."); 
                        redirect("/Sujeevan-Admin/users");
                }
        }
        public function viewUser(){ 
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
                $totalRec               =   $this->users_model->cntview_user($conditions);  
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =   $conditions['order_by']   =   $orderby;
                        $dta['tipoOrderby']    =   $conditions['tipoOrderby']   =  $tipoOrderby; 
                } 
                $config['base_url']     =   base_url('Sujeevan-Admin/viewUser');
                $config['total_rows']   =   $totalRec;
                $config['per_page']     =   $perpage; 
                $config['link_func']    =   'searchFilter';
                $this->ajax_pagination->initialize($config);
                $conditions['start']    =   $offset;
                $conditions['limit']    =   $perpage;
                $dta["limit"]           =   $offset+1;
                $dta["view"]            =   $this->users_model->view_user($conditions);
                $this->load->view("ajax_user",$dta);
        }
}