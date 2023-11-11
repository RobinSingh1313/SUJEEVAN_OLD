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
    <form enctype="multipart/form-data" method="POST" <?php if(empty($edit_post)){?> action="<?php echo base_url('admin/save-post');?>" <?php }else{ ?> action="<?php echo base_url('admin/update-post/'.base64_encode($edit_post[0]->mcdp_id));?>" <?php } ?> class="col s12">
        <?php
        if(!empty($this->session->flashdata('flash'))){
            echo $this->session->flashdata('flash');
            unset($_SESSION['flash']);
        }
        ?>
      <div class="row">
        <div class="input-field col s6">
            <p for="first_name">Category *</p>
          <select onchange="getsubcategories(this.value);" class="form-control" name="mcdp_category_id" required>
            <option value="">Select Category</option>
            <?php
            if(!empty($categories_data)){
              foreach($categories_data as $row){
            ?>
            <option <?php if(!empty($post_data)){ if($post_data[0]==$row->mcim_id){ echo "selected"; } }else{ if(!empty($edit_post)){ if($edit_post[0]->mcdp_category_id==$row->mcim_id){ echo "selected"; }} }?> value="<?php echo $row->mcim_id;?>"><?php echo $row->mcim_name;?></option>
          <?php } } ?>
          </select>
          
          <p style="color:red;"><?php echo form_error('mcdp_category_id');?></p>
        </div>

        <div class="input-field col s6">
            <p for="first_name">Title *</p>
          <input id="mcdp_title" onkeyup="return check_invalid_chars(this.value);" value="<?php if(!empty($post_data)){ echo $post_data[1]; }else{ if(!empty($edit_post)){ echo $edit_post[0]->mcdp_title; } }?>" type="text" name="mcdp_title" required>
          
          <p style="color:red;"><?php echo form_error('mcdp_title');?></p>
        </div>



        
      </div>
      <div class="row">

       

        <div class="input-field col s6">
            <p for="first_name">Post Date *</p>
          <input value="<?php if(!empty($post_data)){ echo $post_data[2]; }else{ if(!empty($edit_post)){ echo $edit_post[0]->mcdp_date_of_post; } }?>" type="date" name="mcdp_date_of_post" required>
          <p style="color:red;"><?php echo form_error('mcdp_date_of_post');?></p>
        </div>

         <div class="input-field col s6">
            <p for="first_name">Post Image *</p>
          <input type="file" id="mcdp_image" name="mcdp_image" <?php if(empty($edit_post)){?> required <?php } ?>><br>

          <p style="color:red;"><?php echo form_error('mcdp_image');?></p>
          <?php
          if(!empty($edit_post)){
          ?>
          <img width="100px" height="100px" src="<?php echo base_url('file_uploads/posts/'.$edit_post[0]->mcdp_image);?>">
          <?php } ?>
        </div>


        <div class="input-field col s12">
            <p for="first_name">Post Status *</p>
          <select class="form-control" name="mcdp_status" required>
            <option value="">Select Status</option>
            <option <?php if(!empty($post_data)){ if($post_data[5]==1){ echo "selected"; } }else{ if($edit_post[0]->mcdp_status==1){ echo "selected"; } }?> value="1">Active</option>
            <option <?php if(!empty($post_data)){ if($post_data[5]==2){ echo "selected"; } } else{ if($edit_post[0]->mcdp_status==2){ echo "selected"; } }?> value="2">In Active</option>
            
          </select>
          <p style="color:red;"><?php echo form_error('mcdp_status');?></p>
        </div>


       
      </div>

      <div class="row">
        <div class="input-field col s12">
            <p for="first_name">Post Content *</p>
          <textarea name="mcdp_post_content" class="form-control ckeditor"><?php if(!empty($post_data)){ echo $post_data[4]; }else{ if(!empty($edit_post)){ echo $edit_post[0]->mcdp_post_content;} }?></textarea>
          <p style="color:red;"><?php echo form_error('mcdp_date_of_post');?></p>
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
    <?php $this->load->view('admin/includes/scripts/ckeditor.js.php');?>
</body>
</html>

<script type="text/javascript">

      const imageDimensions = file => 
    new Promise((resolve, reject) => {
        const img = new Image()
        img.onload = () => {
            const { naturalWidth: width, naturalHeight: height } = img
            resolve({ width, height })
        }
        img.onerror = () => {
            reject('There was some problem with the image.')
        }
        img.src = URL.createObjectURL(file)
})

    const validateimagedimensions = async ({ target: { files } }) => {
    var imgWidth = 370;
    var imgHeight = 253;
    const [file] = files
    try {
        const dimensions = await imageDimensions(file);
        console.log({
            dimensions : dimensions,
            imgWidth : imgWidth,
            imgHeight : imgHeight
        });
        if(dimensions.width==imgWidth && dimensions.height==imgHeight)
        {
            return true;
        }
        else
        {
            alert('Invalid dimensions, Please upload image with width '+imgWidth+' and height '+imgHeight+'');
            $("#mcdp_image").val('');
            return false;
        }
    } catch(error) {
        console.error(error)
    }
}

  function getsubcategories(mcdp_category_id)
  {
    $.ajax({
      type : "POST",
      url  : "<?php echo base_url('admin/get-sub-categories-by-category-id');?>",
      data : {
        mcdp_category_id : mcdp_category_id
      },
      success : function(data){
        $("#subcategory").html(data);
      },
      error : function(){
        alert("Something went wrong");
      }
    });
  }
  function validate(file,event) {
        validateimagedimensions(event);
        var FileSize = file.files[0].size / 1024 / 1024; // in MiB
        var FileType = file.files[0].type;
        
        if(FileType=="image/jpg" || FileType=="image/jpeg" || FileType=="image/png" || FileType=="image/JPG" || FileType=="image/JPEG" || FileType=="image/PNG"){
            if (FileSize > 0.2) {
            alert('File size too large, Resize the image and upload...');
            $(file).val(''); //for clearing with Jquery
        } else {

        }
        }else{
            alert("Please upload JPG | PNG Files");
            $(file).val(''); //for clearing with Jquery
        }
    }

    function validateDoc(file,event){
      var FileSize = file.files[0].size / 10240 / 10240; // in MiB
        var FileType = file.files[0].type;
        if (FileSize > 0.2) {
            alert('File size too large, Resize the image and upload...');
            $(file).val(''); //for clearing with Jquery
        } else {
          var myfile= $( file ).val();
          var ext = myfile.split('.').pop();
          if(ext=="pdf" || ext=="docx" || ext=="doc"){
              return true;
          } else{
              alert("please upload pdf | doc | docx files");
              $(file).val('');
          }
        }
    }


</script>

<script type="text/javascript">
  function check_invalid_chars(value)
  {
    var filter1 = value.includes("%");
    var filter2 = value.includes(";");
    if(filter1==true || filter2==true)
    {
      alert("Invalid Characters in input....");
      document.getElementById("mcdp_title").value = '';
    }
    else
    {
      return true;
    }
  }
</script>