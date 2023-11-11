<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-banners") == "1"){ ?>
<?php $this->load->view("create_banner");?>
<?php } ?>
<?php $this->load->view("viewfile");?>