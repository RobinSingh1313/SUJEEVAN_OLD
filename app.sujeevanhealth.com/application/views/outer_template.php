<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo sitedata("site_name");?></title>

    <!-- vendor css -->
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>css/bracket.css">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>css/bracket.simple-white.css">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>sujeevan.css">
  </head>
  <body>
    <div class="row no-gutters flex-row-reverse ht-100v">
       <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
          <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
             <img src="<?php echo $this->config->item("jeevanassets");?>name-logo.png" class="img img-responsive"/>
             <?php $this->load->view($content);?>
          </div>
          <!-- login-wrapper -->
       </div>
       <!-- col -->
       <div class="col-md-6 bg-white d-flex align-items-center justify-content-center">
          <div class="wd-250 wd-xl-450 mg-y-30">
             <div class="mx-auto">
                <img src="<?php echo $this->config->item("jeevanassets");?>logo.png" class="img img-responsive"/>
             </div>
          </div>
          <!-- wd-500 -->
       </div>
    </div>
    <!-- row -->
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>js/jquery.validate.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>js/additional-methods.js"></script>
    <script>
            var adminurl    = '/';
            $('.lginvalidation').validate({ 
                errorClass:"text-danger",
                rules:{
                    username:{
                        required:true, 
                        remote:{
                            url:adminurl+"Ajax-User-Exist",
                            type:"post",
                            data:{
                                username:function(){
                                    return  $(".username").val();
                                }
                            }
                        }
                    },
                    emailid:{
                        required:true,
                        email:true,
                        remote:{
                            url:adminurl+"Ajax-User-Email",
                            type:"post",
                            data:{
                                emailid:function(){
                                    return  $(".emailid").val();
                                }
                            }
                        }
                    }
                },
                messages: {
                    username: {
                        required:"Please enter your username",
                        remote: jQuery.validator.format('<span class="text-success">"{0}"</span> : Username does not exists.')
                    },
                    password:"Please enter your password",
                    emailid:{
                        required:"Please enter your email id",
                        email:"Please enter valid email address",
                        remote: jQuery.validator.format('<span class="text-success">"{0}"</span> : Email Id does not exists.')
                    }
                },
                highlight: function (input) {
                    $(input).parents('.form-control').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-control').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error);
                }
            });
    </script>
</body>
</html>