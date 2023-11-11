
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
                                <label>User Package Valid Upto <span class="required text-danger">*</span></label>
                                <input name="membership_valid_upto" type="date" class="form-control membership_valid_upto" placeholder="Enter membership expiry in days" required="" autocomplete="off" value="<?php echo date("Y-m-d",strtotime($view["membership_valid_upto"]));?>"/>
                                
                                <input name="registration_id" type="hidden" class="form-control registration_id" value="<?php echo $view["membership_register_id"];?>"/>
                                <?php echo form_error('membership_valid_upto');?> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            <h4>Select Vendor Type : </h4> 
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                    <div class="form-group">
                                        <label>Vendor Type</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                    <div class="form-group">
                                        <label>No of Days Vendor assigned</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <label>Vendor amount</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="row" id="append_vendors_data">
                        <?php if($view["membership_assigns"]!=''){ $i=0;
                            foreach(json_decode($view["membership_assigns"]) as $assigned){
                                if(is_array($vendors) && count($vendors)>0){
                                    $output = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                                    <div class="form-group">
                                                        <select class="form-control" name="vendor_selected[]">
                                                            <option value="">Select Vendor</option>';
                                    foreach($vendors as $d){
                                        $id = $d["vendor_id"];
                                        $name = $d["vendor_name"];
                                        $select = '';
                                        if($assigned->vendor_id == $id){
                                            $select = 'selected';
                                        }
                                        $output .='<option value="'.$id.'" '.$select.'>'.$name.'</option>';
                                    }
                                    if($i==0){
                                       $button = '<button class="btn btn-primary" onclick="append_vendors();event.preventDefault();">Add Vendor </button>';
                                       $i++;
                                    }else{
                                       $button = '<button class="btn btn-danger" onclick="$(this).closest(`.col-lg-12`).remove();event.preventDefault();">Remove Vendor </button>'; 
                                    }
                                    $output .= "</select></div></div>";
                                    $output .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" name="vendor_days[]" value="'.$assigned->days.'" required placeholder="Enter No of Days assigned"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" name="vendor_amount[]" value="'.$assigned->amount.'" required placeholder="Enter amount"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                                    <div class="form-group">
                                                    '.$button.'
                                                    </div>
                                                </div></div>';
                                    echo $output;
                                }  
                            }
                            
                        }else{ ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row"> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                    <div class="form-group">
                                        <select class="form-control" name="vendor_selected[]" required>
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
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="vendor_days[]" required placeholder="Enter No of Days assigned"/>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="vendor_amount[]" required placeholder="Enter amount"/>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                                    <div class="form-group">
                                        <button class="btn btn-primary" onclick="append_vendors();event.preventDefault();">Add Vendor </button>
                                    </div>
                                </div>
                            </div>
                        <?php
                        
                        }?>
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