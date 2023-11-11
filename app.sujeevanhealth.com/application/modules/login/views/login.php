<h4 class="tx-inverse tx-center">Sign In</h4>
<form role="form" method="post" novalidate="" class="mb-lg lginvalidation" autocomplete="off">
    <p class="tx-center mg-b-60">Welcome back my friend! Please sign in.</p>
    <?php $this->load->view("success_error");?> 
    <div class="form-group">
        <input id="exampleInputEmail1" type="text" placeholder="Enter Email / Username" autocomplete="off" name="username" value="<?php echo set_value("username");?>" required class="form-control username text-capitalize">       
        <?php echo form_error('username');?>
    </div>
    <div class="form-group">
        <input id="exampleInputPassword1" type="password" placeholder="Enter Password" name="password" minlength="2" maxlength="50" required class="form-control">
        <?php echo form_error('password');?>
    </div>
    <a href="<?php echo adminurl("Forgot-Password");?>" class="tx-info tx-12 d-block mg-b-10">Forgot password?</a>
    <button name="submit" value="submit" type="submit" class="btn btn-info btn-block">Sign In</button>
</form>