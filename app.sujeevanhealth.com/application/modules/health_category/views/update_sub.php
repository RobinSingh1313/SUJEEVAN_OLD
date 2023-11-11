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
                                            <option value="<?php echo $m['moduleid'];?>"  <?php echo (is_array($view) && $view['healthcategory_module_id'] == $m['moduleid'])?"selected=selected":set_select("module",$m['moduleid']);?>><?php echo $m['module_name'];?></option>
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
                                <select class="form-control healthcategory" name="healthcategory" required>
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
                                <label>Sub Category Name <span class="required text-danger">*</span></label>
                                <input name="subcategory_name" type="text" class="form-control subcategory_name" placeholder="Enter Sub Category" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["healthsubcategory_name"]:set_value("subcategory_name");?>"/>
                                <?php echo form_error('subcategory_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Image upload <span class="required text-danger">*</span></label>
                                <input name="module_image" type="file" class="form-control imgclaslobdg"/>
                                <?php
                                $fname      =   $view["healthsubcategory_image"];
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