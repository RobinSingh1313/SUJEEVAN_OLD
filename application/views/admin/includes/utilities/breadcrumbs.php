<div class="header"> 
                        <h1 class="page-header">
                            <?php if(!empty($breadcrumbs[0])){ echo $breadcrumbs[0]; }?>
                        </h1>
						<ol class="breadcrumb">
                        <?php if(!empty($breadcrumbs[1])){ ?> <li><a href="#"><?php echo $breadcrumbs[1];?></a></li> <?php } ?>
                        <?php if(!empty($breadcrumbs[2])){ ?> <li><a href="#"><?php echo $breadcrumbs[2];?></a></li> <?php } ?>
					  <?php if(!empty($breadcrumbs[3])){ ?><li class="active"><?php echo $breadcrumbs[3];?></li><?php } ?>
					</ol>	
</div>