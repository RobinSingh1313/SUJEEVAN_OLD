<?php
$sr     =   $this->session->userdata("active-deactive-banners");
$cr     =   $this->session->userdata("create-users");
$ur     =   $this->session->userdata("update-users");
$dr     =   $this->session->userdata("delete-users");
$ct     =   "0";
if($ur  == 1 || $dr == '1' || $sr == '1'){
        $ct     =   1;
}
?>
<div class="table-responsive-m col-sm-12"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="login_name" urlvalue="<?php echo base_url('Sujeevan-Admin/viewUser/');?>" onclick="getdatafiled($(this))">User Name <i class="fa fa-sort pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="ut_name" urlvalue="<?php echo base_url('Sujeevan-Admin/viewUser/');?>" onclick="getdatafiled($(this))">Role <i class="fa fa-sort pull-right"></i></a> </th>
                <th>Status</th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $login_id       =   $ve->login_id;
                    $vad            =   ucwords($ve->login_acde);
                    if($vad == "Active"){
                        $icon       =   "times-circle";
                        $vadv       =   "Deactive";
                        $textico    =   "text-warning";
                        $vdata      =   "<label class='label label-success'>".$vad."</label>";
                    }else{
                        $vdata      =   "<label class='label  label-danger'>".$vad."</label>";
                        $vadv       =   "Active";
                        $textico    =   "text-primary";
                        $icon       =   "check-circle";
                    }   
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve->login_name;?></td>
                <td><?php echo $ve->ut_name;?></td>
                <td><?php echo $vdata; ?></td>
                <?php if($ct == '1'){?>
                <td>
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Login-Users-Active')" fields="<?php echo $login_id;?>" data-toggle='tooltip-primary' vartie="<?php echo $vadv;?>" title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?>"></i></a>
                    <?php } if($ur == '1'){?>
                        <?php if($ve->ut_id === "6utype"){ 
                                    if($this->session->userdata("update-doctor")== '1'){
                        ?>
                            <a href='<?php echo base_url("Sujeevan-Admin/Update-Doctor/".$ve->profile_id);?>' data-toggle='tooltip' title="Update <?php echo $ve->ut_name;?>" class="btn btn-sm btn-success tip-left"><i class="fa fa-edit"></i></a>
                        <?php 
                                    }
                        }else{ ?>
                            <a href='<?php echo base_url("Sujeevan-Admin/update-user/".$ve->login_id);?>' data-toggle='tooltip' title="Update <?php echo $ve->ut_name;?>" class="btn btn-sm btn-success tip-left"><i class="fa fa-edit"></i></a>
                        <?php } ?>
                    <?php } if($dr == '1'){?>
                    <a href="<?php echo base_url("Sujeevan-Admin/delete-user/".$ve->login_id);?>"   title="Delete <?php echo $ve->ut_name;?>" class="btn btn-sm  btn-danger"><i class="fa fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center"><td colspan="5">Users are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>