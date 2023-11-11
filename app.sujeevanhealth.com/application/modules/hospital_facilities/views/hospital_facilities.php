<?php if($this->session->userdata("create-hospital_facilities") == "1"){ ?>
<?php $this->load->view("create_hospital_facilities");?>
<?php } ?>
<?php $this->load->view("viewfile");?>