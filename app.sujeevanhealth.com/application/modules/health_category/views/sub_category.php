<?php if($this->session->userdata("create-health-sub-category") == "1"){ ?>
<?php $this->load->view("create_sub");?>
<?php } ?>
<?php $this->load->view("viewfile");?>