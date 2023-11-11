<?php if($this->session->userdata("create-question-answer") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
            <a  href="<?php echo adminurl("Create-Question-Answer");?>" class="btn btn-sm btn-info">Create Question Answer</a>
        </div>
    </div>
</div>
<?php } ?>
<?php $this->load->view("viewfile");?>