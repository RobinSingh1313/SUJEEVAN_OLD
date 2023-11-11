<?php if($this->session->userdata("create-category") == "1"){ ?>
<?php $this->load->view("create_category");?>
<?php } ?>
<?php $this->load->view("viewfile");?>