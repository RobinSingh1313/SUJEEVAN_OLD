<?php $this->load->view('website/includes/header');?>
    <!-- menu section end -->

    <section class="wide-tb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-12"></div>
                <div class="col-lg-8 col-md-12" style="text-align: center;">
                    <h1 class="heading-main">
                        <span> Get In Touch </span>
                    </h1>
                    <p>The secret to happiness lies in helping others. Never underestimate the difference YOU can make
                        in the lives of the poor, the abused and the helpless. Spread sunshine in their lives no matter
                        what the weather may be.</p>
                </div>
                <div class="col-lg-2 col-md-12"></div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-8 col-md-12 order-lg-last">
                    <div class="contact-wrap">
                        <div class="contact-icon-xl">
                            <i class="charity-love_hearts"></i>
                        </div>
                        <div id="sucessmessage"> </div>
                        <form enctype="multipart/form-data" action="<?php echo base_url('Website/save_contact');?>" method="post" id="contact_form">
                            <div class="row">
                                <div class="col-md-6 mb-0">
                                    <div class="form-group">
                                        <input type="text" name="wcim_name" id="name" class="form-control"
                                            placeholder="First Name" required="required">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-0">
                                    <div class="form-group">
                                        <input type="text" name="lastname" id="lastname" class="form-control"
                                            placeholder="Last Name" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <input type="email" name="wcim_email" id="email" class="form-control"
                                            placeholder=" Email " required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <input type="number" name="wcim_mobile" id="phone" class="form-control"
                                            placeholder="Phone Number" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-0">
                                    <div class="form-group">
                                        <input type="city" name="wcim_city" id="city" class="form-control"
                                            placeholder=" City " required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-0">
                                    <div class="form-group">
                                        <input type="State" name="wcim_state" id="State" class="form-control"
                                            placeholder=" State " required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <label class="contact_uplding_hd" for="">Upload profile photo (optional)</label>
                                        <input type="file" class="form-control" placeholder="Upload Picture"
                                            name="wcim_profile_photo" id="Picture">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <label class="contact_uplding_hd" for="">Upload medical report (optional)</label>
                                        <input type="file" class="form-control" placeholder="Upload File"
                                            name="wcim_medical_report" id="Picture">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <select class="form-control" name="wcim_dept" id="departments" required=""
                                            fdprocessedid="8lhd2">
                                            <option value="#" selected="" disabled="">Select Purpose</option>
                                            <option value="#"> Diabetes care program </option>
                                            <option value="#"> Cardiac care program </option>
                                            <option value="#"> Weight loss program </option>
                                            <option value="#"> Hypertension care program </option>
                                            <option value="#"> Genaral Surgery</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <textarea required name="wcim_message" id="comment" class="form-control" rows="6"
                                            placeholder="Message"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary text-nowrap">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">

                    <!-- <div class="icon-box-4 bg-orange mb-4">
                        <h3>Our Address</h3>
                        <h1>Chanakyapuri Road, Rock Town Colony, L.B. Nagar, Hyderabad.</h1>
                    </div> -->


                    <div class="icon-box-4 bg-green mb-4">
                        <h3>Phone Number</h3>
                        <h1>7997 006 006<br>6303 673 227</h1>
                    </div>


                    <div class="icon-box-4 bg-gray mb-4">
                        <h3>Email Address</h3>
                        <div><a href="mailto:wellness@sujeevanhealth.com">wellness@sujeevanhealth.com</a></div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    <div id="footer"></div>




    <?php $this->load->view('website/includes/footer');?>