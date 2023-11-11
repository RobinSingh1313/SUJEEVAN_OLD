<?php 
$views = $this->db->query("select membership_valid_upto,membership_register_id from membership_purchase Where membership_purchase_id = '".$this->input->get('membership_purchase_id')."'")->row_array();
$last_date =  $views['membership_valid_upto'];
$start_date = date("Y-m-d");
$daaas = 0;
echo '<input type="hidden" id="last_date" value="'.$last_date.'"/>';
echo '<input type="hidden" id="start_date" value="'.$start_date.'"/>';

$pre_assigne_venarray = json_decode($pre_assigned_vendors['membership_assigns']);

// time slots 
        $time_slot= $this->db->query("select * from  book_appointment_time_slot")->row_array();
        switch ($time_slot['book_appointment_time_type']) {
          case "0":
            $slot = $time_slot['book_appointment_time']." seconds";
            break;
          case "1":
            $slot = $time_slot['book_appointment_time']." minutes";
            break;
          case "2":
            $slot = $time_slot['book_appointment_time']." hours";
            break;
          case "3":
            $slot = $time_slot['book_appointment_time']." days";
            break;
          default:
        }
        $interval = DateInterval::createFromDateString($slot);
        $now = new DateTime(date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"))+60*60));
        
        $begin = new DateTime(date("Y-m-d").'T00:00:00');
        $end = new DateTime(date("Y-m-d").'T23:59:00');
        // DatePeriod won't include the final period by default, so increment the end-time by our interval
        $end->add($interval);
        
        // Convert into array to make it easier to work with two elements at the same time
        $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));
        
        $start = array_shift($periods);
        $times = array();$i=0;
        foreach ($periods as $time) { 
            if(date("Y-m-d") == date("Y-m-d",strtotime($this->input->post('date')))){ $times[$i] =array();
                if($now->format("H:i:s") <=  $start->format('H:i:s') ){
                    $times[$i]['time'] = $start->format('h:iA'). ' - '. $time->format('h:iA');
                    $i++;
                }
            }else{
                    $times[$i]['time'] = $start->format('h:iA'). ' - '. $time->format('h:iA');
                    $i++;
            }
            
            $start = $time;
        }
        
        
        
        
