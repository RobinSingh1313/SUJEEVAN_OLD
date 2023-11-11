<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php if($this->session->userdata("create-content-page") == "1"){ ?>
                <div class="mg-b-15 float-right">
                    <a  href="<?php echo adminurl("Create-Content-Pages");?>" class="btn btn-sm btn-info">Create Content Page</a>
                </div>
                <?php } ?>
                <?php $this->load->view("allsearch");?>
            </div>
        </div>
    </div>
</div>   