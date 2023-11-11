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
                                <label>Select Specialization <span class="required text-danger">*</span></label>
                                <select class="form-control" name="specialization" required>
                                    <option value="">Select Specialization</option>
                                    <?php 
                                    if(is_array($Specialization) && count($Specialization) > 0){
                                        foreach($Specialization as $s){ ?>
                                            <option value="<?php echo $s['specialization_id'];?>"  <?php echo ($view["specialization_id"] == $s["specialization_id"])?"selected=selected":set_select("Specializtion",$s['specialization_id']);?>><?php echo $s['specialization_name'];?></option>
                                     <?php } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('specialization');?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                <label>Select Health Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategory" name="health_category" onchange="updaatehealthcategory()" required>
                                    <option value="">Select Health Category</option>
                                    <?php 
                                    if(is_array($HealthCategory) && count($HealthCategory) > 0){
                                        foreach($HealthCategory as $hc){ ?>
                                            <option value="<?php echo $hc['healthcategory_id'];?>"  <?php echo ($view_hc["healthcategory_id"] == $hc["healthcategory_id"])?"selected=selected":set_select("HealthCategory",$hc['healthcategory_id']);?>><?php echo $hc['healthcategory_name'];?></option>
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
                                        $ci = ($view_hsc['healthsubcategory_id']==$hsc['healthsubcategory_id'])?"selected=selected":"";
                                        echo '<option value="'.$hsc["healthsubcategory_id"].'" '.$ci.'>'.$hsc["healthsubcategory_name"].'</option>'; 
                                           
                                      } 
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('sub_health_category');?> 
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