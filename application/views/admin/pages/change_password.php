<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php $this->load->view('admin/includes/utilities/page-title');?>
    <?php $this->load->view('admin/includes/styles/google-material-font-api.css.php');?>
    <?php $this->load->view('admin/includes/styles/materialize.min.css.php');?>
    <?php $this->load->view('admin/includes/styles/bootstrap.css.php');?>
    <?php $this->load->view('admin/includes/styles/font-awesome.css.php');?>
    <?php $this->load->view('admin/includes/styles/custom-styles.css.php');?>
</head>

<body>
    <div id="wrapper">
        <?php $this->load->view('admin/includes/navbar');?>
        <?php $this->load->view('admin/includes/dropdown-structure');?>
        <?php $this->load->view('admin/includes/sidebar');?>
        <div id="page-wrapper">
          <?php $this->load->view('admin/includes/utilities/breadcrumbs');?>
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
             <div class="card">
                        
                        <div class="card-content">
    <form method="POST" action="<?php echo base_url('admin/update-password');?>" class="col s12">
        <?php
        if(!empty($this->session->flashdata('flash'))){
            echo $this->session->flashdata('flash');
            unset($_SESSION['flash']);
        }
        ?>
      <div class="row">
        <div class="input-field col s12">
            <p for="first_name">Old Password *</p>
          <input  id="first_name" value="<?php echo set_value('alcm_old_password');?>" name="alcm_old_password" type="password" class="validate" required>
          
          <p style="color:red;"><?php echo form_error('alcm_old_password');?></p>
        </div>
        <div class="input-field col s12">
            <p for="first_name">New Password *</p>
          <input id="last_name" value="<?php echo set_value('alcm_new_password');?>" name="alcm_new_password" type="password" class="validate" required>
          
          <p style="color:red;"><?php echo form_error('alcm_new_password');?></p>
        </div>
         <div class="input-field col s12">
            <p for="first_name">Confirm Password *</p>
          <input id="last_name" value="<?php echo set_value('alcm_confirm_password');?>" name="alcm_confirm_password" type="password" class="validate" required>
          
          <p style="color:red;"><?php echo form_error('alcm_confirm_password');?></p>
        </div>
        <div class="input-field col s12">
          <button type="submit" class="waves-effect waves-light btn">Submit</button>
        </div>
      </div>
    </form>
    <div class="clearBoth"></div>
  </div>
    </div>
 </div>
                    
                    
                    
                

                
               </div>
                <?php $this->load->view('admin/includes/footer');?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <?php $this->load->view('admin/includes/scripts/jquery-1.10.2.js.php');?>
    <?php $this->load->view('admin/includes/scripts/bootstrap.min.js.php');?>
    <?php $this->load->view('admin/includes/scripts/materialize.min.js.php');?>
    <?php $this->load->view('admin/includes/scripts/jquery.metisMenu.js.php');?>
    <?php $this->load->view('admin/includes/scripts/custom-scripts.js.php');?>
</body>
</html>