<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="answerid" value="<?php echo $answerid?>">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Question <span class=" text-danger">*</span></label>
                                <input name="qa_question" type="text" class="form-control" placeholder="Enter Question" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["qa_question"]:set_value("qa_question");?>"/>
                                <?php echo form_error('qa_question');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Answer <span class=" text-danger">*</span> </label>
                                <textarea name="qa_answer" type="text" class="form-control" rows="10" placeholder="Enter Answer" autocomplete="off" required><?php echo $answer ?></textarea>
                                <?php echo form_error('qa_answer');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label> Your Name <span class=" text-danger">*</span></label>
                                <select class="form-control" name="regvendor_id" required>
                                    <option value="">Select Your Name</option>
                                   <?php if(is_array($RegVendor) && count($RegVendor) > 0){
                        foreach($RegVendor as $rv){ ?>
                           <option value="<?php echo $rv['regvendor_id'];?>" <?php echo (is_array($view) && count($view) > 0 && $rv['regvendor_id']== $view['qa_modified_by'])?"selected=selected":set_select("regvendor_id",$rv["regvendor_id"]);?>><?php echo $rv['regvendor_name'];?></option>
                           <?php }
                        }?>
                                </select>
                                <?php echo form_error('regvendor_id');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label> Module <span class=" text-danger">*</span></label>
                                <select class="form-control" name="module" required>
                                    <option value="">Select Module</option>
                                   <?php if(is_array($module) && count($module) > 0){
                        foreach($module as $m){ ?>
                           <option value="<?php echo $m['moduleid'];?>" <?php echo (is_array($view) && count($view) > 0	&& $m['moduleid']==	$view['qa_module_id'])?"selected=selected":set_select("module",$m["moduleid"]);?>><?php echo $m['module_name'];?></option>
                           <?php }
                        }?>
                                </select>
                                <?php echo form_error('module');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Health Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategory" name="health_category" onchange="updaatehealthcategory()" required>
                                    
                                    <?php 
                                    if(is_array($HealthCategory) && count($HealthCategory) > 0){
                                        foreach($HealthCategory as $hc){ ?>
                                            <option value="<?php echo $hc['healthcategory_id'];?>" <?php echo (is_array($view) && count($view) > 0    && $hc['healthcategory_id']== $view['qa_healthcategory_id'])?"selected=selected":set_select("health_category",$hc["healthcategory_id"]);?>><?php echo $hc['healthcategory_name'];?></option>
                                     <?php } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('health_category');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Health SubCategory <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategorysub" name="sub_health_category" required>
                                    <option value="">Select Health SubCategory</option>
                                    <?php 

                                    if(is_array($HealthSubCategory) && count($HealthSubCategory) > 0){
                                        
                                        foreach($HealthSubCategory as $hsc){
                                       ?>
                                       <option value="<?php echo $hsc['healthsubcategory_id'];?>" <?php echo (is_array($view) && count($view) > 0    && $hsc['healthsubcategory_id']== $view['qa_healthsubcategory_id'])?"selected=selected":set_select("health_sub_category",$hsc["healthsubcategory_id"]);?>><?php echo $hsc['healthsubcategory_name'];?></option>
                                       <?php 
                                      } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('sub_health_category');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Images (optional)</label>
                                <input type="file" name="image" class="imgclaslobdg form-control" />
                                <?php echo form_error('image');?> 
                                <div class="imgslosc">
                                 	<?php
                                        $target_dir     =   $this->config->item("upload_dest");
                                        $direct         =   $target_dir."blog";
                                        $vspl   =   $view["qa_image_path"];
                                        $imsk   =   $_SERVER["DOCUMENT_ROOT"]."/".$direct."/";
                                        if($vspl != ""){
                                            $vok    =  $imsk.$vspl;
                                            if(file_exists($vok)){
                                                $imsh   = base_url().$direct."/".$vspl;
                                                ?>
                                                <img src="<?php echo $imsh;?>" class="img imglogoho mt-1 img-thumbnail img-responsive"/>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
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