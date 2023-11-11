<?php 
    $dl         = 'Required';
    $lpl        = '';
    $fname      =   ($view["user_package_image"])??'';
    $target_dir =   $this->config->item("upload_dest")."user_package/";
    $oml        =   $quotation_image    =   base_url()."uploads/image_not_available.png";
    $filename   =   $_SERVER['DOCUMENT_ROOT'].'/'.$target_dir.'/'.$fname;
    if (file_exists($filename)) {
        $dl         = '';
        $oml   	=   base_url().$target_dir.'/'.$fname;
      	$lpl	=	'<img src="'.$oml.'" class="img img-responsive"/>';
    }
    $sel_module_id = !empty($this->input->get('moduleid'))?$this->input->get('moduleid'):'';
    $history_id = !empty($this->input->get('history_id'))?$this->input->get('history_id'):'';
    $response = $this->db->query("select homecare_chat_responseid,list_of_answers,submodule_id FROM homecare_chat_response 
                    WHERE homecare_chat_responseid='".$history_id."'
                    ORDER BY homecare_chat_responseid DESC")->row_array();
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
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Select Package<span class="required text-danger">*</span></label>
                                <select class="form-control pd-y-12" name="membership_id" id="membership_id" required onchange="get_package_data()">
                                    <option value="">Select Package</option>
                                    <?php 
                                    foreach($membership as $m){ ?>
                                        <option value="<?php echo $m->membership_id; ?>" <?php if(!empty($view["membership_id"]) && $view["membership_id"]==$m->membership_id){ echo 'selected'; } ?>><?php echo $m->membership_name; ?></option>
                                    <?php } ?>
                                </select> 
                             </div><!-- form-group -->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Module<span class="required text-danger">*</span></label>
                                <select class="form-control pd-y-12" name="module_id" id="module_id" onchange="getsubmoduleSelect()" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    foreach($module as $m){ ?>
                                        <option value="<?php echo $m->moduleid; ?>" <?php if($sel_module_id==$m->moduleid){ echo 'selected'; } ?>><?php echo $m->module_name; ?></option>
                                    <?php } ?>
                                </select> 
                             </div><!-- form-group -->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>Sub Module</label>
                                <input type="hidden" id="sub_module_id" value="<?php echo $response['submodule_id'];?>">
                                <select class="form-control pd-y-12" name="homecare_category" id="submodule">
                                    <option value="">Select Sub Module</option>
                                    <?php 
                                    foreach($sub_module as $s){ ?>
                                        <option value="<?php echo $s->sub_module_id ?>"><?php echo $s->sub_module_name ?></option>
                                    <?php } ?>
                                </select> 
                             </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Package Name<span class="required text-danger">*</span></label>
                                <input name="user_packagenametype" type="text" class="form-control" placeholder="Enter User Package Name" required autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["user_package_name"]:set_value("user_packagenametype");?>"/>
                                <?php echo form_error('user_packagenametype');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Package Price <span class="required text-danger">*</span></label>
                                <input name="user_package_price" type="number" step="0.01" class="form-control user_package_price" placeholder="Enter User Package Price" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["user_package_price"]:set_value("user_package_price");?>"/>
                                <?php echo form_error('user_package_price');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Package Price (after discount) <span class="required text-danger">*</span></label>
                                <input name="user_package_after_disc" type="number" step="0.01" class="form-control user_package_after_disc" placeholder="Enter user_package price after discount" required="" autocomplete="off" value="<?php echo (is_array($view) && count($view) > 0)?$view["user_package_after_disc"]:set_value("user_package_after_disc");?>"/>
                                <?php echo form_error('user_package_after_disc');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>User Package expiry in days <span class="required text-danger">*</span></label>
                                <input name="user_package_days" type="number" class="form-control user_package_days" placeholder="Enter user_package expiry in days" required="" autocomplete="off" value="<?php echo ($view["user_package_days"])??'';?>"/>
                                <?php echo form_error('user_package_days');?> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <label>About <span class="required text-danger">*</span></label>
                                <input name="registration_id" type="hidden" value="<?php echo ($this->input->get('user_id'))??$view["registration_id"];?>"/>
                                <textarea name="user_package_about" type="text" class="form-control user_package_about" placeholder="Enter about user_package" required="" autocomplete="off"><?php echo ($view["user_package_about"])??'';?></textarea>
                                <?php echo form_error('user_package_about');?> 
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
                        <?php if(!empty($view["user_package_assigns"]) && $view["user_package_assigns"]!=''){ $i=0;
                            foreach(json_decode($view["user_package_assigns"]) as $assigned){
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
                                        <input type="number" class="form-control" name="vendor_amount[]" placeholder="Enter amount"/>
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
<script type="text/javascript">
getsubmoduleSelect();
var sub_module_id = $('#sub_module_id').val();
$('#submodule').val(sub_module_id);
</script>