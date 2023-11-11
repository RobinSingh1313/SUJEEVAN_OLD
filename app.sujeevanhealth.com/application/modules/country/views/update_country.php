<div class="row">
    <div class="col-lg-12">
        <form method="post" action="" novalidate="" autocomplete="off" class="validatform">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $this->load->view("success_error");?> 
                    <div class="row"> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country <span class="text-danger">*</span></label>   
                                <input name="countryname" type="text" countryid="<?php echo $view["country_id"];?>" class="form-control countryname text-capitalize" placeholder="Country Name" value="<?php echo (is_array($view) && count($view) > 0)?$view["country_name"]:set_value('country_name');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('countryname');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Currency <span class="text-danger">*</span></label>   
                                <input name="country_currency" type="text" class="form-control text-capitalize" placeholder="Country Currency" value="<?php echo (is_array($view) && count($view) > 0)?$view["country_currency"]:set_value('country_currency');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_currency');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Code <span class="text-danger">*</span></label>   
                                <input name="country_code" type="text" class="form-control text-capitalize" placeholder="Country Code" value="<?php echo (is_array($view) && count($view) > 0)?$view["country_code"]:set_value('country_code');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_code');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Employee Prefix <span class="text-danger">*</span></label>   
                                <input name="country_employee_prefix" type="text" class="form-control text-capitalize" placeholder="Employee Prefix" value="<?php echo (is_array($view) && count($view) > 0)?$view['country_employee_prefix']:set_value('country_employee_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_employee_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Trip Prefix <span class="text-danger">*</span></label>   
                                <input name="country_trip_prefix" type="text" class="form-control text-capitalize" placeholder="Trip Prefix" value="<?php echo (is_array($view) && count($view) > 0)?$view['country_trip_prefix']:set_value('country_trip_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_trip_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Piligrim Prefix <span class="text-danger">*</span></label>   
                                <input name="country_piligrim_prefix" type="text" class="form-control text-capitalize" placeholder="Piligrim Prefix" value="<?php echo (is_array($view) && count($view) > 0)?$view['country_piligrim_prefix']:set_value('country_piligrim_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_piligrim_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Relative Prefix <span class="text-danger">*</span></label>   
                                <input name="country_piligrimrelative_prefix" type="text" class="form-control text-capitalize" placeholder="Relative Prefix" value="<?php echo  (is_array($view) && count($view) > 0)?$view['country_piligrimrelative_prefix']:set_value('country_piligrimrelative_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_piligrimrelative_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country <span class="text-danger">*</span></label> 
                                <select class="form-control" name="country_timezone">
                                    <option value="">Select Timezone</option>
                                    <?php
                                        $country_timezone  =    $this->common_config->time_zonelist();
                                        foreach($country_timezone as $ver){
                                            $vr    =   $ver["zone"];
                                            $fer    =   $vr." (UTC ".$ver["diff_from_GMT"].") ";
                                            ?>
                                    <option value="<?php echo $vr;?>" <?php echo ($vr == $view["country_timezone"])?"selected='selected'":"";?>><?php echo $fer;?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <?php echo form_error("country_timezone");?>
                            </div>
                        </div>
                    </div>			
                </div> 
                <div class="panel-footer">
                    <div class="clearfix">
                        <div class="pull-left">
                            <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save</button>
                        </div>
                     </div>
                 </div>
            </div>
        </form>
    </div>
</div>