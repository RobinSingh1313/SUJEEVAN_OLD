<?php

class Questions extends CI_Controller{
        public function __construct() {
                parent::__construct();
                if($this->session->userdata("manage-question-answers") != '1'){
                    redirect(sitedata("site_admin")."/Dashboard");
                }
        }
        public function create_qa(){
                $data  = array(
                                "title"		=>	"Create Question Answer" ,
                             	"vtil"          =>      "<li class='breadcrumb-item'><a href='". adminurl("Question-Answers")."'> Question Answer</a></li>",
                                "content"	=>	"create_qa"
                );
                if($this->input->post("submit")){
                        $this->form_validation->set_rules("qa_question","question ","required");
                        $this->form_validation->set_rules("qa_answer","answer","required");
                        $this->form_validation->set_rules("module","module","required");
                        $this->form_validation->set_rules("health_category","health category","required");
                        $this->form_validation->set_rules("health_sub_category","health sub category","required");
                        $this->form_validation->set_rules("regvendor_id","Name","required");
                        if($this->form_validation->run()){
                            $ins    = $this->questions_model->create_qa();
                            if($ins){
                                $this->session->set_flashdata("suc","Created Question Answer Successfully.");
                                redirect(sitedata("site_admin")."/Question-Answers");
                            }else{
                                $this->session->set_flashdata("err","Not Created Question Answer.Please try again");
                                redirect(sitedata("site_admin")."/Question-Answers");
                            }
                    }                        
                }
                $conditions["columns"]     =   "moduleid,module_name";
                $data["module"]              =   $this->common_model->viewModules($conditions);
                $data['HealthCategory']  =   $this->common_model->healthCategoryList();
                $data['HealthSubCategory']  =   $this->common_model->healthSubCategoryList();
                $vendorconditions["columns"]     =   "regvendor_id,regvendor_name";
                $data['RegVendor']  =   $this->vendor_registration_model->viewRegistration($vendorconditions);
                $this->load->view("inner_template",$data);
        }
        public function index(){
                $dta       =   array(
                        "limit"     =>  '1',
                        "title"     =>  "Question Answer",
                        "vtil"      =>  "",
                        "content"   =>  "qa"
                );
                $orderby        =    $this->input->get('orderby')?$this->input->get('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"qaid";  
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
                $dta["urlvalue"]  =   adminurl("viewQa/");
                $this->load->view("inner_template",$dta);
        }
        public function viewqa(){
                $conditions =   array();
                $page       =   $this->uri->segment('3');
                $offset     =   (!$page)?"0":$page;
                
                $dta["pageurl"]   =   $pageurl    =   "Qa";
                $dta["offset"]    =   $offset;
                $keywords       =   $this->input->post('keywords');
                if(!empty($keywords)){
                    $dta['keywords']        = $keywords;
                    $conditions['keywords'] = $keywords;
                }  
                $this->session->set_userdata("arr".$pageurl,$dta); 
                $perpage        =    $this->input->post("limitvalue")?$this->input->post("limitvalue"):sitedata("site_pagination");
                $orderby        =    $this->input->post('orderby')?$this->input->post('orderby'):"DESC";
                $tipoOrderby    =    $this->input->get('tipoOrderby')?str_replace("+"," ",$this->input->get('tipoOrderby')):"qaid";
                if($perpage != $this->config->item("all")){
                    $totalRec               =   $this->questions_model->cntviewQa($conditions);  
                    $config['base_url']     =   adminurl('viewQA');
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
                $dta["urlvalue"]           	=   adminurl('viewQa/');
                $dta["view"]               	=   $view	=	$this->questions_model->viewQa($conditions) ;
                $dta["totalrows"]       =   $totalRec-count($view);
                //print_r($dta["view"]);exit();
                $dta["offset"]          =   $offset;
                $dta["urlvalue"]    =   adminurl("viewQa/");
                $this->load->view("ajax_qa",$dta);
        }
        public function update_qa(){
              $uri=$this->uri->segment('3');
              $conditions["whereCondition"]   =   "qa_id = '".$uri."'";
              $view	=	$this->questions_model->getQa($conditions);
              //print_r($view);exit;
          	if(is_array($view) && count($view) > 0){
                $data  = array(
                    "view"	=>	$view,
                    "title"		=>	"Update Question Answer ",
                    "vtil"       =>      "<li class='breadcrumb-item'><a href='". adminurl("Question-Answers")."'> Question Answer</a></li>",
                  "content"		=>	"update_qa"
                );
                if($this->input->post("submit")){
                    $this->form_validation->set_rules("qa_question","question ","required");
                    $this->form_validation->set_rules("qa_answer","answer","required");
                    $this->form_validation->set_rules("module","module","required");
                    $this->form_validation->set_rules("health_category","health category","required");
                    $this->form_validation->set_rules("sub_health_category","health sub category","required");
                    $this->form_validation->set_rules("regvendor_id","Name","required");
                        if($this->form_validation->run()){
                            $ins    = $this->questions_model->update_qa($uri);
                            if($ins){
                                $this->session->set_flashdata("suc","Updated Question Answer Successfully.");
                                redirect(sitedata("site_admin")."/Question-Answers");
                            }else{
                                $this->session->set_flashdata("err","Not Updated Question Answer.Please try again");
                                redirect(sitedata("site_admin")."/Question-Answers");
                            }
                    }                        
                }
          		$conditions1["columns"]     =   "moduleid,module_name";
                $regconditions["columns"]     =   "regvendor_id,regvendor_name";
                $conditions2["columns"]     =   "healthcategory_id,healthcategory_name";
                $conditions3["columns"]     =   "healthsubcategory_id,healthsubcategory_name";
                $data["module"]              =   $this->common_model->viewModules($conditions1);
                $data["RegVendor"]              =   $this->vendor_registration_model->viewRegistration($regconditions);
                $data["HealthCategory"]              =   $this->health_category_model->viewCategory($conditions2);
                $data["HealthSubCategory"]              =   $this->health_category_model->viewsubCategory($conditions3);
                $ans_conditions["colums"] = "answerid,ans_answer";
                $ans_conditions["whereCondition"] = "ans_question_id='".$uri."' and ans_regvendor_id='".$view['qa_modified_by']."'";
                $answer = $this->questions_model->getAnswer($ans_conditions);
                if($answer)
                {
                $data['answer'] = $answer['ans_answer'];
                $data['answerid'] = $answer['answerid'];
                }
                else
                {
                  $data['answer'] = "";
                  $data['answerid'] = "";  
                }

            	$this->load->view("inner_template",$data);
            }else{
                $this->session->set_flashdata("war","Question Answer does  not exists");
                redirect(sitedata("site_admin")."/Question-Answers");
            }
    	}
        public function  delete_qa(){
                $vsp    =   "0";
                if($this->session->userdata("delete-question-answer") != '1'){
                    $vsp    =   "0";
                }else {
                    $uri    =   $this->uri->segment("3");
                    $params["whereCondition"]   =   "qa_id = '".$uri."'";
			        $vue    =   $this->questions_model->getQa($params);
                    if(count($vue) > 0){
                        $bt     =   $this->questions_model->delete_qa($uri); 
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
                if($this->session->userdata("active-deactive-question-answer") != '1'){
                    $vsp    =   "0";
                }else{
                    $status     =   $this->input->post("status");
                    $uri        =   $this->input->post("fields");
                    $params["whereCondition"]   =   "qa_id = '".$uri."'";
			        $vue    =   $this->questions_model->getQa($params);
                    if(is_array($vue) && count($vue) > 0){
                        $bt     =   $this->questions_model->activedeactive($uri,$status); 
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