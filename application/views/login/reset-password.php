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
  <style>
      .alert{
        font-size: 12px;
      }
      h5{
        font-size:14px;
        margin-bottom:10px;
      }

    </style>
    
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="limiter">
  <div class="container-login100" style="background-image: url('<?= LOGIN_BACKGROUND ?>');background-size: cover;background-position: center;">
    <div class="wrap-login100" style="<?= LOGIN_BOX  ?>"> 
      <form action="<?= base_url('reset-password/proceed')?>" method="post" id="upload">
        <span class="login100-form-logo">
          <img src=" <?= LOGO ?>" width="150">
        </span>
        <span class="login100-form-title p-b-15 p-t-15" style="font-size:20px;text-transform:none">
         <b>Reset Password</a>
        </span>
        <div class="show_error"></div>
        <input type="hidden" name="ids" value="<?= $this->template->sonEncode($data->id) ?>">
        <div class="wrap-input100 validate-input" data-validate="New password" style="margin-bottom: 25px;">
          <input class="input100" type="password" name="password" placeholder="New Password" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
        </div>
        <div class="wrap-input100 validate-input" data-validate="Confirm password" style="margin-bottom: 25px;">
          <input class="input100" type="password" name="password_confirmation_field" placeholder="Confirm Password" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
        </div>
        <div class="container-login100-form-btn">
          <button class="btn btn-block btn-primary" id="send-btn">
             <i class="fa fa-save"></i> Save Password
          </button>
        </div>
      </form>
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
                    if (str.indexOf("Success") != -1){
                        document.getElementById('upload').reset();
                        $("#send-btn").removeClass("disabled").html("Proceed Reset");
                         location.href = '<?= base_url("login") ?>';
                    }else{
                         $("#send-btn").removeClass("disabled").html("Proceed Reset");
                        form.find(".show_error").hide().html(response).slideDown("fast");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  alert('Oops, something wrong! please try again');
                  $("#send-btn").removeClass("disabled").html("Proceed Reset");
                }
            });
            return false;
            });
    </script>
<script>
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