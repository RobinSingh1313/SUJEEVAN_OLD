<?php
$cr     =   $this->session->userdata("create-country");
?>
<div class="row">
    <?php if($cr == 1) { ?>
    <div class="col-lg-12">
        <form method="post" action="" novalidate="" autocomplete="off" class="validatform">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $this->load->view("success_error");?> 
                    <div class="row"> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country <span class="text-danger">*</span></label>   
                                <input name="country_name" type="text" class="form-control country_name text-capitalize" placeholder="Country Name" value="<?php echo set_value('country_name');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_name');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Currency <span class="text-danger">*</span></label>   
                                <input name="country_currency" type="text" class="form-control text-capitalize" placeholder="Country Currency" value="<?php echo set_value('country_currency');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_currency');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Code <span class="text-danger">*</span></label>   
                                <input name="country_code" type="text" class="form-control text-capitalize" placeholder="Country Code" value="<?php echo set_value('country_code');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_code');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Employee Prefix <span class="text-danger">*</span></label>   
                                <input name="country_employee_prefix" type="text" class="form-control text-capitalize" placeholder="Employee Prefix" value="<?php echo set_value('country_employee_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_employee_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Trip Prefix <span class="text-danger">*</span></label>   
                                <input name="country_trip_prefix" type="text" class="form-control text-capitalize" placeholder="Trip Prefix" value="<?php echo set_value('country_trip_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_trip_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Piligrim Prefix <span class="text-danger">*</span></label>   
                                <input name="country_piligrim_prefix" type="text" class="form-control text-capitalize" placeholder="Piligrim Prefix" value="<?php echo set_value('country_piligrim_prefix');?>" required="" minlength="3" maxlength="50"/> 
                                <?php echo form_error('country_piligrim_prefix');?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Relative Prefix <span class="text-danger">*</span></label>   
                                <input name="country_piligrimrelative_prefix" type="text" class="form-control text-capitalize" placeholder="Relative Prefix" value="<?php echo set_value('country_piligrimrelative_prefix');?>" required="" minlength="3" maxlength="50"/> 
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
                                    <option value="<?php echo $vr;?>"><?php echo $fer;?></option>
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
    <?php } ?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="text-success">View Countries</h4><hr/>
                <?php $this->load->view("allsearch");?>		
            </div> 
        </div>
    </div>
</div>