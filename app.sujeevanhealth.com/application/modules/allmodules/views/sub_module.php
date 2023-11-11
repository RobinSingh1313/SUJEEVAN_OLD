<?php if($this->session->userdata("create-sub-module") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
            <a  href="<?php echo adminurl("Create-Sub-Module");?>" class="btn btn-sm btn-info">Create Sub Module</a>
        </div>
    </div>
</div>
<?php } ?>
<?php $this->load->view("viewfile");?>