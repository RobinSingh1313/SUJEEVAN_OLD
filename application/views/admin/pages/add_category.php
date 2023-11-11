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
    <form method="POST" <?php if(empty($edit_category)){?> action="<?php echo base_url('admin/save-category');?>" <?php }else{ ?> action="<?php echo base_url('admin/update-category/'.base64_encode($edit_category[0]->mcim_id));?>" <?php } ?> class="col s12">
        <?php
        if(!empty($this->session->flashdata('flash'))){
            echo $this->session->flashdata('flash');
            unset($_SESSION['flash']);
        }
        ?>
      <div class="row">
        <div class="input-field col s6">
            <p for="first_name">Name of the Category *</p>
          <input onkeyup="return check_invalid_chars(this.value);" id="mcim_name" value="<?php if(empty($edit_category)){ echo $post_data[0]; }else{ echo $edit_category[0]->mcim_name; }?>" name="mcim_name" type="text" class="validate" required>
          
          <p style="color:red;"><?php echo form_error('mcim_name');?></p>
        </div>

        <div class="input-field col s6">
            <p for="first_name">Do you want to display in website *</p>
          <select class="form-control" name="mcim_status" required>
            <option value="">Select Option</option>
            <option <?php if(empty($edit_category)){ if($post_data[2]==1){ echo "selected"; } }else{ if($edit_category[0]->mcim_status==1){ echo "selected"; } }?> value="1">Yes</option>
            <option <?php if(empty($edit_category)){ if($post_data[2]==2){ echo "selected"; } }else{ if($edit_category[0]->mcim_status==2){ echo "selected"; } }?> value="2">No</option>
          </select>
          <p style="color:red;"><?php echo form_error('mcim_status');?></p>
        </div>
        
      </div>
      
       <div class="input-field col s12">
          <button type="submit" class="waves-effect waves-light btn">Submit</button>
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

<script type="text/javascript">
  function check_invalid_chars(value)
  {
    var filter1 = value.includes("%");
    var filter2 = value.includes(";");
    if(filter1==true || filter2==true)
    {
      alert("Invalid Characters in input....");
      document.getElementById("mcim_name").value = '';
    }
    else
    {
      return true;
    }
  }
</script>