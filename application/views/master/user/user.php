<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Master
      <small>User</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Master</a></li>
      <li class="active">User</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <?php
              if ($this->session->userdata('role_slug') == 'super_admin') :
              ?>
                <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addsite" onclick="reseterror()"><i class="fa fa-plus"></i> Add User</button>
              <?php
              endif;
              ?>
            </h3>
            <div class="pull-right">
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <?php if ($this->session->flashdata('message') != "") { ?>
              <div class="alert alert-<?= @$this->session->flashdata('class') ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('message') ?>
              </div>
            <?php } ?>
            <div class="show_error"></div>
            <div class="table-responsive">
              <div id="mydiv"></div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- modal review -->
<div class="modal fade" id="addsite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="z-index: 9999">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New User </h4>
      </div>

      <form action="<?= base_url('master/user/store') ?>" id="upload" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="show_error"></div>

          <small>Username</small>
          <input name="dt[username]" type="text" class="form-control" />

          <small>Email</small>
          <input name="dt[email]" type="email" class="form-control" />

          <small>Password</small>
          <input name="dt[password]" type="password" class="form-control" />

          <small>Confirm Password</small>
          <input name="password_confirmation_field" type="password" class="form-control" placeholder="" />

          <small>Name</small>
          <input name="dt[name]" type="text" class="form-control" />

          <small>Role</small>
          <select class="form-control" name="dt[role_id]" id="role_id" onchange="selectRoleAdd(this.value)">
            <option value="">--Role--</option>
            <?php
            $res =  $this->mymodel->selectData('role');
            foreach ($res as $role) {
            ?>
              <option value="<?= $role['id'] ?>"><?= $role['role'] ?></option>
            <?php } ?>
          </select>

          <div id="ktk-departemen-add">
            <small>Departemen</small>
            <select name="dt[departemen]" class="form-control">
              <option value="">--Departemen--</option>
              <?php
              $departemen = $this->mymodel->selectWhere('m_departemen', array('status' => 'ENABLE'));
              foreach ($departemen as $key => $value) : ?>
                <option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <div id="ktk-jabatan-add">
            <small>Jabatan</small>
            <input id="input-jabatan" name="dt[jabatan]" type="hidden" class="form-control" />
            <select id="select-jabatan-id" name="dt[jabatan_id]" class="form-control" style="width: 100%" onchange="$('#input-jabatan').val($('#select-jabatan-id option:selected').text()).change()">
              <option value="">--Jabatan--</option>
            </select>
          </div>

          <div id="ktk-komite-add">
            <div class="row">
              <div class="col-md-12">
                <small>Komite</small>
                <input type="hidden" id="jml_komite" value="1">
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <select name="komite_id[]" class="form-control" id="komite-add">
                  <option value="">--Komite--</option>
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-primary" onclick="addKomite()"><i class="fa fa-plus"></i></button>
                <br>
              </div>
            </div>
          </div>

          <small>Akses Login</small>
          <select name="dt[is_login]" class="form-control" id="">
            <option value="">--Akses Login--</option>
            <option value="1">YA</option>
            <option value="0">TIDAK</option>
          </select>

          <small>Description</small>
          <textarea class="form-control" name="dt[desc]"></textarea>

          <small>File</small>
          <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="send-btn"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editsite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="z-index: 9999">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User </h4>
      </div>
      <form action="<?= base_url('master/user/update') ?>" id="uploads" enctype="multipart/form-data">
        <div class="modal-body" id="data-update">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="send-btns"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

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

