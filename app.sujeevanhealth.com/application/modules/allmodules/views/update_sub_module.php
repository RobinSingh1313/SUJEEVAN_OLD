<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Module <span class="required  text-danger">*</span></label>
                                <input type='hidden' name="sub_moduleid" class="sub_moduleid" value="<?php echo $view["sub_moduleid"];?>"/>
                                <select class="form-control select2 moduleid" name="module" required>
                                    <option value="">Select Module</option>
                                    <?php foreach($module as $m){ ?>
                                    <option value="<?php echo $m['moduleid'];?>" <?php echo ($view['sub_module_module_id'] == $m["moduleid"])?"selected=selected":set_select("module",$m['moduleid']);?>><?php echo $m['module_name'];?></option>
                                     <?php }?>
                                </select>
                                <?php echo form_error('module');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Vendors <span class="required  text-danger">*</span></label> 
                                <select class="form-control select2 vendor_id" name="vendor_id" required>
                                    <option value="">Select Vendors</option>
                                    <?php foreach($vendor as $m){ ?>
                                    <option value="<?php echo $m['vendor_id'];?>" <?php echo ($view['sub_vendor_id'] == $m["vendor_id"])?"selected=selected":set_select("vendor_id",$m['vendor_id']);?>><?php echo $m['vendor_name'];?></option>
                                     <?php }?>
                                </select>
                                <?php echo form_error('vendor_id');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Sub Module Name <span class="required text-danger">*</span></label>
                                <input name="sub_module_name" type="text" class="form-control sub_module_name" placeholder="Enter Sub Module" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["sub_module_name"]:set_value("sub_module_name");?>"/>
                                <?php echo form_error('sub_module_name');?> 
                            </div>
                        </div>
                        
                      	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Upload Image</label>
                                <input name="module_image" type="file" class="form-control imgclaslobdg"/>
                                <?php
                                $fname      =   $view["sub_module_image"];
                                $target_dir =   $this->config->item("upload_dest")."modules/";
                                $oml        =   "";
                                $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
                                if (file_exists($filename)) {
                                    $finame   =   base_url().$target_dir.'/'.$fname;
                                    $oml    =   "<img src='".$finame."' class='img imglogoho img-thumbnail mt-1 img-responsive'/>";
                                }
                                ?>
                                <div class="imgslosc"><?php echo $oml;?></div>
                            </div>
                        </div>
                      	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                              <div>
                                  <input type="checkbox" name="submodule_isblog"  <?php echo (is_array($view) && count($view) > 0 && $view["submodule_isblog"] == "1")?"checked=checked":"";?> value="1"/> Is Module Blog 
                                </div>
                                <div>
                                    <input type="checkbox" name="submodule_isquestios" value="1" <?php echo (is_array($view) && count($view) > 0 && $view["submodule_isquestions"] == "1")?"checked=checked":"";?>/> Is Module Question & Answers
                                </div>
                                <div>
                                    <input type="checkbox" name="submodule_isconsult" value="1" <?php echo (is_array($view) && count($view) > 0 && $view["submodule_isconsult"] == "1")?"checked=checked":"";?>/> Is Module Consultation
                                </div>
                                  <div>
                                    <input type="checkbox" name="submodule_ismodule" value="1"  <?php echo (is_array($view) && count($view) > 0 && $view["submodule_ismodule"] == "1")?"checked=checked":"";?>/> Is Home Care Sub Module
                                </div>
                                
                                <div>
                                  	<input type="checkbox" name="submodule_isdesc" value="1"  <?php echo (is_array($view) && count($view) > 0 && $view["submodule_isdesc"] == "1")?"checked=checked":"";?> /> Is Module Description (for tips and about only)
                                </div>
                          	</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Sort Order No</label>
                                <input name="sort_order" type="number" class="form-control" placeholder="Enter Sort Order" autocomplete="off" value="<?php echo $view["sub_module_order"];?>"/>
                                <?php echo form_error('sort_order');?> 
                            </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <div class="form-group">
                            <label>Sub Module Description (for tips and about only) </label>
                            <textarea name="sub_module_desc" type="text" class="form-control sub_module_desc" placeholder="Enter Sub Module Description" autocomplete="off" id="summernote" ><?php echo $view["sub_module_desc"];?></textarea>
                            <?php echo form_error('sub_module_desc');?> 
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