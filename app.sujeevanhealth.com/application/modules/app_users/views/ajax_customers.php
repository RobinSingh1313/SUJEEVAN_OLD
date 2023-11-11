<?php
$sr     =   $this->session->userdata("active-deactive-module");
$ur     =   $this->session->userdata("update-module");
$ct     =   "0";
if($ur  == 1 || $sr == 1){
        $ct     =   1;
}
?>
<div class="table-responsive"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>`
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Name <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_age" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Age <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_email" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Email <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_gender" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Gender <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_mobile" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Mobile <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th>Location</th>
                <th>Installed Date</th>
                <th>Telecaller assign</th>
                <th>Doctor assign</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="register_acde" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                $condition['columns'] = "login_id,login_name";
                $condition['whereCondition'] = "ut_id = '5utype'";
                $telecallers = $this->users_model->view_user($condition);
                $condition['whereCondition'] = "ut_id = '6utype'";
                $doctors = $this->users_model->view_user($condition);
                
                foreach($view as $ve){
                    $registration_id  =   $ve["registration_id"];
                    $vad        =   ucwords($ve["register_acde"]);
                    if($vad == "Active"){
                        $icon   =   "times-circle";
                        $vadv   =   "Deactive";
                        $textico    =   "text-warning";
                        $vdata  =   "<label class='label label-success'>".$vad."</label>";
                    }else{
                        $vdata  =   "<label class='label  label-danger'>".$vad."</label>";
                        $vadv   =   "Active";
                        $textico    =   "text-primary";
                        $icon       =   "check-circle";
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve["register_name"];?></td>
                <td><?php echo $ve["register_age"];?></td>
                <td><?php echo $ve["register_email"];?></td>
                <td><?php echo $ve["register_gender"];?></td>
                <td><?php echo $ve["register_mobile"];?></td>
                <td><?php echo $ve["register_address"];?></td>
                <td><?php echo $ve["register_created_on"];?></td>
                <td>
                    <select class="form-control" onchange="statusupdate($(this))" url_v="<?php echo 'Assign-Telecaller';?>" user_id="<?php echo $ve["registration_id"];?>">
                        <option value="">Select Telecaller</option>
                        <?php if(is_array($telecallers) && count($telecallers)>0){
                            foreach($telecallers as $t){ ?>
                                <option value="<?php echo $t->login_id;?>" <?php if($ve["assigned_telecaller"]==$t->login_id){ echo 'selected';} ?>><?php echo $t->login_name;?></option>
                           <?php }
                        }
                            
                        ?>
                    </select>
                </td>
                <td>
                    <select class="form-control" onchange="statusupdate($(this))" url_v="<?php echo 'Assign-Doctor';?>" user_id="<?php echo $ve["registration_id"];?>">
                        <option value="">Select Doctor</option>
                        <?php if(is_array($doctors) && count($doctors)>0){
                            foreach($doctors as $d){ ?>
                                <option value="<?php echo $d->login_id;?>" <?php if($ve["assigned_doctor"]==$d->login_id){ echo 'selected';} ?>><?php echo $d->login_name;?></option>
                           <?php }
                        }
                            
                        ?>
                    </select>
                </td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Register-Active')" fields="<?php echo $registration_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <!--<a href='<?php echo adminurl("Update-Register/".$registration_id);?>' data-toggle='tooltip-primary' title="Update Register" class="text-success tip-left"><i class="fa fa-edit m-r-5"></i></a>-->
                    <?php } ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Registers are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>