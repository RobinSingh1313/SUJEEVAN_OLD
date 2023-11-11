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
                            <?php
        if(!empty($this->session->flashdata('flash'))){
            echo $this->session->flashdata('flash');
            unset($_SESSION['flash']);
        }
        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Subscription Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 0;
                                        if(!empty($subscribers)){
                                          foreach($subscribers as $row){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo ++$sno;?></td>
                                            <td><?php echo $row->s_name;?></td>
                                            <td><?php echo $row->s_email;?></td>
                                            <td><?php echo $row->s_mobile;?></td>
                                            <td><?php echo $row->s_date;?></td>
                                           
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