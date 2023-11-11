<?php
class Common extends CI_Controller{
        public function pagenotfound(){
                $dta    =   array(
                    "title"     =>  "Page Not Found",
                    "content"   =>  "pagenotfound"
                );
                $this->load->view("admin/outer_template",$dta);
        }
        public function clearfilter(){
            $pageurl   =    $this->input->post("pageurl");
            $this->session->unset_userdata($pageurl);
        }
        public function uploaduserfilefiles(){
                $pic    =   "";
                $target_dir =   $this->config->item("upload_dest")."blog/";
                //$target_dir =   "uploads/";
                $fname      =   $_FILES["userfile"]["name"]; 
                $filename   =   $_SERVER['DOCUMENT_ROOT'].'/uploads/blog/'.$fname;
                $vsp        =   explode(".",$fname);
                $ect        =   end($vsp);  
                if (file_exists($filename)) {
                    $fname      =   basename($fname,".".$ect)."_".date("YmdHis").".".end($vsp);
                }
                $uploadfile =   $target_dir . ($fname);
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                    $pic =  $fname;
                }
                echo $fname;
        }
        public function removevideo(){  
            $value      =   $this->input->post("value");
            $fname		=	$this->input->post("valuename");
            if($fname != ""){
                /*
                $pms['whereCondition']  =   "topicvideo_id LIKE '$value'";
                $vue    =   $this->topics_model->getTopicvideos($pms);
                $fname 	=	$vue["topicvideo_video_url"];
                if(is_array($vue) && count($vue) > 0){
                    $this->topics_model->delete_videotopic($value);
                }
                */
                $target_dir =   $this->config->item("upload_dest")."blog/";
                $filename   =   $_SERVER['DOCUMENT_ROOT'].'/uploads/blog/'.$fname;
                if (file_exists($filename)) {
                    unlink($target_dir.$fname);
                }
            }
        }
        public function vendorsajax(){
                $vsp    =   $this->input->post("term");
                $pms["whereCondition"]  =   "vendor_acde = 'Active' and vendor_name like '%".$vsp."%'";
                $pms["columns"]         =   "vendor_id as id,vendor_name as text";
                $categories             =   $this->vendor_model->viewVendors($pms);
                if(is_array($categories) && count($categories) > 0){
                    echo json_encode($categories);
                }
        }
        public function healthcategory(){
            $vslp   =   $this->input->post("module");
            $pms["whereCondition"]  =   "healthcategory_acde = 'Active' and healthcategory_module_id like '%".$vslp."%'";
            $pms["columns"]         =   "healthcategory_id as id,healthcategory_name as text";
            $categories             =   $this->health_category_model->viewCategory($pms);
            echo "<option value=''>Select Health Category</option>";
            if(is_array($categories) && count($categories) > 0){
                foreach($categories as $ver){
                    echo '<option value="'.$ver["id"].'">'.$ver["text"].'</option>';
                }
            }
        }
        public function healthsubcategory(){
            $vslp   =   $this->input->post("healthcategory");
            $pms["whereCondition"]  =   "healthsubcategory_acde = 'Active' and healthsubcategory_health_id like '%".$vslp."%'";
            $pms["columns"]         =   "healthsubcategory_id as id,healthsubcategory_name as text";
            $view	=	$this->health_category_model->viewsubCategory($pms) ;
            echo "<option value=''>Select Health Sub Category</option>";
            if(is_array($view) && count($view) > 0){
                foreach($view as $ver){
                    echo '<option value="'.$ver["id"].'">'.$ver["text"].'</option>';
                }
            }
        }
        public function ajax_submodules(){
            $sub_module = $this->db->query("select sub_module_id,sub_module_name from  sub_module Where submodule_ismodule = '0' and sub_module_acde = 'Active' and sub_module_module_id  = '".$this->input->post('module_id')."' AND sub_module_open = '1'")->result();
            if(is_array($sub_module) && count($sub_module)>0){
                $output = '<option value="">Select Sub Module</option>';
                foreach($sub_module as $d){
                    $id = $d->sub_module_id;
                    $name = $d->sub_module_name;
                    $selected = ($d->sub_module_id==$this->input->post('sub_module_id'))?'selected':'';
                    $output .='<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                }
                echo $output;
            }
            
        }
        public function BookAppointmentTimeSlot(){ 
            if($this->session->userdata("manage-appointment-time-slot") != '1'){
                redirect(sitedata("site_admin")."/Dashboard");
            }
            $data  = array(
                            "title"		=>	"Book Appointment Time Slot",
                            "content"	=>	"book_appointment_time_slot"
            );
            $assign_id  =   $this->input->get('membership_assign_id');
            if($this->input->post("submit")){
                $this->form_validation->set_rules("book_appointment_time","Time ","required");
                $this->form_validation->set_rules("book_appointment_time_type","Type ","required");
                if($this->form_validation->run()){
                    $ins    = $this->common_model->update_time_slot();
                    if($ins){
                        $this->session->set_flashdata("suc","Updated Successfully.");
                    }else{
                        $this->session->set_flashdata("err","Not Updated");
                    }  
                }
            }
            $data['time_slot'] = $this->db->query("select * from  book_appointment_time_slot")->row_array();
            $this->load->view("inner_template",$data);
        }
        public function __destruct(){
                $this->db->close();
        }
}