<?php if($this->session->userdata("create-membership") == "1"){ ?>
<?php $this->load->view("create_membership");?>
<?php } ?>
<?php $this->load->view("viewfile");?>