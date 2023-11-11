<?php $this->load->view('website/includes/header');?>
    <!-- menu section end -->

    <div class="about_inner_banner">
        <img src="<?php echo base_url();?>website-assets/images/banner/blogs_banner1.jpg" alt="">
        <div class="inner_abt_content_box">

        </div>
    </div>


    <!-- Blogs section  doctor_consultation -->
     <?php 
                    if(!empty($blogs)){
                        foreach($blogs as $row){
                ?>
    <div class="inner_blogs_section">
       
        <div class="container">
            
            <div class="row">
                
                <div class="col-md-12">
                    <div class="inner_blogs_hedding">
                        <h2><?php echo $row->mcim_name;?></h2>
                    </div>
                </div>
                <?php 
                    foreach($row->blogs as $row2){
                ?>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="inner_blogs_box">
                        <img src="<?php echo base_url('file_uploads/posts/'.$row2->mcdp_image);?>" alt="">
                        <div class="inner_blogs_box_text">
                            <h4><?php echo $row2->mcdp_title;?></h4>
                            <p><?php echo word_limiter($row2->mcdp_post_content, 10);?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            
        </div>
        
    </div>
    <?php } } ?>
    <!-- Blogs section end-->

    <!-- Blogs section -->
   
    <!-- Blogs section -->
    <!-- Blogs section fitness -->
  
    <!-- Blogs section -->

    <!-- inner service section end -->
    <!--  -->
    <div id="footer"></div>


    <?php $this->load->view('website/includes/footer');?>