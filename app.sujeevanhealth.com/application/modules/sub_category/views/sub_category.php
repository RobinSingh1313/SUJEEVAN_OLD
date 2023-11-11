<?php if($this->session->userdata("create-sub-category") == "1"){ ?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="mg-b-5 float-right">
            <a  href="<?php echo adminurl("Create-Sub-Category");?>" class="btn btn-sm btn-info">Create Sub Category</a>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php $this->load->view("allsearch");?>
            </div>
        </div>
    </div>
</div>   