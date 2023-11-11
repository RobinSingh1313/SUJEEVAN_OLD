<div class="modal-body pd-0 bd">
  <div class="row no-gutters">
    <div class="col-lg-6 bg-primary">
      <div class="pd-40 overflow-auto">
        <?php // if(is_array($chat) && count($chat)){ ?>
        <!--<h4 class="tx-white mg-b-20"><span>[</span> User ChatBot Response <span>]</span></h4>-->
        <!--<p class="tx-white op-7 mg-b-60">-->
            <?php /*
            foreach($chat as $c){
                $dataa = json_decode($c->list_of_answers);
                echo '<b>'.$c->sub_module_name.'</b><br>';
                foreach($dataa as $dd){  
                    echo $dd->question.' - [ '.$dd->option.' ]<br>';
                }
            }*/
            ?>
        <!--</p>-->
        <!--<br>-->
        <?php //} ?>
        <p class="tx-white mg-b-60">
            <?php 
            if(!empty($this->input->post('moduleid')) && !empty($this->input->post('history_id'))){ ?>
                <a href="<?php echo base_url('Sujeevan-Admin/Chatbot?user_id='.$this->input->post('id').'&moduleid='.$this->input->post('moduleid').'&history_id='.$this->input->post('history_id'));?>" target="_blank" class="tx-white">Chatbot</a><br>
            <?php } else { ?>
                <a href="<?php echo base_url('Sujeevan-Admin/Chatbot?user_id='.$this->input->post('id'));?>" target="_blank" class="tx-white">Chatbot</a><br>
            <?php } ?>
            <a href="<?php echo base_url('Sujeevan-Admin/Case-Sheet-History?user_id='.$this->input->post('id'));?>" target="_blank" class="tx-white">Case Sheet</a><br>
            <a href="<?php echo base_url('Sujeevan-Admin/Vital-History?user_id='.$this->input->post('id'));?>" target="_blank" class="tx-white">Vitals</a><br>
            <a href="<?php echo base_url('Sujeevan-Admin/Previous-Reports-History?user_id='.$this->input->post('id'));?>" target="_blank" class="tx-white">Previous Reports</a><br>
        </p>
        
        <?php if(is_array($purchase) && count($purchase)){ ?>
        <h4 class="tx-white mg-b-20"><span>[</span> Purchase History <span>]</span></h4>
        
            <?php $i=1;
            foreach($purchase as $p){
                $dat = json_decode($p->membership_payment_response);?>
                <p class="tx-white mg-b-60">
                <a href='<?php echo adminurl("Membership-Purchase?membership_purchase_id=".$p->membership_purchase_id);?>' data-toggle='tooltip-primary' title="Update User Package"  target="_blank" class="float-right tx-white"><i class="fa fa-edit m-r-5 tx-white"></i>Edit</a><br>
                <a href='<?php echo adminurl("Assign-Membership?membership_purchase_id=".$p->membership_purchase_id.'&moduleid='.$this->input->post('moduleid').'&history_id='.$this->input->post('history_id'));?>' data-toggle='tooltip-primary' title="Update User Package"  target="_blank" class="float-right tx-white"><i class="fa fa-edit m-r-5 tx-white"></i>Schedule</a><br>
                <?php  echo '<b>'.$i.') '.$p->user_package_name.'</b><br>';
                echo 'Module : '.$p->sub_module_name.'<br>';
                echo 'Amount Paid : '.$p->membership_amount.'<br>';
                echo 'Valid Upto : '.date("d-M-Y",strtotime($p->membership_valid_upto)).'<br>';
                echo 'Package Details : '.$p->membership_benfits.'<br>';
                ?>
                <div class="form-group">
                    <h5 class="tx-white">Update health condition : </h5>
                    <textarea class="form-control mg-b-10" id="update_health<?php echo $p->membership_purchase_id;?>" placeholder="Enter health condition"><?php echo $p->health_condition;?></textarea>
                    <h5 class="tx-white">Update Address : </h5>
                    <textarea class="form-control mg-b-10" id="update_address<?php echo $p->membership_purchase_id;?>" placeholder="Enter Address"><?php echo $p->visit_address;?></textarea>
                    <button class="btn btn-oblong btn-success btn-block mg-b-10" onclick="update_health_condition('<?php echo $p->membership_purchase_id;?>');event.preventDefault();">Update</button>
                </div>
                </p><hr class="tx-white" style="border-block-color: white;"/>
                <?php $i++;
            }
            ?>
        </p>
        <p>
            <?php 
            // $title = 'test care';
            // $message = 'test message';
            // $id = '97USR';
            // $push_type = 'Vendor';
            // $e = $this->common_config->send_notifications($title,$message,$id,$push_type);
            // print_r($e);
            /*$arr['topic']='Appointment meet by sujeevann';
            $arr['start_date']=date("Y-m-d H:i:s",strtotime("+2 day"));
            $arr['duration']=30;
            $arr['password']='sujeevan';
            $arr['type']='2';
            $result=$this->zoom_meet->deleteMeeting('84516733093');
            if(isset($result->id)){
                echo '<pre>';
            	print_r($result);
            	echo '</pre>';
            	echo "Meet Id: <a href='".$result->join_url."'>".$result->id."</a><br/>";
            	echo "Join URL: <a href='".$result->join_url."'>".$result->join_url."</a><br/>";
            	echo "Password: ".$result->password."<br/>";
            	echo "Start Time: ".$result->start_time."<br/>";
            	echo "Duration: ".$result->duration."<br/>";
            }else{
            	echo '<pre>';
            	print_r($result);
            	echo '</pre>';
            }*/
            
            ?>
        </p>
        <?php } ?>
      </div>
    </div><!-- col-6 -->
    <div class="col-lg-6 bg-white"> 
      <div class="pd-30">
        <button type="button" class="close" onclick="$('#modaldemo6').modal('hide');" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="pd-x-30 pd-y-10">
          <div class="form-group">
            <label> <b> Available Packages :</b><br> </label>
            <table  class="table">
                 <?php 
                if(!empty($this->input->post('moduleid')) && !empty($this->input->post('history_id'))){ ?>
                    <tr>
                        <th></th>
                        <th> <a href="<?php echo base_url('Sujeevan-Admin/User-Package?user_id='.$this->input->post('id').'&moduleid='.$this->input->post('moduleid').'&history_id='.$this->input->post('history_id'));?>" target="_blank" class="float-right">Create Package</a></th>
                    </tr>
                <?php } ?>
                <?php
                if(is_array($user_package) && count($user_package)>0){
                    foreach($user_package as $u){ ?>
                     <tr>
                        <td><?php echo $u->user_package_name;?></td>
                        <td><a href='<?php echo adminurl("User-Package?id=".$u->user_package_id);?>' data-toggle='tooltip-primary' title="Update User Package" class="text-success tip-left"  target="_blank"><i class="fa fa-edit m-r-5"></i></a></td>
                    </tr>
                  <?php }
                }else{?>
                     <tr>
                        <td colspan="2">No packages available</td>
                    </tr>
                  <?php
                    
                }
                
                ?>
                
            </table>
          </div><!-- form-group -->
        </div>
        <div id="update_response">
        </div>
        
      </div><!-- pd-20 -->
    </div><!-- col-6 -->
  </div><!-- row -->
</div><!-- modal-body -->
<script>
        <?php if(is_array($purchase) && count($purchase)){ 
                foreach($purchase as $p){ ?>
                    update_doctor_select('<?php echo $p->membership_purchase_id;?>');
        <?php } } ?>
</script>