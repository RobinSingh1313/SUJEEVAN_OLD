<div class="row">
   <div class="col-lg-12">
      <?php $this->load->view("success_error");?> 
   </div>
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label>Question<span class="required text-danger">*</span></label>
                        <input name="qa_question" type="text" class="form-control" placeholder="Enter Question" required="" autocomplete="off" value="<?php echo set_value("qa_question");?>"/>
                        <?php echo form_error('qa_question');?> 
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label>Answer <span class=" text-danger">*</span> </label>
                        <textarea name="qa_answer" type="text" class="form-control" rows="10" placeholder="Enter Answer" autocomplete="off" required><?php echo set_value("qa_answer");?></textarea>
                        <?php echo form_error('qa_answer');?> 
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <div class="form-group">
                        <label>Select Your Name<span class=" text-danger">*</span></label>
                        <select class="form-control select2" name="regvendor_id" required>
                           <option value="">Select Your Name</option>
                            <?php if(is_array($RegVendor) && count($RegVendor) > 0){

                              foreach($RegVendor as $rv){ ?>
                           <option value="<?php echo $rv['regvendor_id'];?>" <?php echo set_select("regvendor_id",$rv["regvendor_id"]);?>><?php echo $rv['regvendor_name'];?></option>
                           <?php }
                            }?>
                        </select>
                        <?php echo form_error('regvendor_id');?> 
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <div class="form-group">
                        <label>Select Module<span class=" text-danger">*</span></label>
                        <select class="form-control select2" name="module" required>
                           <option value="">Select Module</option>
                            <?php if(is_array($module) && count($module) > 0){

                              foreach($module as $m){ ?>
                           <option value="<?php echo $m['moduleid'];?>" <?php echo set_select("module",$m["moduleid"]);?>><?php echo $m['module_name'];?></option>
                           <?php }
                            }?>
                        </select>
                        <?php echo form_error('module');?> 
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Health Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategory" name="health_category" onchange="updaatehealthcategory()" required>
                                    <option value="">Select Health category</option>

                                    <?php 
                                    if(is_array($HealthCategory) && count($HealthCategory) > 0){
                                        foreach($HealthCategory as $hc){ ?>
                                            <option value="<?php echo $hc['healthcategory_id'];?>"  <?php echo set_select("health_category",$hc['healthcategory_id']);?>><?php echo $hc['healthcategory_name'];?></option>
                                     <?php } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('health_category');?> 
                            </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Health Sub Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategorysub" name="health_sub_category" required>
                                    <option value="">Select Health Sub Category</option>

                                    
                                </select>
                                <?php echo form_error('health_sub_category');?> 
                            </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                     <div class="form-group">
                        <label>Images (optional)</label>
                        <input type="file" name="image" class="imgclaslobdg form-control" />
                        <?php echo form_error('image');?> 
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
         </div>
         <!--end card-body-->
      </div>
      <!--end card-->
   </div>
</div>