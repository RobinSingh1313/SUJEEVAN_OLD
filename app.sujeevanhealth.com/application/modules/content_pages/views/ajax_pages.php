<?php
$sr     =   $this->session->userdata("active-deactive-content-page");
$cr     =   $this->session->userdata("create-content-page");
$ur     =   $this->session->userdata("update-content-page");
$dr     =   $this->session->userdata("delete-content-page");
$ct     =   "0";
if($ur  == 1 || $dr == '1' || $sr == 1){
        $ct     =   1;
}
?>
<div class="table-responsive"> 
    <table class="table table-striped table-hover js-basic-example tablehrcover" id="myTable">
        <thead>
            <tr id="filters">
                <th>S.No</th>
                <th><a href="javascript:void(0);" data-type="order" data-field="cpage_title" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Title <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="content_from_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Content <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="layout_name" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Layout <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="cpage_show_menu" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Menu <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <th><a href="javascript:void(0);" data-type="order" data-field="cpage_ac_de" urlvalue="<?php echo $urlvalue;?>" onclick="getdatafiled($(this))">Status <i class="fa font-14 fa-sort-up pull-right"></i></a> </th>
                <?php if($ct == '1'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php  
            if(count($view) > 0){ 
                foreach($view as $ve){
                    $vad    =   ucwords($ve->cpage_ac_de);
                    if($vad == "Active"){
                        $icon   =   "times-circle";
                        $vadv   =   "Deactive";
                        $textico    =   "text-warning";
                        $vdata  =   "<label class='badge abelsctive badge-success'>".$vad."</label>";
                    }else{
                        $vdata  =   "<label class='badge abelsctive badge-danger'>".$vad."</label>";
                        $vadv   =   "Active";
                        $textico    =   "text-primary";
                        $icon   =   "check-circle";
                    }
            ?>
            <tr>
                <td><?php echo $limit++;?></td>
                <td><?php echo $ve->cpage_title;?></td>
                <td><?php echo $ve->content_from_name;?></td>
                <td><?php echo $ve->layout_name;?></td>
                <td>
                    <?php 
                        if($ve->cpage_show_menu == '1'){
                            echo "<label class='label label-info'>Menu</label>";
                        }
                    ?>
                </td>
                <td><?php echo $vdata;?></td>
                <?php if($ct == '1'){?>
                <td> 
                    <?php if($sr == '1'){?>
                    <a class="<?php echo $textico;?>" href="javascript:void(0);" onclick="activeform($(this),'Ajax-Content-Page-Active')" fields="<?php echo $ve->cpage_id;?>" data-toggle='tooltip' title="<?php echo $vadv;?>"><i class="fa fa-<?php echo $icon;?> m-r-5"></i></a>
                    <?php } if($ur == '1'){?>
                    <a href='<?php echo adminurl("Update-Content-Page/".$ve->cpage_id);?>' data-toggle='tooltip' data-original-title="Update Page" class="text-success tip-left"><i class="fa fa-edit m-r-5"></i></a>
                    <?php } if($dr == '1'){?>
                    <a href="javascript:void(0);" onclick="confirmationDelete($(this),'Content Page')"  data-toggle='tooltip' attrvalue="<?php echo adminurl("Delete-Content-Page/".$ve->cpage_id);?>"   data-original-title="Delete Content Page" class="text-danger"><i class="fa fa-trash"></i></a>
                    <?php }  ?>
                </td>
                <?php }  ?>
            </tr>
                <?php
                }
            }else {
                echo '<tr class="text-center text-danger"><td colspan="15"><i class="fa fa-info-circle"></i> Content Pages are  not available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div> 
<?php echo $this->ajax_pagination->create_links();?>