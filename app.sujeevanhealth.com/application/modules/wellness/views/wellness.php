<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-wheel-wellness") == "1"){ ?>
<?php $this->load->view("create_wellness");?>
<?php } ?>
<?php $this->load->view("viewfile");?>