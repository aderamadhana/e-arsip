<div class="show_error"></div>
<input type="hidden" name="ids" value="<?= $user['id'] ?>">
<input type="hidden" name="username" value="<?= $user['username'] ?>">
<input type="hidden" name="email" value="<?= $user['email'] ?>">

<small>Username</small>
<input name="dt[username]" type="text" class="form-control" value="<?= $user['username'] ?>" />

<small>Email</small>
<input name="dt[email]" type="text" class="form-control" value="<?= $user['email'] ?>" />

<small>Password</small>
<input name="password" type="password" class="form-control" placeholder="****************" />

<small>Confirm Password</small>
<input name="password_confirmation_field" type="password" class="form-control" placeholder="****************" />

<small>Name</small>
<input name="dt[name]" type="text" class="form-control" value="<?= $user['name'] ?>" />

<small>Role</small>
<select class="form-control" id="select-role-edit" name="dt[role_id]" onchange="selectRoleEdit(this.value)">
  <?php
  $res =  $this->mymodel->selectData('role');
  foreach ($res as $role) {
  ?>
    <option value="<?= $role['id'] ?>" <?php if ($user['role_id'] == $role['id']) {
                                          echo "selected";
                                        } ?>><?= $role['role'] ?></option>
  <?php } ?>
</select>

