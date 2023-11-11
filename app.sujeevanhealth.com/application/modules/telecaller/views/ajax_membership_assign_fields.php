<?php $id = $this->input->post('id'); 

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
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
        <div class="form-group">
            <select class="form-control" name="vendor_selected[<?php echo $id;?>]" required id="vendor_list<?php echo $id;?>"  onchange="update_doctor_select('<?php echo $id;?>');$('#specialization_id<?php echo $id;?>').val('');">
                <option value="">Select Vendor</option>
                <?php
                if(is_array($vendors) && count($vendors)>0){
                foreach($vendors as $d){
                        $vendorid = $d["vendor_id"];
                        $name = $d["vendor_name"];
                        echo '<option value="'.$vendorid.'">'.$name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
        <div class="form-group">
            <input type="date" class="form-control" name="vendor_date[<?php echo $id;?>]"  max="<?php echo date("Y-m-d",strtotime($this->input->post('last_date')));?>" min="<?php echo date("Y-m-d");?>"  required placeholder="Enter No of Days assigned"/>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
        <div class="form-group">
            <select class="form-control pd-y-12" id="specialization_id<?php echo $id;?>" name="specialization_id[<?php echo $id;?>]" onchange="update_doctor_select('<?php echo $id;?>')">
                <option value="">Select Specialization</option>
                <?php  
                foreach($specialization as $s){ ?>
                    <option value="<?php echo $s->specialization_id; ?>" ><?php echo $s->specialization_name; ?></option>
                <?php }  ?>
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
        <div class="form-group">
            <select class="form-control pd-y-12" id="doctor_list<?php echo $id;?>" name="vendor[<?php echo $id;?>]" required>
                <option value="">Select Vendor</option>
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
        <div class="form-group">
            <input type="number" class="form-control" name="vendor_amount[<?php echo $id;?>]"  placeholder="Enter amount"/>
        </div>
    </div>
     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
        <div class="form-group">
            <select class="form-control" name="time_slot[<?php echo $id;?>]" required>
                <option value="">Select Time Slot</option>
                <?php foreach($times as $t){ ?>
                    <option value="<?php echo $t['time'];?>"><?php echo $t['time'];?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
        <div class="form-group">
            <button class="btn btn-danger" onclick="$(this).closest('.col-lg-12').remove();event.preventDefault();">Remove </button>
        </div>
    </div>
</div>
<hr>