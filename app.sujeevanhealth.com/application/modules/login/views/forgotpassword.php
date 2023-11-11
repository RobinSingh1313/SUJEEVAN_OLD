<h4 class="text-muted font-18 mb-3 text-center">Reset Password</h4>
<?php $this->load->view("success_error");?>
<form role="form" method="post" novalidate="" autocomplete="off" class="mb-lg lginvalidation">
    <div class="form-group">
        <label for="useremail">Email</label>
        <input type="email" class="form-control emailid" id="emailid" name="emailid" placeholder="Enter email">
    </div>
   <button name="submit" value="Login" type="submit" class="btn btn-block btn-success mt-lg">Reset</button>
   <a href="<?php echo base_url();?>" class="btn btn-block btn-info mt-lg">Login</a>
</form>