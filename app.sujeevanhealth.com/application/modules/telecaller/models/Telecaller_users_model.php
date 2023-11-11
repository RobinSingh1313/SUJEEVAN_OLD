
<?php
class Telecaller_users_model extends CI_Model{
    public function create_case_sheet(){
        $data = array(
                "prescription_cheif_complaints"         =>  ($this->input->post("prescription_cheif_complaints"))??'',
                "prescription_past_history"             =>  ($this->input->post("prescription_past_history"))??'',
                "prescription_social_history"           =>  ($this->input->post("prescription_social_history"))??'',
                "prescription_family_history"           =>  ($this->input->post("prescription_family_history"))??'',
                "prescription_drug_allergies"           =>  ($this->input->post("prescription_drug_allergies"))??'',
                "prescription_provisional_diagnosis"    =>  ($this->input->post("prescription_provisional_diagnosis"))??'',
                "prescription_final_diagnosis"          =>  ($this->input->post("prescription_final_diagnosis"))??'',
                "registration_id"                       =>  ($this->input->post("registration_id"))??'',
                "prescription_cr_on"                    =>  date("Y-m-d h:i:s"),
                "prescription_cr_by"                    =>  $this->session->userdata("login_id")
        );
        $this->db->insert("prescription",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp > 0){
            $dat    =   array(
                            "prescription_id    "=> $vsp."PRES"
                        );	
                $this->db->update("prescription",$dat,"prescriptionid='".$vsp."'");
                $title = 'Case sheet';
                $message = 'your Case sheeet updated successfully';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
                return true;   
        }
        return false;
    }
    public function update_case_sheet($str){
        $data = array(
                "prescription_cheif_complaints"         =>  ($this->input->post("prescription_cheif_complaints"))??'',
                "prescription_past_history"             =>  ($this->input->post("prescription_past_history"))??'',
                "prescription_social_history"           =>  ($this->input->post("prescription_social_history"))??'',
                "prescription_family_history"           =>  ($this->input->post("prescription_family_history"))??'',
                "prescription_drug_allergies"           =>  ($this->input->post("prescription_drug_allergies"))??'',
                "prescription_provisional_diagnosis"    =>  ($this->input->post("prescription_provisional_diagnosis"))??'',
                "prescription_final_diagnosis"          =>  ($this->input->post("prescription_final_diagnosis"))??'',
                "registration_id"                       =>  ($this->input->post("registration_id"))??'',
                "prescription_md_on"                    =>  date("Y-m-d h:i:s"),
                "prescription_md_by"                    =>  $this->session->userdata("login_id")
        );
        $this->db->update("prescription",$data,"prescription_id='".$str."'");
        $vsp   =    $this->db->affected_rows();
        if($vsp > 0){
            $title = 'Case sheet';
            $message = 'Your case sheeet updated successfully';
            $id = $this->input->post("registration_id");
            $push_type = 'Customer';
            $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            return true;
        }
        return FALSE;
    }
    public function create_vital(){
        $data = array(
            "vital_weight"              =>  ($this->input->post("vital_weight"))??'',
            "vital_temperature"         =>  ($this->input->post("vital_temperature"))??'',
            "vital_pulse_rate"          =>  ($this->input->post("vital_pulse_rate"))??'',
            "vital_respiratory_rate"    =>  ($this->input->post("vital_respiratory_rate"))??'',
            "vital_spo2"                =>  ($this->input->post("vital_spo2"))??'',
            "vital_bp"                  =>  ($this->input->post("vital_bp"))??'',
            "vital_cvs"                 =>  ($this->input->post("vital_cvs"))??'',
            "vital_cns"                 =>  ($this->input->post("vital_cns"))??'',
            "registration_id"           =>  ($this->input->post("registration_id"))??'',
            "vital_cr_on"               =>  date("Y-m-d h:i:s"),
            "vital_cr_by"               =>  $this->session->userdata("login_id")
        );
        $this->db->insert("vital",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp > 0){
            $dat    =   array(
                            "vital_id    "=> $vsp."PRES"
                        );	
                $this->db->update("vital",$dat,"vitalid='".$vsp."'");
                $title = 'Vital';
                $message = 'Your vital details updated successfully';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
                return true;   
        }
    }
    public function update_vital($str){
        $data = array(
            "vital_weight"              =>  ($this->input->post("vital_weight"))??'',
            "vital_temperature"         =>  ($this->input->post("vital_temperature"))??'',
            "vital_pulse_rate"          =>  ($this->input->post("vital_pulse_rate"))??'',
            "vital_respiratory_rate"    =>  ($this->input->post("vital_respiratory_rate"))??'',
            "vital_spo2"                =>  ($this->input->post("vital_spo2"))??'',
            "vital_bp"                  =>  ($this->input->post("vital_bp"))??'',
            "vital_cvs"                 =>  ($this->input->post("vital_cvs"))??'',
            "vital_cns"                 =>  ($this->input->post("vital_cns"))??'',
            "registration_id"           =>  ($this->input->post("registration_id"))??'',
            "vital_md_on"               =>  date("Y-m-d h:i:s"),
            "vital_md_by"               =>  $this->session->userdata("login_id")
        );
        $this->db->update("vital",$data,"vital_id='".$str."'");
        $vsp   =    $this->db->affected_rows();
        if($vsp > 0){
                $title = 'Vital';
                $message = 'Your vital details updated successfully';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            return true;
        }
        return FALSE;
    }
    public function update_membership_purchase($str){
        if(is_array($this->input->post('vendor_selected')) && count($this->input->post('vendor_selected'))>0 ){
            $amounts = $this->input->post('vendor_amount');
            $days = $this->input->post('vendor_days');
            $arr = array();$i=0;
            foreach($this->input->post('vendor_selected') as $ven_sel){
                $arry = array(
                    "vendor_id" => $ven_sel,
                    "days"      =>  $days[$i],
                    "amount"    =>  $amounts[$i]
                    );
                    array_push($arr,$arry);
                    $i++;
            }
        }
        if($this->input->post("membership_valid_upto")!=''){
            $data["membership_valid_upto"] = ($this->input->post("membership_valid_upto"))??'';
        }
        $data["membership_assigns"] = json_encode($arr);
        $this->db->update("membership_purchase",$data,"membership_purchase_id='".$str."'");
        $vsp   =    $this->db->affected_rows();
        if($vsp > 0){
                $title = 'Home Care Package';
                $message = 'Your Homecare Package is updated';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            return true;
        }
        return FALSE;
    }
    
