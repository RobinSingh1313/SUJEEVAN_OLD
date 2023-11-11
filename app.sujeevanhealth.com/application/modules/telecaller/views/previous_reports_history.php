
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
             <?php 
             $i=1;
                if(count($images)>0){ 
                    foreach($images as $vw){?>
                    <div class="card-body" style="padding:10px;">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                <div>S No:</div>
                                <div><strong><?php echo $i ?></strong></div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                <div>File Attachment:</div>
                                <div><a href="<?php echo $vw['image'] ?>" target="_blank"><strong><?php echo $vw['file_name'] ?></strong></a></div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                <div>Uploaded Date:</div>
                                <div><strong><?php echo $vw['previous_reports_cr_on'] ?></strong></div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                <div>Action:</div>
                                <div><a href="<?php echo $vw['image'] ?>" target="_blank" style="padding:5px;" class="btn btn-oblong btn-success btn-block mg-b-10">View Attachment</a></div>
                            </div>
                         </div>
                    </div>
            <?php $i++;} } else {?>
                <div><strong>No files found!</strong></div>
            <?php } ?>
        </div><!--end card-->
    </div>
</div> 