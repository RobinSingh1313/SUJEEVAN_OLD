<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-doctor") == "1"){ ?>
<?php $this->load->view("create_doctor");?>
<?php } ?>
<?php $this->load->view("viewfile");?>