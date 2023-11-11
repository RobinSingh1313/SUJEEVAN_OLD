<?php if($this->session->userdata("manage-how-works") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
            <a  href="<?php echo adminurl("Works");?>" class="btn btn-sm btn-info">How it Works</a>
        </div>
    </div>
</div>
<?php } ?>
<?php $this->load->view("success_error");?> 
<?php if($this->session->userdata("create-homecare-packages") == "1"){ ?>
<?php $this->load->view("create_homecare");?>
<?php } ?>
<?php $this->load->view("viewfile");?>