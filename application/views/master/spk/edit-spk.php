<?php
$datafile = json_decode($spk['file_attachment']);
$path = str_replace('/', '_', $spk['nomor_spk']);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            SPK
            <small>Master</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">master</a></li>
            <li class="active">SPK</li>
        </ol>
    </section>
    <style>
        .table-custom {
            border: 1px solid #7d7d7d;
        }

        .table-custom>tbody>tr>td,
        .table-custom>tbody>tr>th {
            border: 1px solid #7d7d7d;
            vertical-align: middle;
        }

        .table-custom>thead>tr>td,
        .table-custom>thead>tr>th {
            border: 1px solid #7d7d7d;
            vertical-align: middle;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <a href="<?= base_url('master/spk/pdfprint/' . $spk['id']) ?>" class="btn btn-block btn-danger" target="_blank"><i class="fa fa-print"></i> Print Spk </a>
            </div>
            <div class="col-md-2">
                <a href="<?= base_url('master/spk/printtopdf/' . $spk['id']) ?>" class="btn btn-block btn-success" target="_blank"><i class="fa fa-download"></i> Download Spk </a>
            </div>
            <div class="col-md-12">
                <form method="POST" action="<?= base_url('master/spk/update') ?>" id="upload-create" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $spk['id'] ?>" id="">
                    <div class="panel">
                        <div class="panel-body">
                            <table class="table table-bordered table-condensed table-custom">
                                <thead>
                                    <tr style="background:#ddd">
                                        <th colspan="4">SURAT PERINTAH KERJA (SPK)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:10%">NOMOR SPK</td>
                                        <td style="width:40%">
                                            <input class="form-control" type="text" name="dt[nomor_spk]" value="<?= $spk['nomor_spk'] ?>">
                                        </td>
                                        <td style="width:10%">TANGGAL SPK</td>
                                        <td style="width:40%">
                                            <input class="form-control tgl" type="text" name="dt[tanggal_spk]" value="<?= $spk['tanggal_spk'] ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered table-condensed table-custom">
                                <thead>
                                    <tr style="background:#ddd">
                                        <th colspan="4">PENERIMA TUGAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:20%">NAMA PERUSAHAAN</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[nama_perusahaan]" value="<?= $spk['nama_perusahaan'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%">ALAMAT PERUSAHAAN</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[alamat_perusahaan]" value="<?= $spk['alamat_perusahaan'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%">NO. TELP / FACSIMILE</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[telp_facsimile]" value="<?= $spk['telp_facsimile'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%">SURAT PENAWARAN</td>
                                        <td style="width:30%">
                                            <input class="form-control" type="text" name="dt[surat_penawaran]" value="<?= $spk['surat_penawaran'] ?>">
                                        </td>
                                        <td style="width:20%">TGL</td>
                                        <td style="width:30%">
                                            <input class="form-control tgl" type="text" name="dt[tanggal_surat_penawaran]" value="<?= $spk['tanggal_surat_penawaran'] ?>">
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr style="background:#ddd">
                                        <th colspan="4">RUANG LINGKUP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="1">
                                            JENIS PEKERJAAN
                                        </td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[jenis_pekerjaan]" value="<?= $spk['jenis_pekerjaan'] ?>">
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="1">
                                            RUANG LINGKUP PEKERJAAN 
                                        </td>
                                        <td colspan="3">
                                            <textarea  class="form-control" id="" name="dt[ruang_lingkup_pekerjaan]" rows="5"><?= $spk['ruang_lingkup_pekerjaan'] ?></textarea>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="1">
                                            RUANG LINGKUP PEKERJAAN
                                        </td>
                                        <td colspan="3">
                                            <textarea class="form-control tinymce" name="dt[catatan_ruang_lingkup]" rows="5"><?= $spk['catatan_ruang_lingkup'] ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr style="background:#ddd">
                                        <th colspan="4">IMBALAN JASA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>HARGA <small class="text-danger">*(termasuk agency fee, PPN 11% dan pajak lainnya)</small></td>
                                        <td colspan="3">
                                            <input class="form-control money" type="text" name="dt[harga]" value="<?= $spk['harga'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL HARGA TERBILANG</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[total_harga_terbilang]" value="<?= $spk['total_harga_terbilang'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            CATATAN
                                        </td>
                                        <td colspan="3">
                                            <textarea class="form-control tinymce" id="" name="dt[catatan_imbalan_jasa]" rows="5"><?= $spk['catatan_imbalan_jasa'] ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr style="background:#ddd">
                                        <th colspan="4">KETERANGAN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td colspan="1">
                                            JANGKA WAKTU & DELIVERABLES
                                        </td>
                                        <td colspan="3">
                                            <textarea class="form-control tinymce" id="" name="dt[jangka_waktu]" rows="5"><?= $spk['jangka_waktu'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            CARA PEMBAYARAN
                                        </td>
                                        <td colspan="3">
                                            <textarea class="form-control tinymce" id="" name="dt[cara_pembayaran]" rows="5"><?= $spk['cara_pembayaran'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            LAIN - LAIN
                                        </td>
                                        <td colspan="3">
                                            <textarea class="form-control tinymce" id="" name="dt[lain_lain]" rows="5"><?= $spk['lain_lain'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">PIC PENERIMA KERJA</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[pic_penerima_kerja]" value="<?= $spk['pic_penerima_kerja'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">JABATAN PENERIMA KERJA</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[jabatan_penerima_kerja]" style="text-transform:uppercase" value="<?= $spk['jabatan_penerima_kerja'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">PIC PEMBERI KERJA</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[pic_pemberi_kerja]" value="<?= $spk['pic_pemberi_kerja'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">JABATAN PEMBERI KERJA</td>
                                        <td colspan="3">
                                            <input class="form-control" type="text" name="dt[jabatan_pemberi_kerja]" style="text-transform:uppercase" value="<?= $spk['jabatan_pemberi_kerja'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            FILE SPK
                                            <?php if ($spk['file_spk']) { ?>
                                                <a href="<?= base_url('webfile/spk/' . $path . '/') . $spk['file_spk'] ?>" target="_blank" class="btn btn-xs btn-success">
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td colspan="3">
                                            <input type="file" name="file_spk" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">FILE ATTACHMENT</td>
                                        <td colspan="3">

                                            <table class="table table-bordered table-condensed table-custom" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 90%;">File</th>
                                                        <th style="width: 10%;">
                                                            <button type="button" class="btn btn-xs btn-primary" onclick="addfile()"><i class="fa fa-plus"></i></button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-file">
                                                    <?php foreach ($datafile as $key => &$val) { ?>
                                                        <tr id="tr-data-file<?= $key + 1; ?>">
                                                            <td>
                                                                <!-- <input type="file" name="files[]" class="form-control" accept="image/*"> -->
                                                                <a target="_blank" class="btn btn-primary btn-xs" href="<?= base_url('webfile/spk/' . $path . '/' . $val) ?>"><i class="fa fa-download"></i> Download</a>
                                                                <input type="hidden" name="nama_files_old[]" value="<?= $val ?>">
                                                            </td>
                                                            <td>
                                                                <center><button type="button" class="btn btn-xs btn-danger" onclick="deleterow('<?= $key + 1; ?>')"><i class="fa fa-times"></i></button></center>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-3">
                                    <a href="<?= base_url('master/spk') ?>" class="btn btn-block btn-default">
                                        < < Kembali ke List Spk </a>
                                </div>
                                <div class="col-md-7"></div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-sm btn-send float-right">SIMPAN SPK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    tinymce.remove();
    tinymce.init({
        selector: '.tinymce',
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt 40pt 48pt",
        font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;Calibri=calibri,sans-serif;Gugi=Gugi, cursive;Indie Flower=indie flower, cursive;Tahoma=Tahoma, Verdana, Segoe, sans-serif;Times New Roman=times new roman,times;AkrutiKndPadmini=Akpdmi-n',
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor code"
        ],
        las_seconds: 15,
        las_nVersions: 15,
        las_keyName: "LocalAutoSave",
        las_callback: function() {
            var content = this.content; //content saved
            var time = this.time; //time on save action
        },
    });
</script>
<script>
    <?php if ($spk['file_attachment'] == null) { ?>
        var file = 1;
    <?php } else { ?>
        var file = '<?= count($datafile) ?>';
    <?php } ?>

    function addfile() {
        file++;
        htmls = '<tr id="tr-data-file' + file + '">' +
            '<td>' +
            '<input type="file" name="files[]" class="form-control" accept="image/*">' +
            '</td>' +
            '<td>' +
            '<center><button type="button" class="btn btn-xs btn-danger" onclick="deleterow(' + file + ')"><i class="fa fa-times"></i></button></center>' +
            '</td>' +
            '</tr>';
        $('#tbody-file').append(htmls);
    }

    function deleterow(id) {
        $('#tr-data-file' + id).remove();
    }
</script>

<script>
    $("#upload-create").submit(function() {
        tinymce.triggerSave();
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
                form.find(".show_error").slideUp().html("");
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
                    // form.find(".show_error").hide().html(response).slideDown("fast");
                    setTimeout(function() {
                         window.location.href = "<?= base_url('master/spk') ?>";
                    }, 1000);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                } else {
                    Swal.fire({
                        title: "Oppss!",
                        html: str,
                        icon: "error"
                    });
                    // form.find(".show_error").hide().html(response).slideDown("fast");
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);

                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                Swal.fire({
                    title: "Oppss!",
                    text: xhr,
                    icon: "error"
                });
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                // form.find(".show_error").hide().html(xhr).slideDown("fast");
            }
        });
        return false;

    });
</script>