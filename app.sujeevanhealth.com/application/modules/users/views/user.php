<?php
$cr     =   $this->session->userdata("create-users");
$ur     =   $this->session->userdata("update-users");
$dr     =   $this->session->userdata("delete-users");
$ct     =   "0";
if($ur  == 1 || $dr == '1'){
        $ct     =   1;
}
?>

<div class="container-fluid">
 <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">User</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Sujeevan-Admin/Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
        </div>
    </div>
 </div>
</div>
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class='col-lg-12 col-md-12'>
                <?php $this->load->view("success_error");?>
            </div>
            <?php if($cr == '1'){?>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h5 class="m-b-0 text-white">Add User</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="validform forms-sample" id="user" novalidate="">
                            <div class="form-group">
                                <label>User Name<span class="required text-danger">*</span></label>
                                <input name="user_name" type="text" class="form-control user_name" placeholder="User Name" value="<?php echo set_value('user_name');?>" required="" minlength="3" maxlength="50" autocomplete="off"/>
                                <?php echo form_error('user_name');?>
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required text-danger">*</span></label>
                                <input name="email" type="text" class="form-control email" placeholder="Email" value="<?php echo set_value('email');?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('email');?>
                            </div>
                            <div class="form-group">
                                <label>Password<span class="required text-danger">*</span></label>
                                <input name="password" type="password" class="form-control password" placeholder="Enter Password" value="<?php echo set_value('password');?>" required=""  autocomplete="off" />
                                <?php echo form_error('password');?>
                            </div>
                            <div class="form-group">
                                <label>Role<span class="required text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    <option value="">Select role</option>
                                    <?php
                                    foreach($role as $r){ ?>
                                        <option value="<?php echo $r->ut_id;?>"><?php echo $r->ut_name;?></option>
                                    <?php }
                                    ?>
                                </select>
                                <?php echo form_error('role');?>
                            </div>
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-custon-rounded-three btn-success" name="submit" value="submit"> Submit</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <?php $this->load->view("viewfile");?>
                <!--<div class="card">-->
                <!--    <div class="card-header bg-success">-->
                <!--        <h5 class="m-b-0 text-white">Users List</h5>-->
                <!--    </div>-->
                <!--    <div class="card-body">-->
                <!--        <div class="row form-group">-->
                <!--            <div class="col-md-2">-->
                <!--                <select class="form-control limitvalue" onchange="searchFilter('','<?php echo base_url('Sujeevan-Admin/viewUser/');?>')">-->
                                    <?php /*$climit    =   $this->config->item("limit_values");
                                    foreach($climit as $ce){
                                    ?>
                                    <option value="<?php echo $ce;?>"><?php echo $ce;?></option>
                                    <?php
                                    }*/
                                    ?>
                <!--                </select>-->
                <!--            </div>  -->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="text" id="FilterTextBox" name="FilterTextBox" class="form-control" placeholder="Search" onkeyup="searchFilter('','<?php echo base_url('Sujeevan-Admin/viewUser/');?>')">-->
                <!--               <input type="hidden" id="orderby" name="orderby" value="">-->
                <!--               <input type="hidden" id="urlvalue" name="urlvalue" value="">-->
                <!--               <input type="hidden" id="tipoOrderby" name="tipoOrderby" value="">-->
                <!--            </div> -->
                <!--        </div>-->
                <!--        <div class="row port postList">-->
                <!--            <?php $this->load->view("ajax_user");?>                        -->
                <!--            <?php echo $this->ajax_pagination->create_links();?>-->
                <!--        </div>-->
                <!--     </div>-->
                <!--</div>  -->
            </div>                        
        </div>          
    </div>
</div>
      