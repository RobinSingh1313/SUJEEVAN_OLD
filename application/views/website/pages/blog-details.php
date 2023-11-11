<?php $this->load->view('website/includes/header');?>


    <div class="about_inner_banner">
        <img src="<?php echo base_url();?>website-assets/images/banner/blog-details-banner.jpg" alt="">
        <div class="inner_abt_content_box">

        </div>
    </div>

    <div class="inr-serv-main-container">
        <div class="inr-service-main">
            <div class="container">
                <div class="row staffing-row">
                    <div class="col-lg-4 col-md-12 flex-col sticky">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-xs-12 space ">
                                <div class="all-serv-sec sticky">
                                    <h4>Categories</h4>
                                    <ul>
                                        <li class="blog-category-item active_supprt">
                                            <a href="<?php echo base_url('blogs/diet-and-nutrition/2');?>">Diet and Nutrition</a>
                                        </li>
                                        <li class="blog-category-item">
                                            <a href="<?php echo base_url('blogs/fitness/3');?>">Fitness</a>
                                        </li>

                                        <li class="blog-category-item">
                                            <a href="<?php echo base_url('blogs/health/1');?>">Health</a>
                                        </li>
                                        <li class="blog-category-item">
                                            <a href="<?php echo base_url('blogs/wellness/4');?>">Wellness</a>
                                        </li>
                                          <li class="blog-category-item">
                                            <a href="<?php echo base_url('blogs/recipes/5');?>">Recipes</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- <div class="col-lg-12 col-md-12 col-xs-12 space ">
                <div class="inr-serv-query-sec">
                  <div class="query-heading">
                    <h2>
                      Have any <br />
                      query?
                    </h2>
                    <p>
                      <span><a href="contactus.html">Contact Us</a></span>
                    </p>
                  </div>
                </div>
              </div> -->

                            <!-- <div class="col-lg-12 col-md-12 col-xs-12 space">
                <div class="all-serv-sec weprovide-card">
                  <h4>We Providing Digital Services</h4>
                  <ul>
                    <li class="">
                      <a>Application</a>
                    </li>
                    <li>
                      <a>DevOps</a>
                    </li>
                    <li>
                      <a>Data Analytics</a>
                    </li>
                    <li>
                      <a>Robotic Process Automation</a>
                    </li>
                    <li>
                      <a>Cloud Services</a>
                    </li>
                    <li>
                      <a>IoT</a>
                    </li>
                    <li>
                      <a>AI/ML</a>
                    </li>
                    <li>
                      <a>BlockChain</a>
                    </li>
                  </ul>
                </div>
              </div> -->

                        </div>

                    </div>
                    <div class="col-lg-8 col-md-12 ">
                        <div class="col-12 space">
                            <div class="ser-btm-content">
                                <h2><?php if(!empty($blog_details[0]->mcdp_title)) { echo $blog_details[0]->mcdp_title; }?></h2>
                                <span><i class="fa fa-clock-o"></i> 2023-01-24</span>
                            </div>
                            <div class="inr-serv-img">
                                <img src="<?php echo base_url('file_uploads/posts/'.$blog_details[0]->mcdp_image);?>" alt="" />
                            </div>
                        </div>
                        <div class="col-12 space">
                            <div class="ser-btm-content">
                                <?php if(!empty($blog_details[0]->mcdp_post_content)) { echo $blog_details[0]->mcdp_post_content; }?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




   <?php $this->load->view('website/includes/footer');?>


</body>

</html>