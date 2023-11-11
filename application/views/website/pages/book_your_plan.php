<?php $this->load->view('website/includes/header');?>
    <!-- menu section end -->


    <div class="plans_page_farm">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="plans_page_farm_left">
                        <img src="<?php echo base_url();?>website-assets/images/healthwellness/book_page.gif" alt="">
                        <h4>Free Initial Assessment by our Health Coach!
Start your health journey with <span>SUJEEVAN 🤝</span></h4>
                        
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="plans_page_farm_box">
                        <div class="nutrition_diet_form_tb">
                            <div class="plans_page_farm_box_hd">
                                <h3><span> Book Your Plan </span></h3>
                            </div>
                            <form method="POST" action="<?php echo base_url('save-booking-plan');?>">
                                <div class="appointment-from">
                                    <input type="text" placeholder="Name" name="b_name" pattern="^[a-zA-z\s]+$"
                                        title="Input allows only alphabets and spaces" id="txtname" required=""
                                        fdprocessedid="2dp738">
                                </div>

                                <div class="appointment-from last">
                                    <input type="email" required placeholder="Email Id " name="b_email" id="txtemail"
                                        required="" fdprocessedid="xqpuup5">
                                </div>
                                <!-- <input type="date" > -->

                                <div class="appointment-from last">
                                    <input type="Number" pattern="[1-9]{1}[0-9]{9}"
                                        title="Input allows exactly 10 numeric digits" placeholder="Mobile No "
                                        name="b_mobile" maxlength="10" required="" fdprocessedid="pk81g8">
                                </div>
                                <div class="appointment-from">
                                    <input type="text" placeholder="Address" value="" name="b_address" id="" required=""
                                        fdprocessedid="">
                                </div>
                                <label>Select Package</label><br>
                                <input type="checkbox" name="b_program[]" value="Weight Loss">&nbsp;Weight Loss<br>
                                    <input type="checkbox" name="b_program[]" value="Diabetes care">&nbsp;Diabetes care<br>
                                    <input type="checkbox" name="b_program[]" value="Cardiac care">&nbsp;Cardiac care<br>
                                    <!--<input type="checkbox" name="b_program[]" value="Weight Loss">&nbsp;Weight Loss<br>-->
                                    <input type="checkbox" name="b_program[]" value="Hypertension care">&nbsp;Hypertension care<br>
                                    <input type="checkbox" name="b_program[]" value="Pregnancy Care">&nbsp;Pregnancy Care<br>
                                    <input type="checkbox" name="b_program[]" value="Stress Management">&nbsp;Stress Management<br>
                                    <br><br>
                                <!--<div class="appointment-from">-->
                                <!--    <input type="checkbox" name="b_program[]" value="Weight Loss">Weight Loss-->
                                <!--    <input type="checkbox" name="b_program[]" value="Diabetes care">Diabetes care-->
                                <!--    <input type="checkbox" name="b_program[]" value="Cardiac care">Cardiac care-->
                                <!--    <input type="checkbox" name="b_program[]" value="Weight Loss">Weight Loss-->
                                <!--    <input type="checkbox" name="b_program[]" value="Hypertension care">Hypertension care-->
                                <!--    <input type="checkbox" name="b_program[]" value="Pregnancy Care">Pregnancy Care-->
                                <!--    <input type="checkbox" name="b_program[]" value="Stress Management">Stress Management-->
                                <!--    <select class="form-control" style="margin-bottom: 15px;" name="b_program"-->
                                <!--        id="departments" required="" fdprocessedid="8lhd2">-->
                                <!--        <option value="#" selected="" disabled="">Select programs</option>-->
                                <!--        <option value="Weight Loss"> Whight Loss </option>-->
                                <!--        <option value="Diabetes care"> Diabetes care </option>-->
                                <!--        <option value="Cardiac care"> Cardiac care </option>-->
                                <!--        <option value="Hypertension care"> Hypertension care </option>-->
                                <!--        <option value="Pregnancy Care"> Pregnancy Care </option>-->
                                <!--        <option value="Stress Management"> Stress Management </option>-->
                                <!--    </select>-->
                                <!--</div>-->


                                <!--<div class="appointment-from">-->
                                <!--    <select class="form-control" style="margin-bottom: 15px;" name="b_package"-->
                                <!--        id="departments" required="" fdprocessedid="8lhd2">-->
                                <!--        <option value="#" selected="" disabled="">Our Packages</option>-->
                                <!--        <option value="Prevention"> Prevention </option>-->
                                <!--        <option value="Management"> Management </option>-->
                                <!--        <option value="Reverse"> Reverse </option>-->
                                <!--    </select>-->
                                <!--</div>-->


                                <!--<div class="appointment-from">-->
                                <!--    <select class="form-control" style="margin-bottom: 15px;" name="b_plan"-->
                                <!--        id="departments" required="" fdprocessedid="8lhd2">-->
                                <!--        <option value="#" selected="" disabled="">Book Your Plan</option>-->
                                <!--        <option value="3 MONTHS"> 3 MONTHS</option>-->
                                <!--        <option value="6 MONTHS"> 6 MONTHS</option>-->
                                <!--        <option value="12 MONTHS"> 12 MONTHS</option>-->
                                <!--    </select>-->
                                <!--</div>-->

                                <div class="appointment-textarea">
                                    <textarea placeholder="Your Message" name="b_message" id="txtmessage"></textarea>
                                </div>

                                <div class="modal-foote_r">

                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-0"></div>
            </div>
        </div>
    </div>


    <div id="footer"></div>


    <?php $this->load->view('website/includes/footer');?>