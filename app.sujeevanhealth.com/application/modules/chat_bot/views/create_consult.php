<div class="row mb-5">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Module <span class="required text-danger">*</span></label>
                                <select class="form-control module" onchange="updaatehealth()"  name="module" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    if(is_array($module) && count($module) > 0){
                                        foreach($module as $m){ ?>
                                            <option value="<?php echo $m['moduleid'];?>"  <?php echo set_select("module",$m['moduleid']);?>><?php echo $m['module_name'];?></option>
                                     <?php } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('module');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Health Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategory" onchange="updaatehealthcategory()"  name="healthcategory" required="">
                                    <option value="">Select Health Category</option>
                                </select>
                                <?php echo form_error('healthcategory');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Sub Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategorysub" name="healthcategorysub" required="">
                                    <option value="">Select Health Sub Category</option>
                                </select>
                                <?php echo form_error('healthcategorysub');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Question  <span class="required text-danger">*</span></label> 
                                <textarea class="form-control" placeholder="Question" required="" name="botauto_question"><?php echo set_value('botauto_question');?></textarea>
                                <?php echo form_error('botauto_question');?> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Options</label>
                                <div>
                                    <input name="botauto_tags" type="text"  data-role="tagsinput" class="form-control text-capitalize" placeholder="Options" value="<?php echo set_value('botauto_tags');?>" required=""/>
                                </div>
                                <?php echo form_error('botauto_tags');?> 
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
    </div>
</div>