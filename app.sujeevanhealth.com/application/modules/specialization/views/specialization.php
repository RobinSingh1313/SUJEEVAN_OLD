<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-specialization") == "1"){ ?>
<?php $this->load->view("create_specialization");?>
<?php } ?>
<?php $this->load->view("viewfile");?>