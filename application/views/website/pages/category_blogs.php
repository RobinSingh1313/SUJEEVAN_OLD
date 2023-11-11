<?php $this->load->view('website/includes/header');?>


    <div class="blog_inner_banner">
        <?php 
            $segment = $this->uri->segment(3);
        ?>
        <?php if($segment==2){?>
        <img src="<?php echo base_url();?>website-assets/images/banner/diet-blog-bnr.jpg" alt="">
        <?php } ?>
        <?php if($segment==3){?>
        <img src="<?php echo base_url();?>website-assets/images/banner/fitness-blog.jpg" alt="">
        <?php } ?>
         <?php if($segment==1){?>
        <img src="<?php echo base_url();?>website-assets/images/banner/health-blog.jpg" alt="">
        <?php } ?>
        <?php if($segment==4){?>
        <div id="whychoose-blk-blog">
        <div class="wel_ness_iner_rd-blog">
            <div class="blog-circle-main">
                <img class="blog-banner-pic1" src="<?php echo base_url();?>website-assets/images/pngs/suJeevan_approach_rd.png" alt="">
                <div class="bolg-center-logo">
                <img class="wel_ness_iner_rd_pic2-blog" src="https://sujeevanhealth.com/website-assets/images/healthwellness/Logo_1.jpg" alt="">
                </div>
            </div>

        </div>
    </div>
        <!--<img src="<?php echo base_url();?>website-assets/images/banner/wellness.jpg" alt="">-->
        <?php } ?>
           <?php if($segment==5){?>
        <img src="<?php echo base_url();?>website-assets/images/banner/recipes-blog.jpg" alt="">
        <?php } ?>
        
     
        <div class="inner_abt_content_box">

        </div>
    </div>
    
    
    
    <section class="blog-one">
    <div class="container">

      <div class="row">
        
                        <?php 
                            if(!empty($blogs)){
                                
                            foreach($blogs as $row){
                        ?>
       
                        <div class="col-lg-3 col-sm-6 wow fadeInUp   animated" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms; animation-name: fadeInUp;">
                    <!--Blog One single-->
                    <div class="blog-one__single">
                        <div class="blog-one__img">
                            <img src="<?php echo base_url('file_uploads/posts/'.$row->mcdp_image);?>" alt="">
                            <div class="blog-one__tag">
                               
                            </div>
                            <a href="">
                                <span class="blog-one__plus"></span>
                            </a>
                        </div>
                        <div class="blog-one__content">
                            <ul class="list-unstyled blog-one__meta">
                                <li><i class="fa fa-clock"></i> <?php echo Date('Y-m-d',strtotime($row->mcdp_date_of_post));;?></li>
                            </ul>
                            <h3 class="blog-one__title">
                                <a href=""><?php echo $row->mcdp_title;?></a>
                            </h3>
                            <p class="blog-paragraph"><?php echo word_limiter($row->mcdp_post_content,20);?></p>
                            <div class="blog-one__bottom">
                                <a href="<?php echo base_url('Website/blog_details/'.$row->mcdp_id);?>">Learn more<i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php } } ?>
                                
                               
                                
                        
      </div>
    </div>
  </section>
    
    
    
    
    
    
    
    
    
    
     <div id="footer"></div>


     <?php $this->load->view('website/includes/footer');?>