<?php
$lpl	=	$quotation_image    =   '';
$dl		=	'required=""';
?>
<div class="card mg-b-10">
  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
      <h6 class="card-title tx-uppercase tx-12 mg-b-0"><?php echo $til;?></h6>
    </div>
  <div class="card-body">
    <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                <div class="form-group">
                    <label>Auto Tags <span class="required text-danger">*</span></label>
                    <div>
                        <input name="botauto_tags" required="" type="text"  data-role="tagsinput" class="form-control text-capitalize" placeholder="Auto Tags" value="<?php echo set_value('botauto_tags');?>" required=""/>
                    </div>
                    <?php echo form_error('botauto_tags');?> 
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                <div class="form-group">
                    <label>Answer <span class="required text-danger">*</span></label> 
                    <textarea class="form-control" required="" placeholder="Answer" name="botauto_answer"><?php echo set_value('botauto_answer');?></textarea>
                    <?php echo form_error('botauto_answer');?> 
                </div>
            </div>
       </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
          <div class="form-actions form-group">
            <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>