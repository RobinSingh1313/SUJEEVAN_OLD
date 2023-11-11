<div class="row mb-5">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Module<span class="required text-danger">*</span></label>
                                <select class="form-control pd-y-12" name="module_id" id="module_id" onchange="getsubmoduleSelect()" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    foreach($module as $m){ ?>
                                        <option value="<?php echo $m->moduleid; ?>" <?php //if($view["user_package_module_id"]==$m->moduleid){ echo 'selected'; } ?>><?php echo $m->module_name; ?></option>
                                    <?php } ?>
                                </select> 
                             </div><!-- form-group -->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Sub Module</label>
                                <input type="hidden" id="sub_module_id" value="<?php //echo $view["user_package_sub_module_id"];?>">
                                <select class="form-control pd-y-12" name="submodule" id="submodule">
                                    <option value="">Select Sub Module</option>
                                    <?php 
                                    foreach($sub_module as $s){ ?>
                                        <option value="<?php echo $s->sub_module_id; ?>" <?php //if($view["user_package_sub_module_id"]==$s->sub_module_id){ echo 'selected'; } ?>><?php echo $s->sub_module_name; ?></option>
                                    <?php } ?>
                                </select> 
                                <?php echo form_error('submodule');?> 
                             </div><!-- form-group -->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label>Order  <span class="required text-danger">*</span></label> 
                                <input type="text" class="form-control" placeholder="Order" required="" name="order" value="<?php echo set_value('order');?>"/>
                                <?php echo form_error('order');?> 
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label>Options</label>
                                <div>
                                    <input name="botauto_tags" type="text"  data-role="tagsinput" class="form-control text-capitalize" placeholder="Options" value="<?php echo set_value('botauto_tags');?>" required=""/>
                                </div>
                                <?php echo form_error('botauto_tags');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label>Question  <span class="required text-danger">*</span></label> 
                                <textarea class="form-control" placeholder="Question" required="" name="botauto_question"><?php echo set_value('botauto_question');?></textarea>
                                <?php echo form_error('botauto_question');?> 
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