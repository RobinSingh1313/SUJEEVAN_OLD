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
                                <select class="form-control healthcategory" name="healthcategory" required="">
                                    <option value="">Select Health Category</option>
                                </select>
                                <?php echo form_error('healthcategory');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Sub Category Name <span class="required text-danger">*</span></label>
                                <input name="subcategory_name" type="text" class="form-control subcategory_name" placeholder="Enter Sub Category" required="" autocomplete="off" value="<?php echo set_value("subcategory_name");?>"/>
                                <?php echo form_error('subcategory_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Image upload <span class="required text-danger">*</span></label>
                                <input name="module_image" type="file" class="form-control imgclaslobdg"/>
                                <div class="imgslosc"></div>
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