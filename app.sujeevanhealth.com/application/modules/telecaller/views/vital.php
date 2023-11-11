
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Weight</label>
                                <input name="vital_weight" type="text" class="form-control" placeholder="Enter Weight"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_weight"]:set_value("vital_weight");?>"/>
                                <?php echo form_error('vital_weight');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Temperature</label>
                                <input name="vital_temperature" type="text" class="form-control" placeholder="Enter Temperature"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_temperature"]:set_value("vital_temperature");?>"/>
                                <?php echo form_error('vital_temperature');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <input name="vital_pulse_rate" type="text" class="form-control" placeholder="Enter Pulse Rate"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_pulse_rate"]:set_value("vital_pulse_rate");?>"/>
                                <?php echo form_error('vital_pulse_rate');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Respiratory Rate</label>
                                <input name="vital_respiratory_rate" type="text" class="form-control" placeholder="Enter Respiratory Rate"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_respiratory_rate"]:set_value("vital_respiratory_rate");?>"/>
                                <?php echo form_error('vital_respiratory_rate');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>spo2</label>
                                <input name="vital_spo2" type="text" class="form-control" placeholder="Enter spo2"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_spo2"]:set_value("vital_spo2");?>"/>
                                <?php echo form_error('vital_spo2');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>BP</label>
                                <input name="vital_bp" type="text" class="form-control" placeholder="Enter BP"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_bp"]:set_value("vital_bp");?>"/>
                                <?php echo form_error('vital_bp');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>CVS</label>
                                <input name="vital_cvs" type="text" class="form-control" placeholder="Enter CVS"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_cvs"]:set_value("vital_cvs");?>"/>
                                <?php echo form_error('vital_cvs');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>CNS</label>
                                <input type="hidden" name="registration_id" value="<?php echo $this->input->get('user_id');?>"/>
                                <input name="vital_cns" type="text" class="form-control" placeholder="Enter CNS"  autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["vital_cns"]:set_value("vital_cns");?>"/>
                                <?php echo form_error('vital_cns');?> 
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