     public function update_membership_assign($str){
        if(is_array($this->input->post('vendor_selected')) && count($this->input->post('vendor_selected'))>0 ){
            $date                   = $this->input->post('vendor_date');
            $specialization_id      = $this->input->post('specialization_id');
            $vendor                 = $this->input->post('vendor');
            $time_slot              = $this->input->post('time_slot');
            $assign_id              = ($this->input->post('assign_id'))??array();
            $otp                    = ($this->input->post('otp'))??array();
            $vendor_amount          = $this->input->post('vendor_amount');
            $arr = array();
            
            // delete previous available data 
            // $this->db->delete('membership_assign', array('membership_purchase_id' => $str));
            $this->db->update("membership_assign","membership_assign_open ='0'","membership_assign_date_from >= '".date("Y-m-d")."' AND membership_purchase_id = '".$str."'");
            // $this->db->query("DELETE FROM membership_assign where membership_assign_date_from >= '".date("Y-m-d")."' AND membership_purchase_id = '".$str."'");
            
            foreach($this->input->post('vendor_selected') as $i=>$ven_sel){
                if (array_key_exists($i,$otp)){
                    $rand_otp = $otp[$i];
                }else{
                    $rand_otp = rand(1000,9999);
                }
                // time slots
                if(!empty($time_slot[$i])){
                    $time_slots = explode(' - ',$time_slot[$i]);
                    $start_time = ($time_slots[0])?date('H:i:s',strtotime($time_slots[0])):'';
                    $end_time = ($time_slots[1])?date('H:i:s',strtotime($time_slots[1])):'';
                }
                
                
                $data= array(
                    "membership_assign_specialization"      =>  $specialization_id[$i],
                    "membership_assign_vendor"              =>  $vendor[$i],
                    "membership_assign_date_from"           =>  $date[$i],
                    "time_from"                             =>  ($start_time)??'',
                    "time_to"                               =>  ($end_time)??'',
                    "membership_assign_vendor_type"         =>  $ven_sel,
                    "membership_assign_otp"                 =>  $rand_otp,
                    "membership_assign_status"              =>  ($ven_sel=='5VT')?"Visited":"Assigned",
                    "membership_purchase_id"                =>  $str,
                    "membership_assign_open"                =>  1
                );
                
                if(array_key_exists($i,$assign_id) && !empty($assign_id[$i])){
                    $data['membership_assign_md_on']=date("Y-m-d h:i:s");
                    $data['membership_assign_md_by']=$this->session->userdata("login_id");
                    $this->db->update("membership_assign",$data,"membership_assign_id = '".$assign_id[$i]."'");
            
                }else{
                        $arr['topic']='Appointment meet by sujeevann';
                        date_default_timezone_set("Asia/Kolkata");
                        $arr['start_date']=date("Y-m-d H:i:s",strtotime($date[$i]." ".$start_time) - 60*60*8);
                        $arr['duration']=60;
                        $arr['password']='sujeevan';
                        $arr['type']='2';
                        $result=$this->zoom_meet->createMeeting($arr);
                        if(isset($result->id)){
                        	$data['zoom_url']=$result->join_url;
                        	$data['zoom_meet_id']=$result->id;
                        }else{
                        // 	echo '<pre>';
                        // 	print_r($result);
                        // 	echo '</pre>';
                        }
                    $data['membership_assign_cr_on']=date("Y-m-d h:i:s");
                    $data['membership_assign_cr_by']=$this->session->userdata("login_id");
                    $this->db->insert("membership_assign",$data);
                    $vsp   =    $this->db->insert_id();
                    if($vsp > 0){
                        $dat    =   array(
                                    "membership_assign_id    "=> $vsp."MEMASS"
                                );	
                        $this->db->update("membership_assign",$dat,"membership_assignid='".$vsp."'");
                    }
                }
                $start_time ='';
                $end_time       = '';
                
            }
        }
        $get_module_details = $this->db->query("SELECT module_name FROM membership_purchase mp 
                                                inner join user_package up on up.user_package_id=mp.membership_id 
                                                inner join modules md on md.moduleid=up.user_package_module_id 
                                                where mp.membership_purchase_id='".$str."'")->row();
        $module_name = isset($get_module_details)?$get_module_details->module_name:'Home Care Package';
        $title = 'Purchased Package -'.$module_name;
        $message = 'Your '.$module_name.' assign updated successfully';
        $id = $this->input->post("registration_id");
        $push_type = 'Customer';
        $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
        return true;
    }
    public function customer_request_status(){
        $ft     =   array(  
                    "customer_support_status"        =>    $this->input->post('status'),
                    "customer_support_md_on" =>    date("Y-m-d h:i:s"),
                    "customer_support_md_by" =>    $this->session->userdata("login_id") 
               );  
        $this->db->update("customer_support_request",$ft,array("customer_support_id" => $this->input->post('support_id')));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        echo $this->db->last_query();exit;
        return FALSE;
    }
    public function update_contact_response(){
        $ft     =   array(  
                    "customer_support_response"        =>    $this->input->post('contact_response'),
                    "customer_support_md_on" =>    date("Y-m-d h:i:s"),
                    "customer_support_md_by" =>    $this->session->userdata("login_id") 
               );  
        $this->db->update("customer_support_request",$ft,array("customer_support_id" => $this->input->post('support_id')));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        echo $this->db->last_query();exit;
        return FALSE;
    }
    public function create_homecare_chatbot(){
        $question = $this->input->post('question');
        $option = $this->input->post('option');
        $list = array();
        if(is_array($question) && count($question)>0){
            foreach($question as $key => $q){
                $lii = array(
                    "option" => $option[$key],
                    "question" => $q
                    );
                array_push($list,$lii);
            }
        }
        $list = json_encode($list);

        $data = array(
                "registration_id"                   =>  ($this->input->post("registration_id"))??'',
                "list_of_answers"                   =>  ($list)??'',
                "submodule_id"                      =>  ($this->input->post("homecare_category"))??'',
                "homecare_chat_response_cr_on"      =>  date("Y-m-d h:i:s"),
                "homecare_chat_response_cr_by"      =>  $this->session->userdata("login_id")
        );
        $this->db->insert("homecare_chat_response",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp > 0){
                $title = 'Sujeevan chatbot';
                $message = 'Your Homecare Chatbot question submitted';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            return true;   
        }
        return false;
    }
    public function update_homecare_chatbot($str){
        $question = $this->input->post('question');
        $option = $this->input->post('option');
        $list = array();
        if(is_array($question) && count($question)>0){
            foreach($question as $key => $q){
                $lii = array(
                    "option" => $option[$key],
                    "question" => $q
                    );
                array_push($list,$lii);
            }
        }
        $list = json_encode($list);

        $data = array(
                "registration_id"                   =>  ($this->input->post("registration_id"))??'',
                "list_of_answers"                   =>  ($list)??'',
                "submodule_id"                      =>  ($this->input->post("homecare_category"))??'',
                "homecare_chat_response_md_on"      =>  date("Y-m-d h:i:s"),
                "homecare_chat_response_md_by"      =>  $this->session->userdata("login_id")
        );
        $this->db->update("homecare_chat_response",$data,"homecare_chat_responseid='".$str."'");
        $vsp   =    $this->db->affected_rows();
        if($vsp > 0){
                $title = 'Sujeevan chatbot';
                $message = 'Your Homecare Chatbot question updated';
                $id = $this->input->post("registration_id");
                $push_type = 'Customer';
                $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            return true;
        }
        return FALSE;
    }
    public function create_investigation(){
        $lab_name = $this->input->post('lab_name');
        $list = array();
        if(is_array($lab_name) && count($lab_name)>0){
            foreach($lab_name as $q){
                $lii = array(
                    "lab_name" => $q
                    );
                array_push($list,$lii);
            }
        }
        $list = json_encode($list);

        $data = array(
                "investigation_key"         =>  ($list)??'',
                "membership_assign_id"      =>  $this->input->post("membership_assign_id"),
                "investigation_cr_on"       =>  date("Y-m-d h:i:s"),
                "investigation_cr_by"       =>  $this->session->userdata("login_id")
        );
        $this->db->insert("investigation",$data);
        $vsp   =    $this->db->insert_id();
        if($vsp > 0){
            $daarata    =   array("investigation_id" =>  $vsp."INVS");
            $this->db->update("investigation",$daarata,array("investigationid" => $vsp));
            return true;  
        }
        return false;
    }
    public function update_investigation($str){
        $lab_name = $this->input->post('lab_name');
        $list = array();
        if(is_array($lab_name) && count($lab_name)>0){
            foreach($lab_name as $q){
                $lii = array(
                    "lab_name" => $q
                    );
                array_push($list,$lii);
            }
        }
        $list = json_encode($list);

        $data = array(
                "investigation_key"         =>  ($list)??'',
                "membership_assign_id"      =>  $this->input->post("membership_assign_id"),
                "investigation_md_on"       =>  date("Y-m-d h:i:s"),
                "investigation_md_by"       =>  $this->session->userdata("login_id")
        );
        $this->db->update("investigation",$data,"investigation_id='".$str."'");
        $vsp   =    $this->db->affected_rows();
        if($vsp > 0){
            return true;
        }
        return FALSE;
    }
        public function queryMembership_purchase($params = array()){
                 $dt     =   array(
                                // "user_package_open"         =>  "1",
                                // "user_package_status"       =>  "1"
                            );
                $sel    =   "*";
                if(array_key_exists("cnt",$params)){
                        $sel    =   "count(*) as cnt";
                }
                if(array_key_exists("columns",$params)){
                        $sel    =   $params["columns"];
                }
                $this->db->select("$sel")
                            ->from('membership_purchase as mp')
                            ->join('registration as r','r.registration_id = mp.membership_register_id','left')
                            ->where($dt); 
                if(array_key_exists("keywords",$params)){
                  $this->db->where("(register_name LIKE '%".$params["keywords"]."%' OR register_email LIKE '%".$params["keywords"]."%' OR register_mobile LIKE '%".$params["keywords"]."%' )");
                }
                if(array_key_exists("whereCondition",$params)){
                        $this->db->where("(".$params["whereCondition"].")");
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                        $this->db->limit($params['limit']);
                }
                if(array_key_exists("tipoOrderby",$params) && array_key_exists("order_by",$params)){
                        $this->db->order_by($params['tipoOrderby'],$params['order_by']);
                } 
                // $this->db->get();echo $this->db->last_query();exit;
                return $this->db->get();
        }
        public function cntviewMembership_purchase($params  = array()){
                $params["columns"]  =   "count(*) as cnt";
                $vsp     =  $this->queryMembership_purchase($params)->row_array();
                if($vsp != '' && count($vsp) > 0){
                        return $vsp['cnt'];
                }
                return 0;
        }
        public function viewMembership_purchase($params = array()){
            return $this->queryMembership_purchase($params)->result_array();
        }
        public function getMembership_purchase($params = array()){
            return $this->queryMembership_purchase($params)->row_array();
        }
    public function vaccine_request_status(){
        $ft     =   array(  
                    "vaccine_request_status"        =>    $this->input->post('status'),
                    "vaccine_request_md_on" =>    date("Y-m-d h:i:s"),
                    "vaccine_request_md_by" =>    $this->session->userdata("login_id") 
               );  
        $this->db->update("vaccine_request",$ft,array("vaccine_request_id" => $this->input->post('vaccine_id')));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        echo $this->db->last_query();exit;
        return FALSE;
    }
    public function bookappointment_request_status(){
        $ft     =   array(  
                    "bookappointment_request_status"        =>    $this->input->post('status'),
                    "bookappointment_request_md_on" =>    date("Y-m-d h:i:s"),
                    "bookappointment_request_md_by" =>    $this->session->userdata("login_id") 
               );  
        $this->db->update("bookappointment_request",$ft,array("bookappointment_request_id" => $this->input->post('bookappointment_id')));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        echo $this->db->last_query();exit;
        return FALSE;
    }
}
?>