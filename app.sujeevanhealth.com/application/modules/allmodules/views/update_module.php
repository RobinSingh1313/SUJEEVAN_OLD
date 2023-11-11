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
                                <label>Module Name <span class="required text-danger">*</span></label>
                                <input name="module_name" type="text" class="form-control" placeholder="Module Name" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["module_name"]:set_value("module_name");?>"/>
                                <?php echo form_error('module_name');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Module Program </label>
                                <input name="module_program" type="checkbox" value="1" <?php echo (is_array($view) && count($view) > 0 &&  $view["module_program"] =="1")?"checked=checked":"";?>/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Upload Image</label>
                                <input name="module_image" type="file" class="form-control imgclaslobdg"/>
                                <?php
                                $fname      =   $view["module_image"];
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