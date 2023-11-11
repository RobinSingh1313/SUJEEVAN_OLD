<?php
class App_updates extends CI_Controller{
    // public function __construct() {
    //     parent::__construct();
    //     if($this->session->userdata("manage-app-update") != '1'){
    //         redirect(sitedata("site_admin")."/Dashboard");
    //     }
    // }

    public function index(){
        $dta       =   array(
                "title"     =>  "App Updates",
                "content"   =>  "app_updates",
        );
        $this->load->view("inner_template",$dta);
    }
    
    public function notify_appointusers(){
        $curdate = date('Y-m-d');
        $get_appoint_details = $this->db->query("select membership_assign_vendor,membership_register_id, appoint_datetime, current_datetime, 
            TIMESTAMPDIFF(MINUTE,current_datetime,appoint_datetime) as datetime_diff from (
            SELECT membership_assign_vendor, mp.membership_register_id,CONCAT(membership_assign_date_from,' ',time_from) as appoint_datetime, 
            date_add(now(),interval 330 minute) as current_datetime FROM membership_assign ma
            inner join membership_purchase mp on mp.membership_purchase_id=ma.membership_purchase_id
            where membership_assign_status='Assigned' and membership_assign_date_from='".$curdate."' and membership_assign_vendor is not null 
            and membership_assign_vendor!='' and zoom_url is not null and zoom_url!='') as tab 
            where TIMESTAMPDIFF(MINUTE,current_datetime,appoint_datetime)=15")->result_array();
        foreach($get_appoint_details as $get_appoint_det){
            $title = 'Appointment';
            $message = 'You have an appointment scheduled in 15min.';
            //to vendor
            $id = $get_appoint_det['membership_assign_vendor'];
            $push_type = 'Vendor';
            $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            //to customer
            $cust_id = $get_appoint_det['membership_register_id'];
            $cust_push_type = 'Customer';
            $e = $this->common_config->send_notifications($title,$message,$cust_id,$cust_push_type);
        }
        echo 'sent';
    }
  
    public function __destruct() {
            $this->db->close();
    }
}