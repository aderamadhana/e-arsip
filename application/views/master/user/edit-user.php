  
  <style>
    select.readonly{
      pointer-events: none;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
        <small>Edit User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User</a></li>
        <li class="active">Edit User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">
              </h3>
               <div class="pull-right">
                </div>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">
              <form action="<?= base_url('master/user/updateUser') ?>" enctype="multipart/form-data" method="POST" id="upload">
                <div class="show_error"></div>
                <input type="hidden" name="ids" value="<?= $user_data['id'] ?>">
                <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <center>
                  <?php
                    if($file['dir']!=""){
                    $types = explode("/", $file['mime']);
                    if($types[0]=="image"){
                  ?>
                      <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">
                      <br>
                    <?php }else{ ?>
                      
                      <i class="fa fa-file fa-5x text-danger"></i>
                      <br>
                      <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>
                      <br>
                    <br>
                  <?php } ?>
                  <?php } ?>
                  </center>
                  <label for="form-file">File</label>
                  <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">          
                  </div>   
                </div> -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label>username</label>
                    <input type="text" name="username" disabled class="form-control" value="<?= $user_data['username'] ?>">
                  </div>
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= $user_data['name'] ?>" readonly>
                  </div>

                  <div class="form-group" id="ktk-departemen">
                    <label>Departemen</label>
                    <select name="dt[departemen]" class="form-control readonly" readonly>
                      <option value="">--Departemen--</option>
                      <?php 
                      $departemen = $this->mymodel->selectWhere('m_departemen',array('status'=>'ENABLE'));
                      foreach ($departemen as $key => $value): ?>
                       <option value="<?= $value['id'] ?>" <?= ($user_data['departemen']==$value['id'])?'selected':''; ?>><?= $value['nama'] ?></option> 
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group" id="ktk-jabatan">
                    <label>Jabatan</label>
                    <input name="dt[jabatan]" type="text" class="form-control" value="<?= $user_data['jabatan'] ?>" readonly />
                  </div>

                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?= $user_data['email'] ?>">
                  </div>
                  <!-- <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role_id" disabled="">
                      <?php 
                        $role = $this->mymodel->selectData('role');
                        foreach ($role as $value) { ?>
                        <option value="<?= $value['id']?>" <?php ($value['id'] == $user_data['role_id']) ? "selected":"" ?>><?= $value['role']?></option>
                      <?php } ?>
                    </select>
                  </div> -->
                  <div class="form-group">
                    <label>Deskription</label>
                    <textarea class="form-control" name="desc"><?= $user_data['desc'] ?></textarea>
                  </div>
                  <?php
                  if($this->template->sonEncode($id) == $this->template->sonEncode($user_data['id'])) {
                    ?>
                    <div style="float: left;">
                      <button type="button" onclick="resetPassword(<?= $id; ?>);"  class="btn btn-primary btn-flat"><span class="txt-white fa fa-refresh"></span> Reset Password</button>
                    </div>
                    <?php
                  }
                  ?>
                  <div style="float: right;">
                    <button class="btn btn-success btn-flat" type="submit"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.panel-body -->
          </div>
          <!-- /.panel -->

          <!-- /.panel -->
        </div>
        <!-- <div class="col-md-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Log Activity</h3>
            </div>
            <div class="panel-body">
                <div id="mydiv" class="table-responsive"></div>
            </div>
          </div>
        </div> -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-reset-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 9999">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Reset Password </h4>
        </div>
        <form action="<?= base_url('master/user/update') ?>" id="uploads" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="">Masukkan Password Baru</label>
              <input type="password" name="new_password" class="form-control" id="new_password">
            </div>
            <div class="form-group">
              <label for="">Konfirmasi Password Baru</label>
              <input type="password" name="confirm_password" class="form-control" id="confirm_password">
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id" id="id_reset_password">
            <button type="button" onclick="sendNewPassword()" class="btn btn-primary" id="send-btns"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function selectRole(role) {
    $('#ktk-departemen').hide();
    $('#ktk-jabatan').hide();

    if (role=='20') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').hide();
    } else if(role=='22') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').hide();
    } else if(role=='21') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').show();
    }
  }

  selectRole('<?= $user_data['role_id'] ?>');

    function reseterror() {
      // body...
      $('.show_error').html("");
    }
  // function loaddatas() {
  //       $("#mydiv").html("");

  //     var html = '<table class="table table-condensed table-hover table-bordered" id="mytable">'+
  //              '<thead>'+
  //              '  <tr class="bg-success">'+
  //              '    <th style="width:40px;">No</th>'+
  //              '    <th>Date</th>'+
  //              '    <th>IP</th>'+
  //              '    <th>Link</th>'+
  //              '    <th>Post</th>'+
  //              '    <th>Get</th>'+
  //              // '    <th style="width:150px;">Edit/Delete</th>'+
  //              '  </tr>'+
  //              '</thead>'+
  //              '<tbody>'+
  //              '  '+
  //              '</tbody>'+
  //             '</table>';
  //       $("#mydiv").html(html);

  //       loaddata();
  // }


  /*  function loaddata() {
    var t = $("#mytable").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#mytable_filter input')
        .off('.DT')
        .on('keyup.DT', function(e) {
          if (e.keyCode == 13) {
            api.search(this.value).draw();
          }
        });
      },
      oLanguage: {
        sProcessing: "loading..."
      },
      processing: true,
      serverSide: true,
      ajax: {"url": "<?= base_url('master/user/json_activity') ?>/<?= $user_data['id'] ?>", "type": "POST"},
        columns: [
          {"data": "ip","orderable": false},
          {"data": "created_at"},
          {"data": "ip"},
          {"data": "link"},
          {"data": "post"},
          {"data": "get"},
          // {   "data": "view",
          // "orderable": false
          // }
        ],
      order: [[1, 'asc']],
      columnDefs : [
        // { targets : [1],
        //   render : function (data, type, row) {
        //     return '<object data="<?= base_url('') ?>'+row['dir']+'" type="image/png" style="width: 70px;">'+
        //            '<img src="https://react-bootstrap.github.io/thumbnail.png" alt="example" style="width: 70px;">'+
        //            '</object>';
        //   }
        // }
      ],
       rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
    });
    }

    loaddatas();
    */
  
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
                $("#send-btn").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',true);
                form.find(".show_error").slideUp().html("");

            },
            success: function(response, textStatus, xhr) {
                // alert(mydata);
               var str = response;
                if (str.indexOf("Success Send Data") != -1){
                    form.find(".show_error").hide().html(response).slideDown("fast");
                    $("#send-btn").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
                    loaddatas();
                    // document.getElementById('upload').reset();
                     $('#upload')[0].reset();
                    $("#addsite").modal('hide');
            
                }else{
                    form.find(".show_error").hide().html(response).slideDown("fast");
                    $("#send-btn").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            }
        });
        return false;
        });


            // body...
        $('#loadingDiv2').hide().ajaxStart( function() {
        $(this).show();  // show Loading Div
        } ).ajaxStop ( function(){
          $(this).hide(); // hide loading div
        });

     function edit(id) {
      $("#editsite").modal('show');
      $("#data-update").load('<?= base_url('master/user/edit') ?>/'+id);
     }


     $("#uploads").submit(function(){
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
                $("#send-btns").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled',true);
                form.find(".show_error").slideUp().html("");

            },
            success: function(response, textStatus, xhr) {
                // alert(mydata);
               var str = response;
                if (str.indexOf("Success Send Data") != -1){
                    form.find(".show_error").hide().html(response).slideDown("fast");
                    $("#send-btns").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
                    loaddatas();
                    // document.getElementById('upload').reset();
                     $('#uploads')[0].reset();
                    $("#editsite").modal('hide');
            
                }else{
                    form.find(".show_error").hide().html(response).slideDown("fast");
                    $("#send-btns").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            }
        });
        return false;
        });

     function hapus(id) {

      var url = "<?= base_url('master/user/delete') ?>/"+id;
      if (confirm('Are you sure delete this data ?')) {
      window.location.href = url;
    } else {
        return false
    }
     }

    function resetPassword(id) {
      $("#id_reset_password").val(id).change();
      $("#modal-reset-password").modal();
    }

    function sendNewPassword() {
      let new_password = $("#new_password").val()
      let confirm_password = $("#confirm_password").val()

      if (new_password == '' || confirm_password == '') {
        Swal.fire({
          title: "Oppss!",
          text: "Field cannot be empty.",
          icon: "error"
        });
      } else {
        let id = $("#id_reset_password").val()
        $.post('<?= base_url('master/user/resetPassword') ?>', {
          id: id,
          new_password: new_password,
          confirm_password: confirm_password
        }, function(result) {
          let json_result = JSON.parse(result)
          Swal.fire({
            title: json_result.status,
            text: json_result.message,
            icon: json_result.status
          });
          if (json_result.status == 'success') {
            $("#new_password").val('').change()
            $("#confirm_password").val('').change()
            $("#modal-reset-password").modal('hide')
          }
        })
      }
    }
  </script>