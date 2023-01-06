  <form method="POST" action="<?= base_url('master/M_posisi_jabatan/store') ?>" id="upload-create" enctype="multipart/form-data">
    <div class="show_error"></div>
    <div class="form-group">
      <label for="form-mpj_mp_id">Pilih Posisi</label>
      <select name="dt[mpj_mp_id]" class="form-control select2" style="width:100%" id="form-mpj_mp_id">
        <?php
        $m_posisi = $this->mymodel->selectWhere('m_posisi', null);
        foreach ($m_posisi as $m_posisi_record) {
          echo "<option value=" . $m_posisi_record['mp_id'] . ">" . $m_posisi_record['mp_nama'] . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label for="form-mpj_nama">Nama Jabatan</label>
      <input type="text" class="form-control" id="form-mpj_nama" placeholder="Masukan Nama Jabatan" name="dt[mpj_nama]">
    </div>

    <div class="form-group">
      <label for="form-mpj_singkatan">Nama Singkatan</label>
      <input type="text" class="form-control" id="form-mpj_singkatan" placeholder="Masukan Nama Singkatan" name="dt[mpj_singkatan]">
    </div>


    <div class="form-group">
      <label for="form-file_ttd">File Tanda Tangan</label>
      <input type="file" name="file_ttd" id="file_ttd" class="form-control" accept="images/*">
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
      <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
    </div>
  </form>

  <!-- /.content-wrapper -->
  <script type="text/javascript">
    $(".money").simpleMoneyFormat();
    tinymce.remove();
    tinymce.init({
      selector: '.tinymce',
      plugins: "localautosave",
      toolbar1: "localautosave",
      las_seconds: 15,
      las_nVersions: 15,
      las_keyName: "LocalAutoSave",
      las_callback: function() {
        var content = this.content; //content saved
        var time = this.time; //time on save action
      }
    });

    $("#upload-create").submit(function() {
      var form = $(this);
      var mydata = new FormData(this);
      $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: mydata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);
        },
        success: function(response, textStatus, xhr) {
          // alert(mydata);
          var str = response;
          if (str.indexOf("success") != -1) {
            Swal.fire({
              title: "It works!",
              text: "Successfully added data",
              icon: "success"
            });

            setTimeout(function() {
              $("#mytable tbody").prepend('<tr class="bg-warning">' +
                '   <td>#</td>' +
                '   <td></td>' +
                '   <td>' + $("#form-mpj_mp_id").val() + '</td>' +
                '   <td>' + $("#form-mpj_nama").val() + '</td>' +
                '   <td>' + $("#form-mpj_singkatan").val() + '</td>' +
                '   <td></td>' +
                '   <td><label class="badge bg-orange">Created</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label></td>' +
                ' </tr>');
              $("#modal-form").modal('hide');
            }, 1000);
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          } else {
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
            Swal.fire({
              title: "Oppss!",
              html: str,
              icon: "error"
            });
          }
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
          Swal.fire({
            title: "Oppss!",
            text: xhr,
            icon: "error"
          });
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
        }
      });
      return false;

    });
    $('.select2').select2();
    $('.tgl').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
  </script>