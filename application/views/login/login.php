<?php 
    if($this->session->userdata('session_sop')!="") {
            redirect('/');
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= TITLE_LOGIN_APPLICATION ?></title>
  <link rel="icon" href="<?= base_url('webfile/') ?>logo-bri2.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/vendor/animate/animate.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/vendor/select2/select2.min.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login')?>/css/main.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
      .alert{
        font-size: 12px;
      }
      h5{
        font-size:14px;
        margin-bottom:10px;
      }

    </style>
</head>
<body class="hold-transition login-page">
<div class="limiter">
  <!-- <div class="container-login100" style="<?= LOGIN_BACKGROUND ?>"> -->
    <div class="container-login100" style="background-image: url('<?= LOGIN_BACKGROUND ?>');background-size: cover;background-position: center;">
    <div class="wrap-login100" style="<?= LOGIN_BOX  ?>"> 
      <form action="<?= base_url('login/act_login')?>" method="post" id="upload">
        <span class="login100-form-logo">
          <img src=" <?= LOGO ?>" width="150">
        </span>
        <span class="login100-form-title p-b-15 p-t-15" style="font-size:20px">
         <b><?= LOGIN_TITLE  ?></a>
        </span>
        <!-- http://localhost:8888/sop_clean/login/active_account?token=R05iOWs2QVhEbGxRR1lreGNYaEg3dHhEdGFnY3k3QytDR3JFRTUzMTZxbz0= -->
        <div class="show_error" style="margin-bottom:10px">
        <?php if($this->session->flashdata('message')) echo $this->alert->alertsuccess($this->session->flashdata('message'))  ?>
        </div>
        <br>
        <div class="wrap-input100 validate-input" data-validate = "Enter username" style="margin-bottom: 25px;">
          <input class="input100" type="text" name="username" autofocus="" placeholder="Username" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>
        <div class="wrap-input100 validate-input input-group" data-validate="Enter password" style="margin-bottom: 25px;">
          <input class="input100" id="password" type="password" name="password" placeholder="Password" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
          <span class="input-group-addon fa fa-eye" id="show_password" style="margin-top: 10px;background-color: white;border: 0;color:#607d8b; "></span>
        </div>
        <?php

            if(CAPTCHA==0){
              
        
        ?>
        <div class="row">
          <div class="col-md-4">
      <?= $image ?>
          
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <input id="username" class="form-control" type="text" name="captcha" placeholder="Captcha" style="font-size: 14px;">
            </div>
          </div>
        </div>
        <?php
            }
        ?>
        <div class="container-login100-form-btn">
          <button class="btn btn-md btn-block btn-primary btn-flat">
           <i class="fa fa-sign-in"></i> Sign In
          </button>
          
        </div>
      </form>
      <br>
      <div class="text-center">
        <a href="<?= base_url('forgot-password'); ?>" style="font-size:14px"><i class="fa fa-key"></i> Forgot password ?</a><?php if(REGISTER==0){ ?> | 
        <a href="<?= base_url('login/register'); ?>" style="font-size:14px"><i class="fa fa-info-circle"></i> Registration Account</a><br>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<!-- jQuery 3 -->
<script src="<?= base_url('assets/login')?>/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url('assets/login')?>/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url('assets/login')?>/vendor/bootstrap/js/popper.js"></script>
  <script src="<?= base_url('assets/login')?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url('assets/login')?>/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url('assets/login')?>/vendor/daterangepicker/moment.min.js"></script>
  <script src="<?= base_url('assets/login')?>/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url('assets/login')?>/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url('assets/login')?>/js/main.js"></script>
  <script src="<?= base_url('upup.min.js')?>"></script>
  <script>
    UpUp.start({
      'content': 'Cannot reach site. Please check your internet connection.',
      'service-worker-url': '/upup.sw.min.js'
    });
  </script>
<script type="text/javascript">
        $("#upload").submit(function(){
            var mydata = new FormData(this);
            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: mydata,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend : function(){
                    $("#send-btn").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Send...");
                    form.find(".show_error").slideUp().html("");
                },
                    success: function(response, textStatus, xhr) {
                    var str = response;
                    if (str.indexOf("oke") != -1){
                        document.getElementById('upload').reset();
                        $("#send-btn").removeClass("disabled").html("Sign in");
                        <?php if(@$_GET['url']){ ?>
                          location.href = '<?= @$_GET['url'] ?>';
                        <?php } else { ?>
                          location.href = '<?= base_url("/") ?>';
                        <?php } ?>
                    }else{
                         $("#send-btn").removeClass("disabled").html("Sign in");
                        form.find(".show_error").hide().html(response).slideDown("fast");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                }
            });
            return false;
            });
    </script>
<script>
  $("#show_password").click(function(){
      let input_type = $("#password").attr('type')
      if(input_type=='password'){
        $("#show_password").removeClass('fa-eye').addClass('fa-eye-slash')
        $("#password").attr('type','text')
      }else{
        $("#show_password").removeClass('fa-eye-slash').addClass('fa-eye')
        $("#password").attr('type','password')
      }
    })
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>