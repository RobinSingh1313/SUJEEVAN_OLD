<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div> 
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body"> 
                <form action="" method="post" class="validatform formssample" id="role" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-group">
                                    <?php
                                        $widget_alias_name  =   $view['widget_alias_name'];
                                        $filename   =   sitedata("widget_path")."/".$widget_alias_name.".php";
                                        $dta  =   read_file($filename);
                                    ?>
                                    <label><?php echo $view["widget_display_name"];?><span class="required text-danger">*</span></label>
                                    <input type="hidden" value="<?php echo $widget_alias_name;?>" name="widget_alias_name"/>
                                    <textarea class="form-control formcvalue" name="widgetvalue" rows="15"><?php echo $dta;?></textarea>
                                <?php echo form_error('username');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-raised btn-success waves-effect" name="submit" value="submit"> Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> 
</div>   