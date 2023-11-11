<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-homecare-tests") == "1"){ ?>
<?php $this->load->view("create_hometest");?>
<?php } ?>
<?php $this->load->view("viewfile");?>