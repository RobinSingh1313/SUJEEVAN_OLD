<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Telecaller_users extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-telecaller-users") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function viewTelecallerCustomers(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERTelecaller";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $conditions['whereCondition'] ="register_acde ='Active'";
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"registrationid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->registration_model->cntviewRegistration($conditions);  
                    $config['base_url']     =   adminurl('viewTelecallerCustomers');
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
                $dta["urlvalue"]           	=   adminurl('viewTelecallerCustomers/');
                $dta["view"]            =   $view	=	$this->registration_model->viewRegistration($conditions);
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_telecaller_customers",$dta);
        }
        public function indexcustomers(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "All Customers",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regvendorid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERTelecaller";
                $dta["urlvalue"]  =   adminurl("viewTelecallerCustomers/");
                $this->load->view("inner_template",$dta); 
        }
        public function AjaxUserHistory(){
            $dta = array(); 
            $dta['chat'] = $this->db->query("select * from  homecare_chat_response as hs LEFT JOIN sub_module as s ON hs.submodule_id = s.sub_module_id Where registration_id='".$this->input->post('id')."'")->result();
            $dta['purchase'] = $this->db->query("select * from  membership_purchase as mp 
                                                    LEFT JOIN user_package as u ON u.user_package_id = mp.membership_id 
                                                    LEFT JOIN sub_module as s ON u.user_package_sub_module_id = s.sub_module_id  
                                                    Where membership_register_id='".$this->input->post('id')."' and membership_payment_id!=''
                                                    order by mp.membership_taken_on desc")->result();
            $dta['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
            $dta['specialization'] = $this->db->query("select specialization_id,specialization_name from  specialization Where specialization_acde = 'Active' AND specialization_open = '1'")->result();
            $dta['user_package'] = $this->db->query("select user_package_id,user_package_name from  user_package Where registration_id='".$this->input->post('id')."' AND  user_package_acde = 'Active'  AND user_package_open = '1'")->result();
            $dta['moduleid'] = !empty($this->input->post('moduleid'))?$this->input->post('moduleid'):'';
            $dta['history_id'] = !empty($this->input->post('history_id'))?$this->input->post('history_id'):'';
            $this->load->view("ajax_user_history",$dta);
        }
        public function AjaxUpdateResponse(){ 
            $dta = array(); 
            $dta['membership'] = $this->db->query("select * from  membership Where membership_sub_module_id='".$this->input->post('id')."' AND membership_open = '1' AND membership_acde = 'Active'")->result();
            
            $this->load->view("ajax_update_response",$dta);
        }
        public function AjaxDoctorSelect(){ 
            $specc = '';
            if($this->input->post('specialization_id')!=''){
                $specc = "AND  regvendor_specialization='".$this->input->post('specialization_id')."'";
            }
            $dta = array(); 
            $dta['doctor'] = $this->db->query("select rv.regvendor_id,regvendor_name,district_name from  register_vendors as rv LEFT JOIN district as d ON d.district_id = rv.regvendor_city Where regvendor_vendor_id='".$this->input->post('vendor_id')."' ".$specc." AND regvendor_open = '1' AND regvendor_acde = 'Active'")->result();
            $this->load->view("ajax_doctor_select",$dta);
        }
        public function AjaxDoctorAssign(){ 
            $dta = $this->users_model->assign_doctor(); 
            if($dta){
                echo '1';
            }else{
                echo '2';
            }
        }
        public function AjaxUpdateHealthCondition(){
            if($this->input->post('health_condition')!='' || $this->input->post('visit_address')!=''){
                $dta = $this->users_model->update_health_condition(); 
                if($dta){
                    echo '1';
                }else{
                    echo '2';
                }
            }else{
                echo '3';
            }
            
        }
        public function UserPackage(){ 
            $uri=$this->input->get('id');
            $vendors = $this->api_model->vendors();
            $data  = array(
                            "title"		=>	"User Package",
                            "content"	=>	"user_package",
                            "vendors"   => $vendors
            );
            $data['membership'] = $this->db->query("select membership_id,membership_name from  membership Where membership_open = '1' AND membership_acde = 'Active'")->result();
            $data['module'] =$this->db->query("select moduleid,module_name from  modules Where module_acde = 'Active' and module_open = '1'")->result();
            $data['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
            if($this->input->post("submit")){
                // print_r($this->input->post());exit;
                $this->form_validation->set_rules("membership_id","Membership Id ","required");
                $this->form_validation->set_rules("user_packagenametype","Package Name","required");
                $this->form_validation->set_rules("user_package_price","Price","required");
                $this->form_validation->set_rules("user_package_after_disc","After Discount Price","required");
                $this->form_validation->set_rules("user_package_days","Days","required");
                $this->form_validation->set_rules("user_package_about","About","required");
                if($this->form_validation->run()){
                    if($this->input->get('user_id')!=''){
                        $ins    = $this->user_package_model->create_user_package();
                    }else if($uri!=''){
                        $ins    = $this->user_package_model->update_user_package($uri);
                    }
                    
                    if($ins){
                        $this->session->set_flashdata("suc","Updated User Package Successfully.");
                    }else{
                        $this->session->set_flashdata("err","Not Updated User Package.Please try again");
                    }
                }                        
            }
            $conditions     =   array();
            $conditions["whereCondition"]   =   "user_package_id = '".$uri."'";
            $data['view']	=	$this->user_package_model->getUser_package($conditions);
            $this->load->view("inner_template",$data);
        }
        public function AjaxSelectVendorList(){
            $data = $this->api_model->vendors();
            if(is_array($data) && count($data)>0){
                $output = '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                <div class="form-group">
                                    <select class="form-control" name="vendor_selected[]"  required>
                                        <option value="">Select Vendor</option>';
                foreach($data as $d){
                    $id = $d["vendor_id"];
                    $name = $d["vendor_name"];
                    $output .='<option value="'.$id.'">'.$name.'</option>';
                }
                $output .= "</select></div></div>";
                echo $output;
            }
        }
        public function AjaxGetPackageDetails(){
            $data = $this->db->query("select membership_price,membership_after_disc,membership_days,membership_about from  membership Where membership_id = '".$this->input->post('membership_id')."' AND membership_open = '1' AND membership_acde = 'Active'")->row_array();
            echo json_encode($data);
        }
        public function CaseSheet(){ 
            $id=$this->input->get('user_id');
            $view = $this->db->query("select * from  prescription Where registration_id = '".$id."'")->row_array();
            $data  = array(
                            "title"		=>	"Case Sheet",
                            "content"	=>	"case_sheet",
                            "view"      =>  $view
            );
            if($this->input->post("submit")){
                if(is_array($view) && count($view) > 0){
                    $ins    = $this->telecaller_users_model->update_case_sheet($view["prescription_id"]);
                }else {
                    $ins    = $this->telecaller_users_model->create_case_sheet();
                }
                if($ins){
                    $this->session->set_flashdata("suc","Updated User Case Sheet Successfully.");
                }else{
                    $this->session->set_flashdata("err","Not Updated User Case Sheet.Please try again");
                }                   
            }
            $this->load->view("inner_template",$data);
        }
        public function Vitals(){ 
            $id=$this->input->get('user_id');
            $view = $this->db->query("select * from  vital Where registration_id = '".$id."'")->row_array();
            $data  = array(
                            "title"		=>	"Vital",
                            "content"	=>	"vital",
                            "view"      =>  $view
            );
            if($this->input->post("submit")){
                if(is_array($view) && count($view) > 0){
                    $ins    = $this->telecaller_users_model->update_vital($view["vital_id"]);
                }else {
                    $ins    = $this->telecaller_users_model->create_vital();
                }
                if($ins){
                    $this->session->set_flashdata("suc","Updated User Vital Successfully.");
                }else{
                    $this->session->set_flashdata("err","Not Updated User Vital.Please try again");
                }                   
            }
            $this->load->view("inner_template",$data);
        }
        public function membership_purchase(){ 
            $id=$this->input->get('membership_purchase_id');
            $view = $this->db->query("select * from  membership_purchase Where membership_purchase_id = '".$id."'")->row_array();
            $vendors = $this->api_model->vendors();

            if($this->input->post("submit")){
                if(is_array($view) && count($view) > 0){
                    $ins    = $this->telecaller_users_model->update_membership_purchase($id);
                }
                if($ins){
                    $this->session->set_flashdata("suc","Updated User Membership Purchase Successfully.");
                }else{
                    $this->session->set_flashdata("err","Not Updated User Membership Purchase.Please try again");
                }                   
            }
            $view = $this->db->query("select * from  membership_purchase Where membership_purchase_id = '".$id."'")->row_array();
            
            $data  = array(
                            "title"		=>	"Membership Purchase",
                            "content"	=>	"membership_purchase",
                            "view"      =>  $view,
                            "vendors"   =>  $vendors
            );
            $this->load->view("inner_template",$data);
        }
        public function membership_assign(){ 
            $id=$this->input->get('membership_purchase_id');
            if($this->input->post("submit")){
                // echo '<pre>';print_r($this->input->post());exit;
                    $ins    = $this->telecaller_users_model->update_membership_assign($id);
                if($ins){
                    $this->session->set_flashdata("suc","Updated User Membership Assign Successfully.");
                }else{
                    $this->session->set_flashdata("err","Not Updated User Membership Assign.Please try again");
                }                   
            }
            $view = $this->db->query("select ma.*,investigation_id,medication_id,membership_valid_upto,mp.membership_register_id from  membership_assign as ma
            LEFT JOIN medication as m 
            ON m.membership_assign_id = ma.membership_assign_id
            LEFT JOIN investigation as i 
            ON i.membership_assign_id = ma.membership_assign_id
            LEFT JOIN membership_purchase as mp 
            ON mp.membership_purchase_id = ma.membership_purchase_id
            Where ma.membership_purchase_id = '".$id."' AND ma.membership_assign_open='1'
            ")->result();
            $vendors = $this->api_model->vendors();
            $data  = array(
                "title"		=>	"Membership Purchase",
                "content"	=>	"membership_assign",
                "view"      =>  $view,
                "vendors"   =>  $vendors
            );
            $data['specialization'] = $this->db->query("select specialization_id,specialization_name from  specialization Where specialization_acde = 'Active' AND specialization_open = '1'")->result();
            $data['pre_assigned_vendors'] = $this->db->query("select membership_assigns from membership_purchase Where membership_purchase_id = '".$id."'")->row_array();
            $this->load->view("inner_template",$data);
        }
        public function AjaxMembershipAssignFeilds(){ 
            $data['vendors'] = $this->api_model->vendors();
            $data['specialization'] = $this->db->query("select specialization_id,specialization_name from  specialization Where specialization_acde = 'Active' AND specialization_open = '1'")->result();
            $this->load->view("ajax_membership_assign_fields",$data);
        }
        public function customersrequest(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Request",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERRequet";
                $dta["urlvalue"]  =   adminurl("viewCustomersRequest/");
                $this->load->view("inner_template",$dta); 
        }
        public function viewCustomersRequest(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERTelecaller";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                $search = '';
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $search = "Where customer_support_email LIKE '%".$keywords."%' OR customer_support_mobile LIKE  '%".$keywords."%' OR customer_support_status LIKE '%".$keywords."%'";
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"customer_supportid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->db->query("select count(*) as cnt from customer_support_request ".$search."")->row_array();  
                    $totalRec               =   $totalRec['cnt'];
                    $config['base_url']     =   adminurl('viewCustomersRequest');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =  $orderby;
                        $dta['tipoOrderby']    =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewCustomersRequest/');
                $dta["view"]            =   $view	=	$this->db->query("select * from  
                customer_support_request ".
                $search."
                Order By ".$tipoOrderby." ".$orderby."
                Limit ".(int)$offset.",".$perpage."
                ")->result();
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_customer_request",$dta);
        }
        public function AjaxCustomerRequestStatus(){ 
            $dta = $this->telecaller_users_model->customer_request_status(); 
            if($dta){
                echo '1';
            }else{
                echo '2';
            }
        }
        public function AjaxUpdateContactResponse(){
            if($this->input->post('contact_response')!=''){
                $dta = $this->telecaller_users_model->update_contact_response(); 
                if($dta){
                    echo '1';
                }else{
                    echo '2';
                }
            }else{
                echo '3';
            }
            
        }
        public function PreviousReports(){
            $dta  = array(
                            "title"		=>	"Previous Reports",
                            "content"	=>	"previous_reports"
            );
            $id=$this->input->get('user_id');
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   base_url().$target_dir."/previous_reports/";
            $dta['images'] = $this->db->query("select concat('".$direct."',previous_reports_image) as image from  previous_reports Where registration_id='".$id."'")->result();
            // $this->load->view("previous_reports",$dta);
            $this->load->view("inner_template",$dta);
        }
        public function Chatbot(){ 
            $data  = array(
                            "title"		=>	"Chat Bot",
                            "content"	=>	"chatbot"
            );
            $data['module'] =$this->db->query("select moduleid,module_name from  modules Where module_acde = 'Active' and module_open = '1'")->result();
            $data['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
            //$data['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
            if($this->input->post("submit")){
                // print_r($this->input->post());exit;
                    if($this->input->post('homecare_chat_responseid')==''){
                        $ins    = $this->telecaller_users_model->create_homecare_chatbot();
                    }else{
                        $ins    = $this->telecaller_users_model->update_homecare_chatbot($this->input->post('homecare_chat_responseid'));
                    }
                    if($ins){
                        $this->session->set_flashdata("suc","Updated User Chatbot Successfully.");
                    }else{
                        $this->session->set_flashdata("err","Not Updated User Chatbot.Please try again");
                    }                     
            }
            $this->load->view("inner_template",$data);
        }
        public function chatbot_response(){ 
            $data  = array(
                            "title"		=>	"Chat Bot Response",
                            "content"	=>	"chatbot_response"
            );
            $data['module'] =$this->db->query("select moduleid,module_name from  modules Where module_acde = 'Active' and module_open = '1'")->result();
            $data['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
            //$data['sub_module'] = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '7' AND sub_module_open = '1'")->result();
            if($this->input->post("submit")){
                // print_r($this->input->post());exit;
                    if($this->input->post('homecare_chat_responseid')==''){
                        $ins    = $this->telecaller_users_model->create_homecare_chatbot();
                    }else{
                        $ins    = $this->telecaller_users_model->update_homecare_chatbot($this->input->post('homecare_chat_responseid'));
                    }
                    if($ins){
                        $this->session->set_flashdata("suc","Updated User Chatbot Successfully.");
                    }else{
                        $this->session->set_flashdata("err","Not Updated User Chatbot.Please try again");
                    }                     
            }
            $this->load->view("inner_template",$data);
        }
        public function Investigation(){ 
            $data  = array(
                            "title"		=>	"Investigation",
                            "content"	=>	"investigation"
            );
            $assign_id  =   $this->input->get('membership_assign_id');
            if($this->input->post("submit")){
                // print_r($this->input->post());exit;
                if($this->input->post('investigation_id')==''){
                    $ins    = $this->telecaller_users_model->create_investigation();
                }else{
                    $ins    = $this->telecaller_users_model->update_investigation($this->input->post('investigation_id'));
                }
                if($ins){
                    $this->session->set_flashdata("suc","Updated Investigation Successfully.");
                }else{
                    $this->session->set_flashdata("err","Not Updated User Investigation.Please try again");
                }                     
            }
            $data['lab_test_list'] = $this->db->query("select * from  lab_test_list Where lab_test_list_open = '1' AND lab_test_list_acde = 'Active'")->result();
            $data['view'] = $this->db->query("select * from  investigation Where membership_assign_id = '".$assign_id."'")->row_array();
            $this->load->view("inner_template",$data);
        }
        public function Medication(){ 
            $data  = array(
                            "title"		=>	"Medication",
                            "content"	=>	"medication"
            );
            $assign_id  =   $this->input->get('membership_assign_id');
            $data['view'] = $this->db->query("select * from  medication Where membership_assign_id = '".$assign_id."'")->row_array();
            $this->load->view("inner_template",$data);
        }
        
        public function viewPurchasedMemberships(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERTelecaller";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $conditions['whereCondition'] ="register_acde ='Active'";
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"membership_purchase_id";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->telecaller_users_model->cntviewMembership_purchase($conditions);  
                    $config['base_url']     =   adminurl('viewPurchasedMemberships');
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
                $dta["urlvalue"]           	=   adminurl('viewPurchasedMemberships/');
                $dta["view"]            =   $view	=	$this->telecaller_users_model->viewMembership_purchase($conditions);
                // echo $this->db->last_query();exit;
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_purchased_memberships",$dta);
        }
        public function PurchasedMemberships(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "All Customers",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"regvendorid";  
                $conditions     =   array();
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                    $dta['orderby']        =   $conditions["orderby"]       =   $orderby;
                    $dta['tipoOrderby']    =   $conditions["tipoOrderby"]   =   $tipoOrderby; 
                } 
                $keywords   =   $this->input->get('keywords'); 
                if(!empty($keywords)){
                    $conditions['keywords'] = $keywords;
                }
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERTelecaller";
                $dta["urlvalue"]  =   adminurl("viewPurchasedMemberships/");
                $this->load->view("inner_template",$dta); 
        }
        public function vaccinerequest(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Request",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $dta["pageurl"]   =   $pageurl    =   "VACCINERequet";
                $dta["urlvalue"]  =   adminurl("viewVaccineRequest/");
                $this->load->view("inner_template",$dta); 
        }
        public function viewVaccineRequest(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "VACCINERequet";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                $search = '';
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $search = "Where customer_support_email LIKE '%".$keywords."%' OR customer_support_mobile LIKE  '%".$keywords."%' OR customer_support_status LIKE '%".$keywords."%'";
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"vaccine_requestid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->db->query("select count(*) as cnt from vaccine_request ".$search."")->row_array();  
                    $totalRec               =   $totalRec['cnt'];
                    $config['base_url']     =   adminurl('viewVaccineRequest');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =  $orderby;
                        $dta['tipoOrderby']    =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewVaccineRequest/');
                $dta["view"]            =   $view	=	$this->db->query("select * from  
                vaccine_request ".
                $search."
                Order By ".$tipoOrderby." ".$orderby."
                Limit ".(int)$offset.",".$perpage."
                ")->result();
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_vaccine_request",$dta);
        }
        public function AjaxVaccineRequestStatus(){ 
            $dta = $this->telecaller_users_model->vaccine_request_status(); 
            if($dta){
                echo '1';
            }else{
                echo '2';
            }
        }
        
        public function bookappointmentrequest(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Request",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $dta["pageurl"]   =   $pageurl    =   "bookappointmentRequet";
                $dta["urlvalue"]  =   adminurl("viewbookappointmentRequest/");
                $this->load->view("inner_template",$dta); 
        }
        public function viewbookappointmentRequest(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "bookappointmentRequet";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                $search = '';
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $search = "Where customer_support_email LIKE '%".$keywords."%' OR customer_support_mobile LIKE  '%".$keywords."%' OR customer_support_status LIKE '%".$keywords."%'";
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"bookappointment_requestid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->db->query("select count(*) as cnt from bookappointment_request ".$search."")->row_array();  
                    $totalRec               =   $totalRec['cnt'];
                    $config['base_url']     =   adminurl('viewbookappointmentRequest');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =  $orderby;
                        $dta['tipoOrderby']    =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewbookappointmentRequest/');
                $dta["view"]            =   $view	=	$this->db->query("select * from  
                bookappointment_request ".
                $search."
                Order By ".$tipoOrderby." ".$orderby."
                Limit ".(int)$offset.",".$perpage."
                ")->result();
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_bookappointment_request",$dta);
        }
        public function AjaxbookappointmentRequestStatus(){ 
            $dta = $this->telecaller_users_model->bookappointment_request_status(); 
            if($dta){
                echo '1';
            }else{
                echo '2';
            }
        }
        public function customersrecentrequest(){
            $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Request",
                        "vtil"      =>  "",
                        "content"   =>  "viewfile"
                );
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERRecentRequet";
                $dta["urlvalue"]  =   adminurl("viewCustomersRecentRequest/");
                $this->load->view("inner_template",$dta); 
        }
        public function viewCustomersRecentRequest(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "CUSTOMERTelecaller";
                $dta["offset"]    =   $offset;
                $keywords         =   $this->input->post('keywords');
                $search = '';
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $search = "Where r.registration_id LIKE '%".$keywords."%' OR r.register_email LIKE  '%".$keywords."%' OR r.register_mobile LIKE '%".$keywords."%' OR m.module_name LIKE '%".$keywords."%' OR s.sub_module_name LIKE '%".$keywords."%'";
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"homecare_chat_responseid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->db->query("select count(*) as cnt from homecare_chat_response  as hcr
                LEFT JOIN registration as r
                ON r.registration_id = hcr.registration_id 
                LEFT JOIN sub_module as s
                ON s.sub_module_id = hcr.submodule_id 
                LEFT JOIN modules as m
                ON m.moduleid = s.sub_module_module_id ".$search."")->row_array();  
                    $totalRec               =   $totalRec['cnt'];
                    $config['base_url']     =   adminurl('viewCustomersRecentRequest');
                    $config['total_rows']   =   $totalRec;
                    $config['per_page']     =   $perpage; 
                    $config['link_func']    =   'searchFilter';
                    $this->ajax_pagination->initialize($config);
                }
                if(!empty($orderby) && !empty($tipoOrderby)){ 
                        $dta['orderby']        =  $orderby;
                        $dta['tipoOrderby']    =  $tipoOrderby; 
                } 
                $dta["limit"]           	=   (int)$offset+1;
                $dta["urlvalue"]           	=   adminurl('viewCustomersRecentRequest/');
                $dta["view"]            =   $view	=	$this->db->query("select * from  
                homecare_chat_response as hcr
                LEFT JOIN registration as r
                ON r.registration_id = hcr.registration_id 
                LEFT JOIN sub_module as s
                ON s.sub_module_id = hcr.submodule_id 
                LEFT JOIN modules as m
                ON m.moduleid = s.sub_module_module_id ".
                $search."
                Order By ".$tipoOrderby." ".$orderby."
                Limit ".(int)$offset.",".$perpage."
                ")->result();
                $dta["totalrows"]       =   $totalRec-count($view);
                $dta["offset"]          =   $offset;
                $this->load->view("ajax_customer_recent_request",$dta);
        }
        
        public function CaseSheetHistory(){ 
            $id=$this->input->get('user_id');
            $view = $this->db->query("select * from  prescription Where registration_id = '".$id."' order by prescription_cr_on desc")->result_array();
            $data  = array(
                            "title"		=>	"Case Sheet History",
                            "content"	=>	"case_sheet_history",
                            "view"      =>  $view
            );
            $this->load->view("inner_template",$data);
        }
        
        public function VitalsHistory(){ 
            $id=$this->input->get('user_id');
            $view = $this->db->query("select * from vital Where registration_id = '".$id."' order by vital_cr_on desc")->result_array();
            $data  = array(
                            "title"		=>	"Vitals History",
                            "content"	=>	"vitals_history",
                            "view"      =>  $view
            );
            $this->load->view("inner_template",$data);
        }
        
        public function PreviousReportsHistory(){
            $dta  = array(
                            "title"		=>	"Previous Reports History",
                            "content"	=>	"previous_reports_history"
            );
            $id=$this->input->get('user_id');
            $target_dir     =   $this->config->item("upload_dest");
            $direct         =   base_url().$target_dir."previous_reports/";
            $dta['images'] = $this->db->query("select previous_reports_image as file_name, concat('".$direct."',previous_reports_image) as image,
                                                previous_reports_cr_on from  previous_reports Where registration_id='".$id."' 
                                                order by previous_reports_cr_on desc")->result_array();
            $this->load->view("inner_template",$dta);
        }
        
        public function check_doctor_timeslot(){
            $sel_doctor_id=$this->input->post('sel_doctor_id');
            $sel_date_val=$this->input->post('sel_date_val');
            $formatted_date = date("Y-m-d",strtotime($sel_date_val));
            $time_slot= $this->db->query("select * from  book_appointment_time_slot")->row_array();
            switch ($time_slot['book_appointment_time_type']) {
              case "0":
                $slot = $time_slot['book_appointment_time']." seconds";
                break;
              case "1":
                $slot = $time_slot['book_appointment_time']." minutes";
                break;
              case "2":
                $slot = $time_slot['book_appointment_time']." hours";
                break;
              case "3":
                $slot = $time_slot['book_appointment_time']." days";
                break;
              default:
            }
            $booked_slots = array();
            $get_doctorpre_slots = $this->db->query("SELECT time_from, time_to FROM membership_assign where membership_assign_vendor='$sel_doctor_id' 
                                        and membership_assign_status='Assigned' and membership_assign_date_from='".$formatted_date."'")->result_array();
            foreach($get_doctorpre_slots as $get_doctorpre_sl){
                $booked_slots[] = date('h:iA',strtotime($get_doctorpre_sl['time_from'])).' - '.date('h:iA',strtotime($get_doctorpre_sl['time_to']));
            }
            $interval = DateInterval::createFromDateString($slot);
            $now = new DateTime(date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"))+60*60));
            $begin = new DateTime(date("Y-m-d").'T00:00:00');
            $end = new DateTime(date("Y-m-d").'T23:59:00');
            // DatePeriod won't include the final period by default, so increment the end-time by our interval
            $end->add($interval);
            // Convert into array to make it easier to work with two elements at the same time
            $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));
            $start = array_shift($periods);
            $times = array();$i=0;
            $ddl_str = '<option value="">Select Time Slot</option>';
            foreach ($periods as $time) {
                $time_slot_value = $start->format('h:iA').' - '.$time->format('h:iA');
                if(!in_array($time_slot_value,$booked_slots)){
                    if(date("Y-m-d") == date("Y-m-d",strtotime($sel_date_val))){ 
                        $times[$i] =array();
                        if($now->format("H:i:s") <=  $start->format('H:i:s') ){
                            $ddl_str .= '<option value="'.$time_slot_value.'">'.$time_slot_value.'</option>';
                        }
                    }else{
                        $ddl_str .= '<option value="'.$time_slot_value.'">'.$time_slot_value.'</option>';
                    }
                    $start = $time;
                }
            }
            echo $ddl_str;
        }

        public function __destruct() {
                $this->db->close();
        }
}