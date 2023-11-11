
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
                                <label>User Cheif Complaints</label>
                                <textarea name="prescription_cheif_complaints" type="text" class="form-control" placeholder="Enter User Cheif Complaints" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["prescription_cheif_complaints"]:set_value("prescription_cheif_complaints");?></textarea>
                                <?php echo form_error('prescription_cheif_complaints');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Past History</label>
                                <textarea name="prescription_past_history" type="text" class="form-control" placeholder="Enter User Past History" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["prescription_past_history"]:set_value("prescription_past_history");?></textarea>
                                <?php echo form_error('prescription_past_history');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Social History</label>
                                <textarea name="prescription_social_history" type="text" class="form-control" placeholder="Enter User Social History" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["prescription_social_history"]:set_value("prescription_social_history");?></textarea>
                                <?php echo form_error('prescription_social_history');?> 
                            </div>
                        </div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Family History</label>
                                <textarea name="prescription_family_history" type="text" class="form-control" placeholder="Enter User Family History" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["prescription_family_history"]:set_value("prescription_family_history");?></textarea>
                                <?php echo form_error('prescription_family_history');?> 
                            </div>
                        </div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Drug Allergies</label>
                                <textarea name="prescription_drug_allergies" type="text" class="form-control" placeholder="Enter User Drug Allergies" autocomplete="off" ><?php echo (is_array($view) && count($view) > 0)?$view["prescription_drug_allergies"]:set_value("prescription_drug_allergies");?></textarea>
                                <?php echo form_error('prescription_drug_allergies');?> 
                            </div>
                        </div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Provisional Diagnosis</label>
                                <textarea name="prescription_provisional_diagnosis" type="text" class="form-control" placeholder="Enter User Provisional Diagnosis" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["prescription_provisional_diagnosis"]:set_value("prescription_provisional_diagnosis");?></textarea>
                                <?php echo form_error('prescription_provisional_diagnosis');?> 
                            </div>
                        </div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Final Diagnosis</label>
                                <input type="hidden" name="registration_id" value="<?php echo $this->input->get('user_id');?>"/>
                                <textarea name="prescription_final_diagnosis" type="text" class="form-control" placeholder="Enter User Final Diagnosis" autocomplete="off"><?php echo (is_array($view) && count($view) > 0)?$view["prescription_final_diagnosis"]:set_value("prescription_final_diagnosis");?></textarea>
                                <?php echo form_error('prescription_final_diagnosis');?> 
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