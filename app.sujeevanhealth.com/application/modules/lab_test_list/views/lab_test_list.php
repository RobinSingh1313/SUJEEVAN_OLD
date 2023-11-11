<?php if($this->session->userdata("create-lab_test_list") == "1"){ ?>
<?php $this->load->view("create_lab_test_list");?>
<?php } ?>
<?php $this->load->view("viewfile");?>