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
     <div class="card-header bg-info">
                        <h5 class="m-b-0 text-white">Update User</h5></div>
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Sujeevan-Admin/Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo base_url('Sujeevan-Admin/users');?>">User</a></li>
                <li class="breadcrumb-item active">Update User</li>
            </ol>
        </div>
    </div>
 </div>
</div>

     <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <?php  if($cr == '1'){?>
                    <h5 class="card-title ">Update User</h5>
                       <form action="" method="post" class="validform forms-sample" id="user" novalidate="">
                            <?php $this->load->view("success_error");?>
                            <div class="form-group">
                               <label>User Name<span class="required text-danger">*</span></label>
                                 <input name="user_name" type="text" class="form-control user_name" placeholder="User Name" value="<?php echo $view['login_name'];?>" required="" minlength="3" maxlength="50"/>
                                    <?php echo form_error('user_name');?>
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required text-danger">*</span></label>
                                <input name="email" type="text" class="form-control email" placeholder="Email" value="<?php echo $view['login_email'];?>" required="" minlength="3" maxlength="50"/>
                                <?php echo form_error('email');?>
                            </div>
                            <div class="form-group">
                                <label>Password<span class="required text-danger">*</span></label>
                                <input name="password" type="password" class="form-control password" placeholder="Enter Password" value="<?php echo base64_decode($view['login_password']);?>" required=""  autocomplete="off" />
                                <?php echo form_error('password');?>
                            </div>
                            <div class="form-group">
                                <label>Role<span class="required text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    <option value="">Select role</option>
                                    <?php
                                    foreach($role as $r){ 
                                    if($r->ut_id==$view['login_type']){
                                    ?>
                                        <option value="<?php echo $r->ut_id;?>" selected><?php echo $r->ut_name;?></option>
                                    <?php    
                                    }else{
                                    ?>
                                        <option value="<?php echo $r->ut_id;?>"><?php echo $r->ut_name;?></option>
                                    <?php } }
                                    ?>
                                </select>
                                <?php echo form_error('role');?>
                            </div>
                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-custon-rounded-three btn-success" name="submit" value="submit"> Submit</button>
                                    </div>
                        </form>
                 <?php  } ?>
             </div>
       </div>
    </div>
        