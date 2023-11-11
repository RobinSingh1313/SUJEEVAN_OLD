<?php if($this->session->userdata("create-package") == "1"){ ?>
<?php $this->load->view("create_package");?>
<?php } ?>
<?php $this->load->view("viewfile");?>