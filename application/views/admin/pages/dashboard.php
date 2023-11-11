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
			<div class="dashboard-cards"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
					
						<div class="card horizontal cardIcon waves-effect waves-dark">
						<div class="card-image red">
						<i class="fa fa-users"></i>
						</div>
						<div class="card-stacked red">
						<div class="card-content">
						<h3><?php echo $counts[0]->admins_count;?></h3> 
						</div>
						<div class="card-action">
						<strong>Admins</strong>
						</div>
						</div>
						</div>
	 
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
					
						<div class="card horizontal cardIcon waves-effect waves-dark">
						<div class="card-image orange">
						<i class="material-icons dp48">web</i>
						</div>
						<div class="card-stacked orange">
						<div class="card-content">
						<h3><?php echo $counts[0]->categories_count;?></h3> 
						</div>
						<div class="card-action">
						<strong>Categories</strong>
						</div>
						</div>
						</div> 
                    </div>

					<div class="col-xs-12 col-sm-6 col-md-3">
					
						<div class="card horizontal cardIcon waves-effect waves-dark">
						<div class="card-image purple">
						<i class="fa fa-users"></i>
						</div>
						<div class="card-stacked purple">
						<div class="card-content">
						<h3><?php echo $counts[0]->posts_count;?></h3> 
						</div>
						<div class="card-action">
						<strong>Blog Posts</strong>
						</div>
						</div>
						</div>
	 
                    </div>

					<div class="col-xs-12 col-sm-6 col-md-3">
					
					<div class="card horizontal cardIcon waves-effect waves-dark">
						<div class="card-image orange">
						<i class="material-icons dp48">aspect_ratio</i>
						</div>
						<div class="card-stacked orange">
						<div class="card-content">
						<h3><?php echo $counts[0]->contacts_count;?></h3> 
						</div>
						<div class="card-action">
						<strong>Contacts</strong>
						</div>
						</div>
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