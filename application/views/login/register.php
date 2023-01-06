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
  <div class="container-login100" style="background-image: url('<?= LOGIN_BACKGROUND ?>');background-size: cover;background-position: center;">
    <div class="wrap-login100" style="<?= LOGIN_BOX  ?>">
      <form action="<?= base_url('login/act_register')?>" method="post" id="upload">
        <span class="login100-form-logo">
          <img src=" <?= LOGO ?>" width="150">
        </span>
        <span class="login100-form-title p-b-15 p-t-15" style="font-size:20px">
         <b>Register</a>
        </span>
        <div class="show_error" style="margin-bottom:10px"></div>
        <br>
        <div class="wrap-input100 validate-input" data-validate = "Enter username" style="margin-bottom: 25px;">
          <input class="input100" type="text" required name="username" autofocus="" placeholder="PN" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>
        <div class="wrap-input100 validate-input" data-validate = "Enter name" style="margin-bottom: 25px;">
          <input class="input100" type="text" required name="name" autofocus="" placeholder="name" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf16a;"></span>
        </div>
        <div class="wrap-input100 validate-input" data-validate="Enter password" style="margin-bottom: 25px;">  
          <i class="fa fa-building-o" style="position: absolute;margin-top: 11px;font-size: 24px;margin-left: 4px;color: #607d8b;"></i>
          <select class="input100" name="departemen" required style="padding-left: 32px;border: 0px">
            <option value="">Departemen :</option>
            <?php
              $this->db->order_by('nama','ASC');
              $departemen = $this->mymodel->selectWhere('m_departemen',array('status'=>'ENABLE'));
              foreach($departemen as $dpt){
                ?>
                <option value="<?=$dpt['id']?>"><?=$dpt['nama']?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="wrap-input100 validate-input" data-validate="Enter password" style="margin-bottom: 25px;">  
          <i class="fa fa-building-o" style="position: absolute;margin-top: 11px;font-size: 24px;margin-left: 4px;color: #607d8b;"></i>
          <input id="input-jabatan" name="jabatan" type="hidden" class="form-control"/>
          <select class="input100" id="select-jabatan-id" name="jabatan_id" required style="padding-left: 32px;border: 0px" onchange="$('#input-jabatan').val($('#select-jabatan-id option:selected').text()).change()">
            <option value="">Jabatan :</option>
            <?php 
              $this->db->order_by('jabatan','ASC');
              $list_jabatan = $this->mymodel->selectWhere('jabatan',['status'=>'ENABLE']);
              foreach($list_jabatan as $jabatan):
            ?>
              <option value="<?= $jabatan['id'] ?>"><?= $jabatan['jabatan'] ?></option>
            <?php 
              endforeach;
            ?>
          </select>
        </div>
        
        <div class="wrap-input100 validate-input" data-validate = "Enter email" style="margin-bottom: 25px;">
          <input class="input100"  type="text" name="email" required autofocus="" placeholder="email" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf15a;"></span>
        </div>
        <div class="wrap-input100 validate-input input-group" data-validate="Enter password" style="margin-bottom: 25px;">
          <input class="input100" id="password" type="password" required name="password" placeholder="Password" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
          <span class="input-group-addon fa fa-eye" id="show_password" style="margin-top: 10px;background-color: white;border: 0;color:#607d8b; "></span>
        </div>
        <div class="wrap-input100 validate-input input-group" data-validate="Enter password" style="margin-bottom: 25px;">
          <input class="input100" id="confirm_password" type="password" name="confirm_password" required placeholder="Re-type Password" style="font-size: 14px;">
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
          <span class="input-group-addon fa fa-eye" id="show_confirm_password" style="margin-top: 10px;background-color: white;border: 0;color:#607d8b; "></span>
        </div>
        <div class="col-md-12" style="height: 150px; overflow-y: auto">
        <?=TERM_CONDITION ?>
        </div>
        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px;text-align:right">
            <input type="checkbox" id="term-condition" name="term_condition"> I Agree 
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
           <i class="fa fa-sign-in"></i> Register
          </button>
          
        </div>
      </form>
      <br>
      <div class="text-center">
        <a href="<?= base_url('login'); ?>" style="font-size:14px"><i class="fa fa-info-circle"></i> Back to login ?</a><br>
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
<script type="text/javascript">
        var decoded_json_jabatan = JSON.parse('<?= $encoded_json_jabatan ?>');
        $("#upload").submit(function(){
        //   if(!$('#term-condition').prop('checked')){
        //     alert('You Have To Agree With Term And Condition');
        //   }
        //   else{
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
                    if (str.indexOf("success") != -1){
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        document.getElementById('upload').reset();
                        $("#send-btn").removeClass("disabled").html("Sign in");
                        setTimeout(() => {
                          location.href = '<?= base_url("/") ?>';
                        }, (2000));
                    }else{
                         $("#send-btn").removeClass("disabled").html("Sign in");
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                }
            });
        //   }
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

    $("#show_confirm_password").click(function(){
      let input_type = $("#confirm_password").attr('type')
      if(input_type=='password'){
        $("#show_confirm_password").removeClass('fa-eye').addClass('fa-eye-slash')
        $("#confirm_password").attr('type','text')
      }else{
        $("#show_confirm_password").removeClass('fa-eye-slash').addClass('fa-eye')
        $("#confirm_password").attr('type','password')
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