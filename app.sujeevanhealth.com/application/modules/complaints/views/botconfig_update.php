<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title text-primary">Update Auto Box</h4> <hr/>
                <form action="" method="post" class="validatform formssample" id="activity" novalidate="">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Auto Tags <span class="required text-danger">*</span></label>
                                <div>
                                    <input name="botauto_tags" type="text"  data-role="tagsinput" class="form-control text-capitalize" placeholder="Auto Tags" value="<?php echo (is_array($view) && count($view) > 0)?$view["botauto_tags"]:set_value('botauto_tags');?>" required=""/>
                                </div>
                                <?php echo form_error('botauto_tags');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Answer <span class="required text-danger">*</span></label> 
                                <textarea class="form-control" placeholder="Answer" name="botauto_answer"><?php echo (is_array($view) && count($view) > 0)?$view["botauto_answer"]:set_value('botauto_answer');?></textarea>
                                <?php echo form_error('botauto_answer');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-raised btn-success waves-effect" name="submit" value="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--end card-body-->
        </div>
    </div>
</div>      