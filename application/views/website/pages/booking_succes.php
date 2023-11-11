
<?php $this->load->view('website/includes/header');?>
    <style>
        .successful_right_mark_box {
            padding: 50px;
            margin: 100px 0px;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
            text-align: center;
        }

        .successful_right_mark_box_pic {
            width: 250px;
            height: 184px;
            margin: -46px auto 10px auto;
        }

        .successful_right_mark_box .successful_right_img {
            width: 220px;
        }


        .successful_right_mark_box h3 {
            color: #fe7f1b;
            font-size: 40px;
            font-weight: 600;
            font-family: 'Merriweather', serif;
            position: relative;
            margin-bottom: 40px;
            margin-top: -15px;
        }

        .successful_right_mark_box a {
            color: #009486;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 50px;
            border: 1px solid #009486;
        }

        .successful_right_mark_box a:hover {
            color: #fe7f1b;
        }

        @media (max-width: 500px) {
            .successful_right_mark_box h3 {
                font-size: 25px;
            }

            .successful_right_mark_box {
                padding: 50px 0px;
            }
        }
    </style>



    <!-- menu section end -->
    <div class="successful_right_mark">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="successful_right_mark_box">
                        <div class="successful_right_mark_box_pic">
                            <img class="successful_right_img" src="<?php echo base_url();?>website-assets/images/pngs/successful.gif" alt="">
                        </div>
                        <h3> Booking Succes</h3>
                        <a href="<?php echo base_url();?>">Back to Home <img class="successful_btn_img" style="width:18px"
                                src="<?php echo base_url();?>website-assets/images/pngs/button_pic.png" alt=""></a>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <div id="footer"></div>


   <?php $this->load->view('website/includes/footer');?>