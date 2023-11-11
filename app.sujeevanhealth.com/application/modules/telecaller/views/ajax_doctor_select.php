<option value="">Select Service Provider</option>
<?php  
foreach($doctor as $d){ ?>
    <option value="<?php echo $d->regvendor_id; ?>" <?php if($d->regvendor_id == $this->input->post('doctor_id')){ echo ' selected';} ?>><?php echo $d->regvendor_name.' - '.$d->district_name; ?></option>
<?php } ?>