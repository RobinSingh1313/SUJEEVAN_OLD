<div class="col-lg-5 col-sm-12 ">
                    <div class="nutrition_diet_form_tb">
                        <div class="nutrition_diet_form_hd">
                            <h3><span>Book An Appointment</span></h3>
                        </div>
                        <form method="POST" action="<?php echo base_url('save-appointment');?>">
                            <div class="appointment-from">
                                <input type="text" placeholder="Name" name="sd_name" pattern="^[a-zA-z\s]+$"
                                    title="Input allows only alphabets and spaces" id="txtname" required=""
                                    fdprocessedid="2dp738">
                            </div>

                            <div class="appointment-from last">
                                <input type="email" placeholder="Email Id " name="sd_email" id="txtemail" required=""
                                    fdprocessedid="xqpuup5">
                            </div>


                            <div class="appointment-from">
                                <input onchange="getTimeSlotsByDate(this.value);" type="date" placeholder="myDate" value="dd-mm-yyyy" name="sd_date"
                                    id="txtsubject" required="" fdprocessedid="tx7xi">
                            </div>

                            <div class="appointment-from">
                                <select required name="sd_time" id="dropdown" class="form-control">
                                    <option value="">Select Time Slot</option>
                                </select>
                                <br>
                            </div>
                            

                            <div class="appointment-from last">
                                <input type="Number" pattern="[1-9]{1}[0-9]{9}"
                                    title="Input allows exactly 10 numeric digits" placeholder="Mobile No "
                                    name="sd_mobile" maxlength="10" required="" fdprocessedid="pk81g8">
                            </div>
                            <div class="appointment-from">
                                <input type="text" placeholder="Address" value="" name="sd_address" id="" required=""
                                    fdprocessedid="">
                            </div>
                            <div class="appointment-from">
                                <input type="text" placeholder="City" value="" name="sd_city" id="" required=""
                                    fdprocessedid="">
                            </div>

                            <div class="appointment-from">
                                <input type="text" placeholder="State" value="" name="sd_state" id="" required=""
                                    fdprocessedid="">
                            </div>

                            <div class="appointment-textarea">
                                <textarea placeholder="Your Message" name="sd_message" id="txtmessage"></textarea>
                            </div>

                            <div class="modal-foote_r">
                                <button type="submit" class="btn btn-secondary">Submit</button>
                                <!-- <button class="appointment_btn" type="submit"> Submit <img src="<?php echo base_url();?>website-assets/images/pngs/button_pic.png" alt=""></button> -->
                            </div>

                            <!-- <button type="submit" class="appointment_btn">    Send Message </button> -->
                        </form>
                    </div>
                </div>
                <script>
                    function getTimeSlotsByDate(sd_date)
                    {
                        $.ajax({
                            type : "POST",
                            url : "<?php echo base_url('get-time-slots-by-date');?>",
                            data : {
                                sd_date : sd_date
                            },
                            success : function(data){
                                console.log(data);
                                $("#dropdown").html(data);
                            },
                            error : function(){
                                alert("Something went wrong!!");
                            }
                        })
                    }
                </script>