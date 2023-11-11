<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("engsnaplayout/success_error");?> 
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="activity" novalidate="">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Chat Box From Timings <span class="required text-danger">*</span></label>
                                <input name="chat_box_from_timings" type="text" class="form-control timepicker" placeholder="Chat Box Timings" value="<?php echo (is_array($view) && count($view) > 0)?$view["chat_box_from_timings"]:set_value('chat_box_from_timings');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_box_from_timings');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Chat Box To Timings <span class="required text-danger">*</span></label>
                                <input name="chat_box_to_timings" type="text" class="form-control endtimepicker" placeholder="Chat Box Timings" value="<?php echo (is_array($view) && count($view) > 0)?$view["chat_box_to_timings"]:set_value('chat_box_to_timings');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_box_to_timings');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Chat Box Working Days <span class="required text-danger">*</span></label>
                                <select class="form-control select2" multiple="" name="chatbox_working_days[]">
                                    <option value="">Select Working Days</option>
                                    <?php 
                                    $vspl       =   ($view["chatbox_working_days"] != "")?array_filter(explode(",",$view["chatbox_working_days"])):array();
                                    $weekdays   =   $this->config->item("weekdays");
                                    foreach($weekdays as $ve){
                                        $vsspl   =   in_array($ve,$vspl)?"selected='selected'":"";
                                        ?>
                                    <option value="<?php echo $ve;?>" <?php echo $vsspl;?>><?php echo $ve;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('chatbox_working_days[]');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Chat Box Queue <span class="required text-danger">*</span></label>
                                <select class="form-control select2" name="chatbox_queue">
                                    <option value="Auto" <?php echo (is_array($view) && $view["chatbox_queue"] == "Auto")?"selected=selected":"";?>>Auto Assign</option>
                                    <option value="Manual" <?php echo (is_array($view) && $view["chatbox_queue"] == "Manual")?"selected=selected":"";?>>Manual Assign</option>
                                </select>
                                <?php echo form_error('chatbox_queue');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Auto Bot From Timings <span class="required text-danger">*</span></label>
                                <input name="chat_bot_from_timings" type="text" class="form-control chtatimepicker" placeholder="From Timings" value="<?php echo (count($view) > 0)?$view["chat_bot_from_timings"]:set_value('chat_bot_from_timings');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_bot_from_timings');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                            <div class="form-group">
                                <label>Chat Box To Timings <span class="required text-danger">*</span></label>
                                <input name="chat_bot_to_timings" type="text" class="form-control endchattimepicker" placeholder="To Timings" value="<?php echo (count($view) > 0)?$view["chat_bot_to_timings"]:set_value('chat_bot_to_timings');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('chat_bot_to_timings');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-raised btn-success waves-effect" name="submit" value="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>