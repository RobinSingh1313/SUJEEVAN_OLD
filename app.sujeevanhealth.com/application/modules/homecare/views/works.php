<?php if($this->session->userdata("create-how-works") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
          	<a  href="<?php echo adminurl("Create-Works");?>" class="btn btn-sm btn-info">Create Works</a>
        </div>
    </div>
</div>
<?php } ?>
<?php $this->load->view("viewfile");?>