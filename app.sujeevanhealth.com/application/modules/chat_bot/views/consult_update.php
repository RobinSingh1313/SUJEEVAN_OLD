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
                                        foreach($module as $m){ 
                                            $cl     =   ($view['module_id'] == $ver['id'])?"selected=selected":"";
                                            ?>
                                            <option value="<?php echo $m['moduleid'];?>"  <?php echo ($cl != '')?$cl:set_select("module",$m['moduleid']);?>><?php echo $m['module_name'];?></option>
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
                                    <?php
                                    $vslp   =   $view['healthcategory_module_id'];
                                    $pms["whereCondition"]  =   "healthcategory_acde = 'Active' and healthcategory_module_id like '%".$vslp."%'";
                                    $pms["columns"]         =   "healthcategory_id as id,healthcategory_name as text";
                                    $categories             =   $this->health_category_model->viewCategory($pms);
                                    echo "<option value=''>Select Health Category</option>";
                                    if(is_array($categories) && count($categories) > 0){
                                        foreach($categories as $ver){
                                            $cl     =   ($view['healthsubcategory_health_id'] == $ver['id'])?"selected=selected":"";
                                            echo '<option value="'.$ver["id"].'" '.$cl.'>'.$ver["text"].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('healthcategory');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Sub Category <span class="required text-danger">*</span></label>
                                <select class="form-control healthcategorysub" name="healthcategorysub" required="">
                                    <?php
                                    $vslp   =   $view['healthsubcategory_health_id'];
                                    $pms["whereCondition"]  =   "healthsubcategory_acde = 'Active' and healthsubcategory_health_id like '%".$vslp."%'";
                                    $pms["columns"]         =   "healthsubcategory_id as id,healthsubcategory_name as text";
                                    $vi	=	$this->health_category_model->viewsubCategory($pms) ;
                                    echo "<option value=''>Select Health  Sub Category</option>";
                                    if(is_array($vi) && count($vi) > 0){
                                        foreach($vi as $ver){
                                            $cl     =   ($view['consult_sub_health'] == $ver['id'])?"selected=selected":"";
                                            echo '<option value="'.$ver["id"].'" '.$cl.'>'.$ver["text"].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('healthcategorysub');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Order  <span class="required text-danger">*</span></label> 
                                <input type="text" class="form-control" placeholder="Order" required="" name="consult_order" value="<?php echo (is_array($view) && count($view) > 0)?$view['consult_order']:set_value('consult_order');?>"/>
                                <?php echo form_error('consult_order');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Question  <span class="required text-danger">*</span></label> 
                                <textarea class="form-control" placeholder="Question" required="" name="botauto_question"><?php echo (isset($view) && is_array($view) && count($view) > 0)?$view["consult_question"]:set_value('botauto_question');?></textarea>
                                <?php echo form_error('botauto_question');?> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Options</label>
                                <div>
                                    <input name="botauto_tags" type="text"  data-role="tagsinput" class="form-control text-capitalize" placeholder="Options" value="<?php echo (is_array($view) && count($view) > 0)?$view['consult_options']:set_value('botauto_tags');?>" required=""/>
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