<div id="ktk-departemen">
  <small>Departemen</small>
  <!-- <input name="dt[departemen]" type="text" class="form-control" value="<?= $user['departemen'] ?>" /> -->
  <select name="dt[departemen]" class="form-control">
    <option value="">--Departemen--</option>
    <?php
    $departemen = $this->mymodel->selectWhere('m_departemen', array('status' => 'ENABLE'));
    foreach ($departemen as $key => $value) : ?>
      <option value="<?= $value['id'] ?>" <?= ($user['departemen'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama'] ?></option>
    <?php endforeach ?>
  </select>
</div>

<div id="ktk-jabatan">
  <small>Jabatan</small>
  <input id="input-jabatan-edit" name="dt[jabatan]" type="hidden" class="form-control" / value="<?= $user['jabatan'] ?>">
  <select id="select-jabatan-id-edit" name="dt[jabatan_id]" class="form-control" style="width: 100%" onchange="$('#input-jabatan-edit').val($('#select-jabatan-id-edit option:selected').text()).change()">
    <option value="">--Jabatan--</option>
  </select>
</div>
  
  <div id="ktk-komite-edit">
    <?php 

      if ($user['komite_id'] != '') {
        $komite = explode(",", $user['komite_id']);
        $jml_komite = sizeof($komite);
      }else{
        $komite = array();
        $jml_komite = 1;
      }

    ?>
    <div class="row">
      <div class="col-md-12">
        <small>Komite</small>
        <input type="hidden" id="jml_komite_edit" value="<?= $jml_komite ?>">
      </div>
    </div>
    <?php if ($jml_komite > 1) {
      
      $no_komite = 1;
      foreach ($komite as $komite_rec) {
          
          if ($no_komite == '1') { ?>
            <div class="row">
              <div class="col-md-10">
                <select name="komite_id[]" class="form-control komite_id" id="komite-edit">
                  <option value="">--Komite--</option>
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-primary" onclick="addKomite_edit()"><i class="fa fa-plus"></i></button>
                <br>
              </div>
            </div>

            <script type="text/javascript">
              var role = "<?= $user['role_id'] ?>";

              $.post('<?= base_url('master/user/selectKomite') ?>', {
                  role: role
              }, function(result) {
                let datanya = JSON.parse(result);
                $.each(datanya, function(key, value) {
                  $("#komite-edit").append($('<option>', {
                    text: value.komite,
                    value: value.id
                  }));

                  $("#komite-edit").val("<?= $komite_rec ?>").change();

                });
              });
            </script>

          <?php }else{ ?>

            <div class="row" id="row-komite-edit-<?= $no_komite ?>">
              <div class="col-md-10">
                <select name="komite_id[]" class="form-control komite_id" id="komite-id-edit-<?= $no_komite ?>">
                  <option value="">--Komite--</option>
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-danger" onclick="remove_komite_edit('<?= $no_komite ?>')"><i class="fa fa-minus"></i></button>
              </div>
            </div>

            <script type="text/javascript">
              var role = "<?= $user['role_id'] ?>";

              $.post('<?= base_url('master/user/selectKomite') ?>', {
                  role: role
              }, function(result) {
                let datanya = JSON.parse(result);
                $.each(datanya, function(key, value) {
                  $("#komite-id-edit-<?= $no_komite ?>").append($('<option>', {
                    text: value.komite,
                    value: value.id
                  }));

                  $("#komite-id-edit-<?= $no_komite ?>").val("<?= $komite_rec ?>").change();

                });
              });
            </script>

          <?php }

      $no_komite++;}

    }else{ ?>
      <div class="row">
        <div class="col-md-10">
          <select name="komite_id[]" class="form-control komite_id" id="komite-add">
            <option value="">--Komite--</option>
          </select>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-primary" onclick="addKomite_edit()"><i class="fa fa-plus"></i></button>
          <br>
        </div>
      </div>
    <?php } ?>
  </div>

<small>Akses Login</small>
<select name="dt[is_login]" class="form-control" id="">
  <option value="">--Akses Login--</option>
  <option value="1" <?= ($user['is_login'] == '1') ? 'selected' : ''; ?>>YA</option>
  <option value="0" <?= ($user['is_login'] == '0') ? 'selected' : ''; ?>>TIDAK</option>
</select>

<small>Description</small>
<textarea class="form-control" name="dt[desc]"><?= $user['desc'] ?></textarea>
<br>

<?php
if ($file['dir'] != "") {
  $types = explode("/", $file['mime']);
  if ($types[0] == "image") {
?>
    <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">
    <br>
  <?php } else { ?>
    <i class="fa fa-file fa-5x text-danger"></i>
    <br>
    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>
    <br>
    <br>
  <?php } ?>
<?php } ?>
<label for="form-file">File</label>
<input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

<script>
  function selectRoleEdit(role) {
    $('#ktk-departemen').hide();
    $('#ktk-jabatan').hide();
    $("#input-jabatan-edit").val('').change()

    //komite
    $('#ktk-komite-edit').hide();

    if (role == '20' || role == '21') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').show();
      $("#select-jabatan-id-edit option[value!='']").remove()
      let role_name = $("#select-role-edit option:selected").text()
      console.log(role_name)
      $.each(decoded_json_jabatan[role_name], function(key, value) {
        $("#select-jabatan-id-edit").append($('<option>', {
          text: value.jabatan,
          value: value.id
        }))
      })
      $("#select-jabatan-id-edit").val('<?= $user['jabatan_id'] ?>').change()
    } else if (role == '22') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').hide();
    } else if ((role == '25') || (role == '26')) {
      $('#ktk-komite-edit').show();

      $.post('<?= base_url('master/user/selectKomite') ?>', {
          role: role
      }, function(result) {
        let datanya = JSON.parse(result);
        $.each(datanya, function(key, value) {
          $('.komite_id').append($('<option>', {
            text: value.komite,
            value: value.id
          }));
        });
      });
    }
  }

  function selectRoleView(role) {
    $('#ktk-departemen').hide();
    $('#ktk-jabatan').hide();
    $("#input-jabatan-edit").val('').change()

    //komite
    $('#ktk-komite-edit').hide();

    if (role == '20' || role == '21') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').show();
      $("#select-jabatan-id-edit option[value!='']").remove()
      let role_name = $("#select-role-edit option:selected").text()
      console.log(role_name)
      $.each(decoded_json_jabatan[role_name], function(key, value) {
        $("#select-jabatan-id-edit").append($('<option>', {
          text: value.jabatan,
          value: value.id
        }))
      })
      $("#select-jabatan-id-edit").val('<?= $user['jabatan_id'] ?>').change()
    } else if (role == '22') {
      $('#ktk-departemen').show();
      $('#ktk-jabatan').hide();
    } else if ((role == '25') || (role == '26')) {
      $('#ktk-komite-edit').show();
    }
  }

  selectRoleView('<?= $user['role_id'] ?>');

  function addKomite_edit() {
   
   var jml = $('#jml_komite_edit').val();
   var no_jml = Number(jml) + 1;

   var html_komite = '<div class="row komite_masuk" id="row-komite-edit-'+no_jml+'">'+
              '<div class="col-md-10">'+
                '<select name="komite_id[]" class="form-control" id="komite-id-edit-'+no_jml+'">'+
                  '<option value="">--Komite--</option>'+
                '</select>'+
              '</div>'+
              '<div class="col-md-1">'+
                '<button type="button" class="btn btn-danger" onclick="remove_komite_edit('+no_jml+')"><i class="fa fa-minus"></i></button>'+
              '</div>'
            '</div>';

    $('#ktk-komite-edit').append(html_komite);
    $('#jml_komite_edit').val(no_jml);

    var role = $('#select-role-edit').val();

    $.post('<?= base_url('master/user/selectKomite') ?>', {
        role: role
    }, function(result) {
      let datanya = JSON.parse(result);
      $.each(datanya, function(key, value) {
        $("#komite-id-edit-"+no_jml).append($('<option>', {
          text: value.komite,
          value: value.id
        }));
      });
    });

  }

  function remove_komite_edit(index) {
    var jml = $('#jml_komite_edit').val();
    var no_jml = Number(jml) - 1;

    $('#row-komite-edit-'+index).remove();

    $('#jml_komite_edit').val(no_jml);

  }

</script>