<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Module <span class="required text-danger">*</span></label>
                                <select class="form-control module" name="module" required>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Category Name <span class="required text-danger">*</span></label>
                                <input name="category_name" type="text" class="form-control category_name" placeholder="Enter Category" required="" autocomplete="off" value="<?php echo set_value("category_name");?>"/>
                                <?php echo form_error('category_name');?> 
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
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div> 