?>
<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="validatform formssample" id="course" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <label>Vendor Type</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <label>Date</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <label>Specialization</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <label>Service Provider</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="row" id="append_vendors_data">
                        <?php 
                        $history=array();
                        if(is_array($view) && count($view)>0 && !empty($pre_assigne_venarray)){ $i=0;
                            foreach($view as $v){ ?>
                            <?php if($v->membership_assign_date_from<date("Y-m-d") || $v->membership_assign_otp_verify == '1'){
                                    $vendor_type = '';$specil='';$doctor_name='';
                                    foreach($vendors as $d){
                                        $id = $d["vendor_id"];
                                        if($id == $v->membership_assign_vendor_type){
                                            $vendor_type = $d["vendor_name"];
                                        }
                                        
                                    }
                                    foreach($specialization as $s){ 
                                        if($s->specialization_id==$v->membership_assign_specialization){
                                            $specil = $s->specialization_name;
                                            
                                        }  
                                    }  
                                    $specc = '';
                                    if($v->membership_assign_specialization!=''){
                                        $specc = "AND  regvendor_specialization='".$v->membership_assign_specialization."'";
                                    }
                                    $doctor = $this->db->query("select regvendor_id,regvendor_name from  register_vendors Where regvendor_vendor_id='".$v->membership_assign_vendor_type."' ".$specc." AND regvendor_open = '1' AND regvendor_acde = 'Active'")->result();
                                    foreach($doctor as $d){
                                        if($d->regvendor_id == $v->membership_assign_vendor){
                                            $doctor_name = $d->regvendor_name;
                                        } 
                                    }
                                    $historyy = array(
                                        "vendor_type"           =>  $vendor_type,
                                        "date"                  =>  $v->membership_assign_date_from,
                                        "specialization"        =>  $specil,
                                        "doctor_name"           =>  $doctor_name,
                                        "status"                =>  $v->membership_assign_status,
                                        "otp_verify"            => ($v->membership_assign_otp_verify == '1')?'Verified':'Not verified',
                                        "membership_assign_id"  => ($v->membership_assign_id)??'',
                                        "medication_id"         => ($v->medication_id)??'',
                                        "investigation_id"      => ($v->investigation_id)??'',
                                        
                                    );
                                    array_push($history,$historyy);
                                        
                                }else{?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control" name="vendor_selected[<?php echo $i;?>]" required id="vendor_list<?php echo $i;?>"  onchange="update_doctor_select('<?php echo $i;?>');$('#specialization_id<?php echo $i;?>').val('');">
                                            <option value="">Select Vendor</option>
                                            <?php
                                            if(is_array($vendors) && count($vendors)>0){
                                            foreach($vendors as $d){
                                                                $id = $d["vendor_id"];
                                                                $name = $d["vendor_name"];
                                                                $selected = '';
                                                                if($id == $v->membership_assign_vendor_type){
                                                                    $selected = 'selected';
                                                                }
                                                                echo '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                                                            }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="vendor_date<?php echo $i;?>" name="vendor_date[<?php echo $i;?>]" value="<?php echo $v->membership_assign_date_from;?>" max="<?php echo date("Y-m-d",strtotime($last_date));?>" min="<?php echo date("Y-m-d");?>" required placeholder="Enter No of Days assigned"/>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control pd-y-12" id="specialization_id<?php echo $i;?>" name="specialization_id[<?php echo $i;?>]" onchange="update_doctor_select('<?php echo $i;?>')">
                                            <option value="">Select Specialization</option>
                                            <?php  
                                            foreach($specialization as $s){ ?>
                                                <option value="<?php echo $s->specialization_id; ?>" <?php if($s->specialization_id==$v->membership_assign_specialization){echo 'selected';} ?>><?php echo $s->specialization_name; ?></option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control pd-y-12" id="doctor_list<?php echo $i;?>" name="vendor[<?php echo $i;?>]" required onchange="get_doctor_timeslot('<?php echo $ni; ?>')">
                                            <option value="">Select Service Provider</option>
                                            <?php
                                            $specc = '';
                                            if($v->membership_assign_specialization!=''){
                                                $specc = "AND  regvendor_specialization='".$v->membership_assign_specialization."'";
                                            }
                                            $doctor = $this->db->query("select regvendor_id,regvendor_name from  register_vendors Where regvendor_vendor_id='".$v->membership_assign_vendor_type."' ".$specc." AND regvendor_open = '1' AND regvendor_acde = 'Active'")->result();
                                            foreach($doctor as $d){ ?>
                                                <option value="<?php echo $d->regvendor_id; ?>" <?php if($d->regvendor_id == $v->membership_assign_vendor){ echo ' selected';} ?>><?php echo $d->regvendor_name.' - '.$d->district_name; ?></option>
                                            <?php } 
                                            ?>
                                        </select>
                                        <input type="hidden" class="form-control" name="otp[<?php echo $i;?>]" value="<?php echo $v->membership_assign_otp;?>"/>
                                        <input type="hidden" class="form-control" name="assign_id[<?php echo $i;?>]" value="<?php echo $v->membership_assign_id;?>"/>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="vendor_amount[<?php echo $i;?>]" placeholder="Enter amount"/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                    <div class="form-group">
                                        <select class="form-control" name="time_slot[<?php echo $i;?>]">
                                            <option value="">Select Time Slot</option>
                                            <?php foreach($times as $t){ ?>
                                                <option value="<?php echo $t['time'];?>" <?php if(date("h:iA",strtotime($v->time_from))." - ".date("h:iA",strtotime($v->time_to)) == $t['time']){echo 'selected';}?>><?php echo $t['time'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if($i==0){
                                   $button = '<button class="btn btn-primary" data-value="'.(count($view)-1).'" id="total_countn" onclick="append_membership_assign_feilds($(this));event.preventDefault();">Add More </button>';
                                }else{
                                   $button = '<button class="btn btn-danger" onclick="remove_ven($(this))">Remove </button>'; 
                                }
                                ?>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <?php echo $button;?>
                                    </div>
                                </div>
                            </div>
                            <?php  $i++; $daaas = 1;}  } ?>
                         <?php   
                        }else if(!empty($pre_assigne_venarray)){ 
                            $ni = 0;
                            foreach($pre_assigne_venarray as $pre_assigne_venarr){
                                $doctors_list = $this->db->query("select rv.regvendor_id,regvendor_name,district_name from register_vendors as rv 
                                LEFT JOIN district as d ON d.district_id = rv.regvendor_city 
                                Where regvendor_vendor_id='".$pre_assigne_venarr->vendor_id."' 
                                AND regvendor_open = '1' AND regvendor_acde = 'Active'")->result();
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control" name="vendor_selected[<?php echo $ni; ?>]" required id="vendor_list<?php echo $ni; ?>"  onchange="update_doctor_select('<?php echo $ni; ?>');$('#specialization_id'+<?php echo $ni; ?>).val('');">
                                            <option value="">Select Vendor</option>
                                            <?php
                                            if(is_array($vendors) && count($vendors)>0){
                                            foreach($vendors as $d){
                                                
                                                                $id = $d["vendor_id"];
                                                                $name = $d["vendor_name"];
                                                                if($pre_assigne_venarr->vendor_id==$id){
                                                                    $selected_str = 'selected="selected"';
                                                                } else {
                                                                    $selected_str = '';
                                                                }
                                                                echo '<option value="'.$id.'" '.$selected_str.'>'.$name.'</option>';
                                                            }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="vendor_date[<?php echo $ni; ?>]" id="vendor_date<?php echo $ni; ?>"  max="<?php echo date("Y-m-d",strtotime($last_date));?>" min="<?php echo date("Y-m-d");?>" required placeholder="Enter No of Days assigned"/>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control pd-y-12" id="specialization_id<?php echo $ni; ?>" name="specialization_id[<?php echo $ni; ?>]" onchange="update_doctor_select('<?php echo $ni; ?>')">
                                            <option value="">Select Specialization</option>
                                            <?php  
                                            foreach($specialization as $s){ ?>
                                                <option value="<?php echo $s->specialization_id; ?>" <?php if($s->specialization_id=='sdfg'){echo 'selected';} ?>><?php echo $s->specialization_name; ?></option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control pd-y-12" id="doctor_list<?php echo $ni; ?>" name="vendor[<?php echo $ni; ?>]" required onchange="get_doctor_timeslot('<?php echo $ni; ?>')">
                                            <option value="">Select Service Provider</option>
                                            <?php
                                            foreach($doctors_list as $doctors_li){ ?>
                                                <option value="<?php echo $doctors_li->regvendor_id; ?>"><?php echo $doctors_li->regvendor_name.' - '.$doctors_li->district_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="vendor_amount[<?php echo $ni; ?>]"  placeholder="Enter amount" value="<?php echo $pre_assigne_venarr->amount; ?>"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                                    <div class="form-group">
                                        <select class="form-control" name="time_slot[<?php echo $ni; ?>]" id="time_slot<?php echo $ni; ?>">
                                            <option value="">Select Time Slot</option>
                                        </select>
                                    </div>
                                </div>
                                <!--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> -->
                                <!--    <div class="form-group">-->
                                <!--        <button class="btn btn-primary" data-value="0" onclick="append_membership_assign_feilds($(this));event.preventDefault();">Add More </button>-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>
                            <?php
                            $ni++; } 
                            $daaas = 1;    
                        } else {
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control" name="vendor_selected[0]" required id="vendor_list0"  onchange="update_doctor_select('0');$('#specialization_id0').val('');">
                                            <option value="">Select Vendor</option>
                                            <?php
                                            if(is_array($vendors) && count($vendors)>0){
                                            foreach($vendors as $d){
                                                                $id = $d["vendor_id"];
                                                                $name = $d["vendor_name"];
                                                                echo '<option value="'.$id.'">'.$name.'</option>';
                                                            }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="vendor_date[0]"  max="<?php echo date("Y-m-d",strtotime($last_date));?>" min="<?php echo date("Y-m-d");?>" required placeholder="Enter No of Days assigned"/>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control pd-y-12" id="specialization_id0" name="specialization_id[0]" onchange="update_doctor_select('0')">
                                            <option value="">Select Specialization</option>
                                            <?php  
                                            foreach($specialization as $s){ ?>
                                                <option value="<?php echo $s->specialization_id; ?>" <?php if($s->specialization_id=='sdfg'){echo 'selected';} ?>><?php echo $s->specialization_name; ?></option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <select class="form-control pd-y-12" id="doctor_list0" name="vendor[0]" required>
                                            <option value="">Select Vendor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="vendor_amount[0]"  placeholder="Enter amount"/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                    <div class="form-group">
                                        <select class="form-control" name="time_slot[0]">
                                            <option value="">Select Time Slot</option>
                                            <?php foreach($times as $t){ ?>
                                                <option value="<?php echo $t['time'];?>" ><?php echo $t['time'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <button class="btn btn-primary" data-value="0" onclick="append_membership_assign_feilds($(this));event.preventDefault();">Add More </button>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <div class="form-actions form-group">
                                <input name="registration_id" type="hidden" class="form-control registration_id" value="<?php echo $views["membership_register_id"];?>"/>
                                <button type="submit" class="btn btn-sm btn-success" name="submit" value="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
                <h5>History:</h5>
                <div class="row">
                    <?php foreach($history as $h){  ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <p>Vendor Type : <?php echo $h['vendor_type'];?></p>
                        <p>Date : <?php echo $h['date'];?></p>
                        <p>specialization : <?php echo $h['specialization'];?></p>
                        <p>Vendor Name : <?php echo $h['doctor_name'];?></p>
                        <p>Status : <?php echo $h['status'];?></p>
                        <p>OTP  : <?php echo $h['otp_verify'];?></p>
                        <?php if($h['membership_assign_id']){
                                echo '<p><a href="'.adminurl('Investigation?membership_assign_id='.$h['membership_assign_id']).'" target="_blank">Investigation</a></p>';
                            if($h['medication_id']){
                                echo '<p><a href="'.adminurl('Medication?membership_assign_id='.$h['membership_assign_id']).'">Mediaction</a></p>';
                            }
                            
                        }
                        ?>
                    <hr>
                    </div>
                    <?php } ?>
                    
                    
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div> 

<script>
    function remove_ven(evt){
       evt.closest(`.col-lg-12`).remove();
       event.preventDefault();
       var countt = parseInt($('#total_countn').attr('data-value'));
       $('#total_countn').attr('data-value',countt-1);
    }
    
    function get_doctor_timeslot(key_val){
        var sel_doctor_id = $('#doctor_list'+key_val).val();
        var sel_date_val = $('#vendor_date'+key_val).val();
        var adminurl    = '/Sujeevan-Admin';
        if(sel_doctor_id!='' && sel_date_val!=''){
            $.ajax({
                type    :   'POST',
                url     :   adminurl+"/check_doctor_timeslot",
                data:{ sel_doctor_id:sel_doctor_id, sel_date_val:sel_date_val },
                success: function (htmldata) { 
                   $('#time_slot'+key_val).html(htmldata);
                }
            });
        } else {
            $('#doctor_list'+key_val).val('');
            $('#time_slot'+key_val).html('<option value="">Select Time Slot</option>');
            $('#vendor_date'+key_val).html('');
            alert("Please select date");
            return false;
        }
    }
</script>