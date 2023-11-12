<div id="footer"></div>

<div class="footer_total_sec">
    <!-- footer section -->
    <div class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="foot_left">
                        <a href="<?php echo base_url();?>">
                            <img src="<?php echo base_url();?>website-assets/images/banner/Logo.png" alt="" style="width: 100px;">
                        </a>
                        <h6 style="color: #FF713E">Fighting Fat. Promoting Health</h6>

                        <p>"f8t" is a dynamic and
purpose-driven health
and wellness company
committed to
transforming lives by
combating excessfat and
its adverse health effects</p>
                        <div class="social-links">
                            <a href="#" class="face_sllk"><i class="bi-twitter fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <!--<a href="#"><i class="bi-twitter fa fa-twitter" aria-hidden="true"></i></a>-->
                            <a href="https://instagram.com/sujeevan_wellness?igshid=ZDdkNTZiNTM=" target="_blank"><i class="bi-instagram fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="bi-youtube fa fa-youtube-play" aria-hidden="true"></i></a>
                            <a href="https://www.linkedin.com/company/sujeevan-health-and-wellness-services-pvt-ltd/" target="_blank"><i class="bi-twitter fa fa-linkedin" aria-hidden="true"></i></a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="foot_links">
                        <ul>
                            <li><a href="<?php echo base_url();?>">Home</a></li>
                            <li><a href="<?php echo base_url();?>about-us">About Us </a></li>
                            <li><a href="<?php echo base_url();?>why-sujeevan">Why f8t </a></li>
                            <li><a href="<?php echo base_url();?>diet-nutrition">Services </a></li>
                            <li><a href="<?php echo base_url();?>contactus">Contact Us </a></li>
                        </ul>
                    </div>
                </div>
                <?php $this->load->view('website/includes/newsletter_subscription');?>
            </div>
        </div>
    </div>
    <!-- footer end -->

    <!-- footer_right -->
    <div class="footer_right">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-sm-12 col-xs-12">
                    <div class="footerbottom1">
                        <h5>© 2022 f8t Health Care All Rights Reserved.</h5>
                    </div>
                </div>

                <div class="col-lg-5 col-sm-12 col-xs-12">
                    <div class="footerbottom2">
                        <h4> Designed By <span><a href="http://svapps.in/" target="_blank"><img class="svapps_logo"
                                        src="<?php echo base_url();?>website-assets/images/svapps_logo.png" alt=""> </a> </span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url();?>website-assets/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url();?>website-assets/js/webslidemenu.js"></script>
<!-- testmonal script -->

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

     <script>
        $(document).ready(function () {
            $("#testimonial_svc").owlCarousel({
                items: 1,
                itemsDesktop: [1000, 1],
                itemsDesktopSmall: [980, 1],
                itemsTablet: [768, 1],
                pagination: true,
                navigation: false,
                navigationText: ["", ""],
                autoPlay: true
            });
        });
    </script>

<!-- test monal -->


<script type="text/javascript">
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 250) { // Set position from top
            $('.header_area').addClass("page-scroll");
        } else {
            $('.header_area').removeClass("page-scroll");
        }
    });
</script>


<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+91-7997 006 006", // WhatsApp number
            call_to_action: "", // Call to action
            position: "right", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js">

</script>
<script>
    $('.services_slider_images').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.services_slider_controls',
        dots: false,
        arrows: false,
        speed: 300,
        autoplay: true,
        // variableWidth: true,
        infinite: true,
        responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false,
                }
            }]
    });
    $('.services_slider_controls').slick({
        slidesToShow: 3,
        // slidesToScroll: 1,
        asNavFor: '.services_slider_images',
        dots: true,
        focusOnSelect: true
    });

    $('.bannerSlider').slick({
        slidesToScroll: 1,
        slidesToShow: 1,
        autoplay: true,
        speed: 300,
        dots: true,
        arrows: false,
        zIndex: 999,
        fade: true,
        cssEase: 'linear'
    });
    AOS.init();
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init();
</script>
<!-- include html -->
<!-- <script>
$("#header").load("header.html");
</script> -->
<script>
    // $("#footer").load("Website/footer");
</script>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>


</body>

</html>