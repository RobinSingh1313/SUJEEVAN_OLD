<?php if($this->session->userdata("create-video-type") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
            <a  href="<?php echo adminurl("Create-Video-Type");?>" class="btn btn-sm btn-info">Create Video Type</a>
        </div>
    </div>
</div>
<?php } ?>
<?php $this->load->view("viewfile");?>