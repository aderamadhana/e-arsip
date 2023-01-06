<style>
  .mg-5 {
    margin-left: -5px !important;
    margin-right: -5px !important;
  }

  .mg-5>.col-md-3,
  .mg-5>.col-md-9 {
    padding-left: 5px !important;
    padding-right: 5px !important;
  }

  .table-custom {
    margin-bottom: 0px;
  }

  .table-custom>tbody>tr>td,
  .table-custom>tbody>tr>th {
    border: 1px solid #7d7d7d;
    vertical-align: middle;
  }

  .table-custom>tbody+tbody {
    border: none;
  }

  .tab-content {
    border: 1px solid #ddd;
    border-top: none;
    padding: 10px;
  }

  .nav-tabs {
    background: #efefef;
    border-radius: 4px 4px 0 0;
    border-bottom: none;
  }

  .nav-tabs>li>a {
    color: #333;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Vendor
      <small>Master</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">master</a></li>
      <li class="active">Vendor</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <form method="POST" action="<?= base_url('master/vendor/update') ?>" id="upload-create" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $vendor['id'] ?>">
      <!-- <form method="POST" action="<?= base_url('master/Vendor/store') ?>" id="upload-create" enctype="multipart/form-data"> -->
      <div class="row">
        <div class="col-xs-12">

          <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#1" aria-controls="awal" role="tab" data-toggle="tab" style="color:#000">Data Awal</a>
              </li>
              <li role="presentation">
                <a href="#2" aria-controls="kategori-lingkup" role="tab" style="color:#000" data-toggle="tab">Kategori</a>
              </li>
              <li role="presentation">
                <a href="#3" aria-controls="pemberi-sponsor" role="tab" style="color:#000" data-toggle="tab">Vendor/Konsultan</a>
              </li>

              <li role="presentation">
                <a href="#4" aria-controls="keterangan" role="tab" style="color:#000" data-toggle="tab">Keterangan</a>
              </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="1">
                <table class="table table-bordered table-condensed table-custom">
                  <tr style="background:#ddd">
                    <th colspan="4" class="text-center">Data Awal</th>
                  </tr>
                  <tr>
                    <td style="width:10%">Nama Kegiatan</td>
                    <td colspan="3">
                      <input type="text" class="form-control input-sm" id="form-nama" placeholder="Masukan Nama kegiatan" name="dt[nama_kegiatan]" value="<?= $vendor['nama_kegiatan'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Nama Vendor/Konsultan</td>
                    <td colspan="3">
                      <input type="text" class="form-control input-sm" id="form-nama" placeholder="Masukan Nama kegiatan" name="dt[nama]" value="<?= $vendor['nama'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Tanggal Pelaksanaan</td>
                    <td colspan="3">
                      <table class="table" style="padding: 0px;">
                        <tr>
                          <td>Tanggal Mulai</td>
                          <td>Tanggal Selesai</td>
                        </tr>
                        <tr>
                          <td><input type="text" class="form-control tgl input-sm" id="form-tanggal" placeholder="Masukan Tanggal Mulai" name="dt[tanggal]" value="<?= $vendor['tanggal'] ?>"></td>
                          <td><input type="text" class="form-control tgl input-sm" id="form-tanggal" placeholder="Masukan Tanggal Selesai" name="dt[tanggal_selesai]" value="<?= $vendor['tanggal_selesai'] ?>"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Penjelasan Singkat</td>
                    <td colspan="3">
                      <textarea name="dt[penjelasan_singkat]" class="form-control" rows="10"><?= $vendor['penjelasan_singkat'] ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Nilai Jasa Vendor/Konsultan</td>
                    <td colspan="3">
                      <input type="text" class="form-control input-sm money" name="dt[nilai_jasa]" id="" value="<?= $vendor['nilai_jasa'] ?>">
                    </td>
                  </tr>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="2">
                <table class="table table-bordered table-condensed table-custom">
                  <tr style="background: #ddd;">
                    <th colspan="4" class="text-center">Kategori</th>
                  </tr>
                  <tr>
                    <td style="width: 10%;">Department</td>
                    <td colspan="3">
                      <select name="dt[department_id]" class="form-control select2" id="form-department_id" style="width:100%" onchange="checkdepartment()">
                        <?php
                        $department = $this->mymodel->selectWhere('m_departemen', null);
                        foreach ($department as $department_record) {
                          if ($vendor['department_id'] == $department_record['id']) {
                            echo "<option value=" . $department_record['id'] . " selected>" . $department_record['nama'] . "</option>";
                          } else {
                            echo "<option value=" . $department_record['id'] . ">" . $department_record['nama'] . "</option>";
                          }
                        }
                        ?>
                        <!-- <option value="0" <?php if ($vendor['department_id'] == 0) echo "selected" ?>>Lainnya</option> -->
                      </select>
                      <input type="text" name="dt[department_nama]" class="form-control" id="form-department_nama" value="<?= $vendor['department_nama'] ?>">
                      <script>
                        function checkdepartment() {
                          let department = $("#form-department_id").val();
                          if (department == 0) $("#form-department_nama").show();
                          else $("#form-department_nama").hide();
                        }

                        checkdepartment()
                      </script>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;">Tipe</td>
                    <td colspan="3">
                      <select name="dt[kategori]" id="form-kategori" class="form-control" onchange="changekategori()">
                        <option value="consultant" <?= ($vendor['kategori'] == "consultant") ? 'selected' : '' ?>>Consultant</option>
                        <option value="vendor" <?= ($vendor['kategori'] == "vendor") ? 'selected' : '' ?>>Vendor</option>
                      </select>
                      <script>
                        function changekategori() {
                          let returnhtml;
                          if ($("#form-kategori").val() == "vendor") {
                            returnhtml = `<?php
                                          $tipe = $this->mymodel->selectWhere('tipe', ['kategori' => 'vendor']);
                                          foreach ($tipe as $tipe_record) {
                                            if ($vendor['tipe_id'] == $tipe_record['id']) {
                                              echo "<option value=" . $tipe_record['id'] . " selected data-kategori='" . $tipe_record['kategori'] . "'>" . $tipe_record['tipe'] . "</option>";
                                            } else {
                                              echo "<option value=" . $tipe_record['id'] . " data-kategori='" . $tipe_record['kategori'] . "'>" . $tipe_record['tipe'] . "</option>";
                                            }
                                          }
                                          ?>`;
                          } else {
                            returnhtml = `<?php
                                          $tipe = $this->mymodel->selectWhere('tipe', ['kategori' => 'consultant']);
                                          foreach ($tipe as $tipe_record) {
                                            if ($vendor['tipe_id'] == $tipe_record['id']) {
                                              echo "<option value=" . $tipe_record['id'] . " selected data-kategori='" . $tipe_record['kategori'] . "'>" . $tipe_record['tipe'] . "</option>";
                                            } else {
                                              echo "<option value=" . $tipe_record['id'] . " data-kategori='" . $tipe_record['kategori'] . "'>" . $tipe_record['tipe'] . "</option>";
                                            }
                                          }
                                          ?>`;
                          }

                          returnhtml += `<option value="0">Lainnya</option>`;

                          $("#form-tipe_id").html(returnhtml).trigger('change');
                        }
                        setTimeout(() => {
                          changekategori()
                        }, 1000);
                      </script>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;">Kategori</td>
                    <td colspan="3">
                      <select name="dt[tipe_id]" id="form-tipe_id" class="form-control select2" style="width:100%" onchange="checktipe()">

                        <option value="0" <?php if ($vendor['tipe_id'] == 0) echo "selected" ?>>Lainnya</option>
                      </select>
                      <input type="text" name="dt[tipe_nama]" class="form-control" id="form-tipe_nama" value="<?= $vendor['tipe_nama'] ?>">
                      <script>
                        function checktipe() {
                          let tipe = $("#form-tipe_id").val();
                          if (tipe == 0) $("#form-tipe_nama").show();
                          else $("#form-tipe_nama").hide();
                        }

                        checktipe()
                      </script>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;">PIC pelaksana</td>
                    <td colspan="3">
                      <select name="pic[]" class="form-control select2" style="width:100%" multiple="multiple">
                        <?php
                        $pic = json_decode($vendor['pic']);
                        $user = $this->mymodel->selectWhere('user', null);
                        foreach ($user as $user_record) {
                          if (in_array($user_record['id'], $pic)) {
                            echo "<option value=" . $user_record['id'] . " selected>" . $user_record['name'] . "</option>";
                          } else {
                            echo "<option value=" . $user_record['id'] . ">" . $user_record['name'] . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;">PIC Vendor/Konsultan</td>
                    <td colspan="3">
                      <input type="text" class="form-control" name="dt[pic_vendor]" id="" value="<?= $vendor['pic_vendor'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;">No HP PIC Vendor/Konsultan</td>
                    <td colspan="3">
                      <input type="text" class="form-control" name="dt[pic_nomor_vendor]" id="" value="<?= $vendor['pic_nomor_vendor'] ?>">
                    </td>
                  </tr>
                </table>

              </div>
              <div role="tabpanel" class="tab-pane" id="3">
                <table class="table table-bordered table-condensed table-custom">
                  <tr style="background:#ddd">
                    <th colspan="4" class="text-center">Vendor/Konsultan</th>
                  </tr>
                  <tr>
                    <td style="width:10%">Penjelasan Keuntungan</td>
                    <td colspan="3">
                      <textarea name="dt[penjelasan_keuntungan]" class="form-control" rows="10"><?= $vendor['penjelasan_keuntungan'] ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Upload File SPK</td>
                    <td colspan="3">
                      <input type="file" name="spk" id="" class="file-dokumen">
                      <?php if ($vendor['spk'] != "") { ?>
                        <br>
                        <a href="<?= $vendor['spk'] ?>" class="badge bg-green" target="_blank"><i class="fa fa-download"></i> Download</a>
                        <br>
                        <br>

                      <?php } ?>

                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Dokumen Pendukung</td>
                    <td colspan="3">
                      <h5>Upload bukti pertanggung jawaban</h5>
                      <table class="table table-condensed table-bordered table-hover">
                        <thead>
                          <tr style="background:#f3f3f3">
                            <th>Nama Dokumen</th>
                            <th>File</th>
                            <th style="width: 25px;"><button type="button" class="btn btn-success btn-xs" onclick="addrow()"><i class="fa fa-plus"></i></button></th>
                          </tr>
                        </thead>
                        <tbody id="body-files">
                          <?php
                          foreach (json_decode($vendor['files']) as $files) {
                          ?>
                            <tr>
                              <td><?= $files->name ?>
                                <input type="hidden" name="nama_files_old[]" value="<?= $files->name ?>" id="">
                                <input type="hidden" name="files_old[]" value="<?= $files->dir ?>" id="">
                              </td>
                              <td><a href="<?= base_url($files->dir) ?>" target="_blank"><?= $files->dir ?></a></td>
                              <td>
                                <a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                      <script>
                        function addrow() {
                          let rows = `
                                  <tr>
                                    <td>
                                      <input type="text" class="form-control input-sm" name="nama_files[]">
                                    </td>
                                    <td>
                                      <input type="file" name="files[]" class="file-dokumen">
                                    </td>
                                    <td>
                                       <a class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
                                    </td>
                                  </tr>
                                  `;
                          $("#body-files").append(rows)
                        }
                      </script>
                    </td>
                  </tr>

                </table>
              </div>

              <div role="tabpanel" class="tab-pane" id="4">
                <table class="table table-bordered table-condensed table-custom">
                  <tr style="background:#ddd">
                    <th colspan="4" class="text-center">Keterangan</th>
                  </tr>
                  <tr>
                    <td style="width:10%">Nominal Akhir</td>
                    <td colspan="3">
                      <input type="text" class="form-control input-sm money" name="dt[nominal_akhir]" id="" value="<?= $vendor['nominal_akhir'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Fee Termasuk Pajak ?</td>
                    <td colspan="3">
                      <input type="radio" name="dt[is_pajak]" value="1" <?= ($vendor['is_pajak'] == 1) ? 'checked' : '' ?>> Ya
                      <input type="radio" name="dt[is_pajak]" value="0" <?= ($vendor['is_pajak'] == 0) ? 'checked' : '' ?>> Tidak
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Upload File Penilaian Vendor/Konsultan</td>
                    <td colspan="3">
                      <?php if ($vendor['penilaian'] != "") { ?>
                        <a href="<?= $vendor['penilaian'] ?>" class="badge bg-green" target="_blank"><i class="fa fa-download"></i> Download</a>
                        <br>
                        <br>

                      <?php } ?>
                      <input type="file" name="penilaian" id="" class="file-dokumen">
                      <small style="color: red;">*Apabila dalam hal pemilihan vendor/konsultan dilakukan dengan cara pitching/Beauty Contest</small>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Termin Pembayaran</td>
                    <td colspan="3">
                      <select class="form-control" name="dt[termin_pembayaran]" id="sel-termin-pembayaran" onchange="getsetinformasitemrin()">
                        <option value="" selected="" disabled="">Pilih Termin</option>
                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                          <option value="<?= $i ?>" <?= ($vendor['termin_pembayaran'] == $i) ? "selected" : "" ?>><?= $i ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <?php
                  $tanggal_transfer = json_decode($vendor['tanggal_transfer'], true);
                  $bukti_transfer = json_decode($vendor['bukti_transfer'], true);
                  ?>

                  <?php
                  $no = 0;
                  for ($i = 1; $i <= 10; $i++) { ?>
                    <tr id="keterangan_informasi_pembayaran<?= $i ?>" style="display: none;" class="keterangan_informasi_pembayaran">
                      <td style="width:10%">Tanggal Transfer</td>
                      <td style="width: 40%">
                        <input type="text" class="form-control tgl" name="tanggal_transfer[]" id="" value="<?= $tanggal_transfer[$no] ?>" />
                      </td>
                      <td style="width:10%">Bukti Transfer</td>
                      <td style="width: 40%">
                        <input type="file" class="form-control" name="bukti_transfer<?= $i ?>" id="" />
                        <?php if ($bukti_transfer[$no]) { ?>
                          <a href="<?= base_url($bukti_transfer[$no]) ?>" target="_blank" class="btn btn-warning btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Unduh</a>
                        <?php $no++;
                        } ?>
                      </td>
                    </tr>
                  <?php } ?>
                  <script>
                    function getsetinformasitemrin() {
                      $('.keterangan_informasi_pembayaran').hide();
                      var termin = $('#sel-termin-pembayaran').val();
                      for (var i = 1; i <= termin; i++) {
                        $('#keterangan_informasi_pembayaran' + i).show();
                      }
                    }
                    getsetinformasitemrin();
                  </script>
                  <tr>
                    <td style="width:10%">Project/Kegiatan Terlaksana ?</td>
                    <td colspan="3">
                      <input type="radio" name="dt[is_kegiatan_terlaksana]" <?= ($vendor['is_kegiatan_terlaksana'] == 1) ? 'checked' : '' ?> value="1" onclick="terlaksana(this.value)"> Ya
                      <input type="radio" name="dt[is_kegiatan_terlaksana]" <?= ($vendor['is_kegiatan_terlaksana'] == 0) ? 'checked' : '' ?> value="0" onclick="terlaksana(this.value)"> Tidak
                    </td>
                    <script>
                      function terlaksana(dataterlaksana) {
                        if (dataterlaksana == 1) {
                          $('#tr-catatan-project').fadeOut();
                        } else {
                          $('#tr-catatan-project').fadeIn();
                        }
                        // alert(dataterlaksana);
                      }
                      terlaksana('<?= $vendor['is_kegiatan_terlaksana'] ?>');
                    </script>
                  </tr>
                  <tr id="tr-catatan-project">
                    <td style="width:10%">Catatan Project</td>
                    <td colspan="3">
                      <textarea name="dt[catatan_kegiatan]" class="form-control" id="" rows="10"><?= $vendor['catatan_kegiatan'] ?></textarea>
                      <small class="text-danger">*Kosongkan jika kegiatan terlaksana</small>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Dasar Pertimbangan Memilih Vendor/Konsultan</td>
                    <td colspan="3">
                      <textarea name="dt[dasar_pertimbangan]" class="form-control" id="" rows="10"><?= $vendor['dasar_pertimbangan'] ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Penilaian Hasil Akhir Vendor/Konsultan</td>
                    <td colspan="3">
                      <select name="dt[penilaian_hasil]" id="input-penilaian_hasil" class="form-control">
                        <option value="Very Good" <?= ($vendor['penilaian_hasil'] == "Very Good") ? 'selected' : '' ?>>Very Good</option>
                        <option value="Good" <?= ($vendor['penilaian_hasil'] == "Good") ? 'selected' : '' ?>>Good</option>
                        <option value="Netral" <?= ($vendor['penilaian_hasil'] == "Netral") ? 'selected' : '' ?>>Netral</option>
                        <option value="Bad" <?= ($vendor['penilaian_hasil'] == "Bad") ? 'selected' : '' ?>>Bad</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:10%">Keterangan Penilaian</td>
                    <td colspan="3">
                      <textarea name="dt[keterangan_penilaian]" class="form-control" id="" rows="10"><?= $vendor['keterangan_penilaian'] ?></textarea>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <a href="<?= base_url('master/Vendor') ?>" class="btn btn-default">
            << Kembali Ke Vendor</a>
              <div class="pull-right">
                <!-- <button type="submit" name="dt[cv_status]" value="draft" type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Draft</button> -->
                <input type="hidden" name="tab_index">
                <button type="submit" class="btn btn-primary btn-sm btn-send">SIMPAN</button>
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
<script>
  $(function() {
    // here we are looking for our tab header
    hash = window.location.hash;
    elements = $('a[href="' + hash + '"]');
    if (elements.length === 0) {
      $("ul.tabs li:first").addClass("active").show(); //Activate first tab
      $(".tab_content:first").show(); //Show first tab content
    } else {
      elements.click();
    }
    $("input[name='tab_index']").val(hash).change()
  });
</script>
<script type="text/javascript">
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

  // $("#upload-create").submit(function(){
  //         var form = $(this);
  //       var mydata = new FormData(this);
  //       $.ajax({
  //             type: "POST",
  //           url: form.attr("action"),
  //           data: mydata,
  //           cache: false,
  //           contentType: false,
  //           processData: false,
  //           beforeSend : function(){
  //                 $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
  //               form.find(".show_error").slideUp().html("");
  //           },
  //           success: function(response, textStatus, xhr) {

  //                 // alert(mydata);
  //              var str = response;
  //               if (str.indexOf("success") != -1){
  //                     Swal.fire({
  //                         title: "It works!",
  //                         text: "Successfully added data",
  //                         icon: "success"
  //                     });
  //                     // form.find(".show_error").hide().html(response).slideDown("fast");
  //                   setTimeout(function(){ 
  //                        window.location.href = "<?= base_url('master/Vendor') ?>";
  //                   }, 1000);
  //                   $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
  //               }else{
  //                   Swal.fire({
  //                     title: "Oppss!",
  //                     html: str,
  //                     icon: "error"
  //                   });
  //                     // form.find(".show_error").hide().html(response).slideDown("fast");
  //                   $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

  //               }
  //           },
  //           error: function(xhr, textStatus, errorThrown) {
  //               console.log(xhr);
  //               Swal.fire({
  //                   title: "Oppss!",
  //                   text: xhr,
  //                   icon: "error"
  //               });
  //               $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
  //               // form.find(".show_error").hide().html(xhr).slideDown("fast");
  //           }
  //       });
  //       return false;

  //   });
</script>
<script>
  $('.file-dokumen').change(function() {
    // const fi = this; 
    // Check if any file is selected. 
    if (this.files.length > 0) {
      for (const i = 0; i <= this.files.length - 1; i++) {

        const fsize = this.files.item(i).size;
        const file = Math.round((fsize / 1024));
        // The size of the file. 
        if (file > 40000) {
          alert("Ukuran file melebihi 40MB");
          $('.btn-send').fadeOut();
        } else {
          $('.btn-send').fadeIn();
        }
      }
    }
  });
</script>