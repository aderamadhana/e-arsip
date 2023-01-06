<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Notification
    <small>Master</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">master</a></li>
      <li class="active">Notification</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <form method="POST" action="<?= base_url('master/Notification/store') ?>" id="upload-create" enctype="multipart/form-data">
      <div class="row">
        <div class="col-xs-8">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <h5 class="box-title">
              Tambah Notification
              </h5>
            </div>
            <div class="box-body">
              <div class="show_error"></div>
              <div class="form-group hidden">
                <label for="form-counting">Counting</label>
                <input type="text" class="form-control" id="form-counting" placeholder="Masukan Counting" name="dt[counting]" value="0">
              </div>
              <div class="form-group">
                <label for="form-slug">Slug / ID Element</label>
                <select name="dt[slug]" class="form-control select2">
                  <option value="">Pilih Slug / ID Element</option>
                  <?php
                    $menu_master = $this->mymodel->selectWhere('menu_master',['notif is not null','notif !='=>'']);
                    foreach ($menu_master as $menu_master_record) {
                      echo "<option value=".$menu_master_record['notif'].">".$menu_master_record['notif']." - ".$menu_master_record['name']."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="form-user_id">User</label>
                <select name="dt[user_id]" class="form-control select2">
                  <option value="">Pilih User</option>
                  <?php
                    $user = $this->mymodel->selectWhere('user',null);
                    foreach ($user as $user_record) {
                      echo "<option value=".$user_record['id'].">".$user_record['name']."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="form-role_id">Role</label>
                <select name="dt[role_id]" class="form-control select2">
                  <option value="">Pilih Role</option>
                  <option value="allrole">Semua Role</option>
                  <?php
                    $role = $this->mymodel->selectWhere('role',null);
                    foreach ($role as $role_record) {
                      echo "<option value=".$role_record['id'].">".$role_record['role']."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
              <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
  <script type="text/javascript">
      $("#upload-create").submit(function(){
            var form = $(this);
            var mydata = new FormData(this);
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: mydata,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend : function(){
                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
                    form.find(".show_error").slideUp().html("");
                },
                success: function(response, textStatus, xhr) {
                    // alert(mydata);
                   var str = response;
                    if (str.indexOf("success") != -1){
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        setTimeout(function(){ 
                           window.location.href = "<?= base_url('master/Notification') ?>";
                        }, 1000);
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    }else{
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  console.log(xhr);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");
                }
            });
            return false;
        });
  </script>