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

                            <div class="table-responsive">
                                <form method="POST" action="<?php echo base_url('admin/filter-posts');?>">
                                <div class="col-md-3">
                        <select class="form-control" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php
                                if(!empty($category_list)){
                                  foreach($category_list as $row){
                                ?>
                                <option <?php if(!empty($category_id)){ if($category_id==$row->mcim_id){ echo "selected"; } }?> value="<?php echo $row->mcim_id;?>"><?php echo $row->mcim_name;?></option>
                              <?php } } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="year" required>
                            <option value="">Select Year</option>
                            <?php
                              for($i=-5;$i<5;$i++){
                                $year1 = Date('Y');
                                $year2 = Date('Y')+$i;
                              ?>
                            <option <?php if(!empty($year)){ if($year==$year2-1){ echo "selected"; } }?> value="<?php echo $year2-1;?>"><?php echo $year2-1;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="month" required>
                            <option value="">Select Month</option>
                            <option <?php if(!empty($month)){ if($month==1){ echo "selected"; } }?> value="1">January</option>
                            <option <?php if(!empty($month)){ if($month==2){ echo "selected"; } }?> value="2">February</option>
                            <option <?php if(!empty($month)){ if($month==3){ echo "selected"; } }?> value="3">March</option>
                            <option <?php if(!empty($month)){ if($month==4){ echo "selected"; } }?> value="4">April</option>
                            <option <?php if(!empty($month)){ if($month==5){ echo "selected"; } }?> value="5">May</option>
                            <option <?php if(!empty($month)){ if($month==6){ echo "selected"; } }?> value="6">June</option>
                            <option <?php if(!empty($month)){ if($month==7){ echo "selected"; } }?> value="7">July</option>
                            <option <?php if(!empty($month)){ if($month==8){ echo "selected"; } }?> value="8">August</option>
                            <option <?php if(!empty($month)){ if($month==9){ echo "selected"; } }?> value="9">September</option>
                            <option <?php if(!empty($month)){ if($month==10){ echo "selected"; } }?> value="10">October</option>
                            <option <?php if(!empty($month)){ if($month==11){ echo "selected"; } }?> value="11">November</option>
                            <option <?php if(!empty($month)){ if($month==12){ echo "selected"; } }?> value="12">December</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                       <button type="submit" class="waves-effect waves-light btn">Filter</button>
                    </div>

                    </form><br><br><br>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 0;
                                        if(!empty($posts_list)){
                                          foreach($posts_list as $row){
                                              if($row->scim_name==''){
                                                $row->scim_name = 'No-Sub-Category';
                                            }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo ++$sno;?></td>
                                            <td><?php echo $row->mcdp_title;?></td>
                                            <td><img width="100px" height="100px" src="<?php echo base_url('file_uploads/posts/'.$row->mcdp_image);?>"></td>
                                            
                                            <td><?php if($row->mcdp_status==1){ echo "<b style='color:green;'>Active</b>"; }else{ echo "<b style='color:red;'>In Active</b>";} ?></td>
                                            <td class="center">
                                              <div class="btn-group">
                                              <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions <span class="caret"></span></button>
                                              <ul class="dropdown-menu">
                                              <li><a href="<?php echo base_url('admin/edit-post/'.base64_encode($row->mcdp_id));?>">Edit</a></li>
                                              

                                              
                                              </ul>
                                            </div>
                                            </td>
                                        </tr>
                                      <?php } } ?>
                                        
                                
                                    </tbody>
                                </table>
                            </div>
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
    
    
  
    <?php $this->load->view('admin/includes/scripts/datatables.js.php');?>
    <!-- Custom Js -->
    <?php $this->load->view('admin/includes/scripts/custom-scripts.js.php');?> 
</body>
</html>