<!-- end modal review -->
<script type="text/javascript">
  var decoded_json_jabatan = JSON.parse('<?= $encoded_json_jabatan ?>');
  console.table(decoded_json_jabatan);

  function reseterror() {
    // body...
    $('.show_error').html("");
  }

  function loaddatas() {
    $("#mydiv").html("");
    var html = '<table class="table table-condensed table-hover table-bordered" id="mytable">' +
      '<thead>' +
      '  <tr>' +
      '    <th style="width:40px;">No</th>' +
      '    <th>Username</th>' +
      '    <th>Name</th>' +
      '    <th style="width:100px;">Role</th>' +
      '    <th style="width:50px;">Jabatan</th>' +
      '    <th style="width:50px;">Departement</th>' +
      '    <th style="width:50px;">Akses Login</th>' +
      '    <th>Description</th>' +
      '    <th style="width:320px;">Edit/Delete</th>' +
      '  </tr>' +
      '</thead>' +
      '<tbody>' +
      '  ' +
      '</tbody>' +
      '</table>';
    $("#mydiv").html(html);
    loaddata();
  }

  function selectRoleAdd(role) {
    $('#ktk-departemen-add').hide();
    $('#ktk-jabatan-add').hide();
    $("#input-jabatan").val('').change()

    //komite
    $('#ktk-komite-add').hide();

    // 20 = kepala department,21 = officer
    if (role == '20' || role == '21') {
      $('#ktk-departemen-add').show();
      $('#ktk-jabatan-add').show();
      $("#select-jabatan-id option[value!='']").remove()
      let role_name = $("select[name='dt[role_id]'] option:selected").text()
      $.each(decoded_json_jabatan[role_name], function(key, value) {
        $("#select-jabatan-id").append($('<option>', {
          text: value.jabatan,
          value: value.id
        }))
      })
    } else if (role == '22') {
      $('#ktk-departemen-add').show();
      $('#ktk-jabatan-add').hide();
    } else if ((role == '25') || (role == '26')) {
      $("#komite-add").empty();

      $("#komite-add").append($('<option>', {
        text: '--Komite--',
        value: ''
      }));

      $.post('<?= base_url('master/user/selectKomite') ?>', {
        role: role
      }, function(result) {
        let datanya = JSON.parse(result);
        $.each(datanya, function(key, value) {
          $("#komite-add").append($('<option>', {
            text: value.komite,
            value: value.id
          }));
        });
      });

      $('#ktk-komite-add').show();
    }
  }
  selectRoleAdd();

  function loaddata() {
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
      ajax: {
        "url": "<?= base_url('master/user/json') ?>/",
        "type": "POST"
      },
      columns: [{
          "data": "id",
          "orderable": false
        },
        {
          "data": "username"
        },
        {
          "data": "name"
        },
        {
          "data": "role"
        },
        {
          "data": "jabatan"
        },
        {
          "data": "nama_departement"
        },
        {
          "data": "is_login"
        },
        {
          "data": "desc"
        },
        {
          "data": "view",
          "orderable": false
        }
      ],
      order: [
        [0, 'asc']
      ],
      columnDefs: [
        // { targets : [1],
        //   render : function (data, type, row) {
        //     if(row['dir']=="" || row['dir']==null){
        //          var a = '<object data="https://www.library.caltech.edu/sites/default/files/styles/headshot/public/default_images/user.png?itok=1HlTtL2d" style="width: 70px;">'+
        //                '<img src="https://www.library.caltech.edu/sites/default/files/styles/headshot/public/default_images/user.png?itok=1HlTtL2d" type="image/png" alt="example" style="width: 70px;">'+
        //                '</object>';
        //       }else{
        //         var a ='<object data="<?= base_url('') ?>'+row['dir']+'" style="width: 70px;">'+
        //                '<img src="https://www.library.caltech.edu/sites/default/files/styles/headshot/public/default_images/user.png?itok=1HlTtL2d" type="image/png" alt="example" style="width: 70px;">'+
        //                '</object>';
        //       }
        //       return a;
        //   }
        // },
        {
          targets: [6],
          render: function(data, type, row) {
            if (row['is_login'] == "1") {
              var a = 'YA';
            } else {
              var a = 'TIDAK';
            }
            return a;
          }
        },
        {
          targets: [8],
          render: function(data, type, row) {
            let role_slug = '<?= $this->session->userdata("role_slug") ?>';
            let html = row['view']
            if (role_slug == 'kepala_departemen' && row['is_login'] == 1) {
              html = '<button onclick="resetPassword(' + row['id'] + ')"  class="btn btn-primary btn-flat btn-sm"><span class="txt-white fa fa-refresh"></span> Reset Password</button>'
            }
            return html
          }
        }
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

  $("#upload").submit(function() {
    var mydata = new FormData(this);
    var form = $(this);
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: mydata,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $("#send-btn").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled', true);
        form.find(".show_error").slideUp().html("");
      },
      success: function(response, textStatus, xhr) {
        // alert(mydata);
        var str = response;
        if (str.indexOf("Success Send Data") != -1) {
          form.find(".show_error").hide().html(response).slideDown("fast");
          $("#send-btn").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
          loaddatas();
          // document.getElementById('upload').reset();
          $('#upload')[0].reset();
          $("#addsite").modal('hide');
        } else {
          form.find(".show_error").hide().html(response).slideDown("fast");
          $("#send-btn").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
        }

        $('.komite_masuk').remove();
        $('#jml_komite').val('1');

      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr);
      }
    });
    return false;
  });

  // body...
  $('#loadingDiv2').hide().ajaxStart(function() {
    $(this).show(); // show Loading Div
  }).ajaxStop(function() {
    $(this).hide(); // hide loading div
  });

  function edit(id) {
    $("#editsite").modal('show');
    $("#data-update").load('<?= base_url('master/user/edit') ?>/' + id);
  }

  $("#uploads").submit(function() {
    var mydata = new FormData(this);
    var form = $(this);
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: mydata,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $("#send-btns").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Processing...").attr('disabled', true);
        form.find(".show_error").slideUp().html("");
      },
      success: function(response, textStatus, xhr) {
        // alert(mydata);
        var str = response;
        if (str.indexOf("Success") != -1) {
          form.find(".show_error").hide().html(response).slideDown("fast");
          $("#send-btns").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
          loaddatas();
          // document.getElementById('upload').reset();
          $('#uploads')[0].reset();
          $("#editsite").modal('hide');
        } else {
          form.find(".show_error").hide().html(response).slideDown("fast");
          $("#send-btns").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr);
      }
    });
    return false;
  });

  function hapus(id) {
    var url = "<?= base_url('master/user/delete') ?>/" + id;
    if (confirm('Apakah anda yakin ingin hapus data ini ?')) {
      window.location.href = url;
    } else {
      return false
    }
  }

  function jumperLogin(id) {
    var url = "<?= base_url('login/jumperLogin') ?>/" + encodeId(id);
    if (confirm('Apakah anda yakin ingin login sebagai user ini ?')) {
      window.location.href = url;
    } else {
      return false
    }
  }

  function activateUser(id) {
    var r = confirm("Approve user berikut?");
    if (r == true) {
      $.post('<?= base_url("master/user/activateUser") ?>', {
        id: id
      }, function(res) {
        location.reload()
      })
    }
  }

  function resetPassword(id) {
    $("#id_reset_password").val(id).change()
    $("#modal-reset-password").modal()
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

  function addKomite() {
   
   var jml = $('#jml_komite').val();
   var no_jml = Number(jml) + 1;

   var html_komite = '<div class="row komite_masuk" id="row-komite-'+no_jml+'">'+
              '<div class="col-md-10">'+
                '<select name="komite_id[]" class="form-control" id="komite-id-'+no_jml+'">'+
                  '<option value="">--Komite--</option>'+
                '</select>'+
              '</div>'+
              '<div class="col-md-1">'+
                '<button type="button" class="btn btn-danger" onclick="remove_komite('+no_jml+')"><i class="fa fa-minus"></i></button><br>'+
              '</div>'
            '</div>';

    $('#ktk-komite-add').append(html_komite);
    $('#jml_komite').val(no_jml);

    var role = $('#role_id').val();

    $.post('<?= base_url('master/user/selectKomite') ?>', {
        role: role
    }, function(result) {
      let datanya = JSON.parse(result);
      $.each(datanya, function(key, value) {
        $("#komite-id-"+no_jml).append($('<option>', {
          text: value.komite,
          value: value.id
        }));
      });
    });

  }

  function remove_komite(index) {
    var jml = $('#jml_komite').val();
    var no_jml = Number(jml) - 1;

    $('#row-komite-'+index).remove();

    $('#jml_komite').val(no_jml);

  }

</script>