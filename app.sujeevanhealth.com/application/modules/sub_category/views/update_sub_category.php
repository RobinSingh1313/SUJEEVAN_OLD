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
                                <label>Select Module<span class="required text-danger">*</span></label>
                                <select class="form-control" name="module" required onchange="getCategory()" id="module">
                                    <option value="">Select Module</option>
                                    <?php foreach($module as $m){ ?>
                                    <?php if($m['moduleid']==$view['sub_category_module_id']){?>
                                    <option value="<?php echo $m['moduleid'];?>" selected><?php echo $m['module_name'];?></option>
                                     <?php }else{?>
                                        <option value="<?php echo $m['moduleid'];?>" ><?php echo $m['module_name'];?></option>
                                     <?php }}?>
                                </select>
                                <?php echo form_error('module');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Category<span class="required text-danger">*</span></label>
                                <select class="form-control" name="category" required id="category">
                                    <option value="">Select Category</option>
                                </select>
                                <?php echo form_error('module');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Sub Category Name<span class="required text-danger">*</span></label>
                                <input name="sub_category_name" type="text" class="form-control" placeholder="Enter Sub Category" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["sub_category_name"]:set_value("sub_category_name");?>"/>
                                <input type="hidden" id="cci" value="<?php echo $view['sub_category_module_id'];?>">
                                <?php echo form_error('sub_category_name');?> 
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