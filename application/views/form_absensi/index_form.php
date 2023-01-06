<!-- Import Library Signature Pad -->
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/signaturepad/assets/jquery.signaturepad.css">
<script src="<?= base_url('assets/') ?>plugins/signaturepad/jquery.signaturepad.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $page_name ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- <div class="box-header with-border">
                    </div> -->
                    <div class="box-body">
                        <form action="<?= base_url('Form_absensi/store_absensi') ?>" method="POST" id="upload-create" enctype="multipart/form-data">
                            <input type="hidden" name="ar_id" id="ar_id" value="<?= $ar_id; ?>" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label class="col-sm-2 control-label">Pilih Pejabat</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" style="width: 100%;" name="dt[posisi]" id="posisi" required>
                                                <option value="-">--- Pilih Pejabat ---</option>
                                                <?php if ($absensi_rapat['ar_tipe_rapat'] == 'komite_komisaris') { ?>
                                                    <option value="Komisaris">Komisaris</option>
                                                    <option value="Non Komisaris">Non Komisaris</option>
                                                <?php }elseif ($absensi_rapat['ar_tipe_rapat'] == 'rapat_gabungan') { ?>
                                                   <option value="Komisaris">Komisaris</option>
                                                   <option value="Direksi">Direksi</option>
                                                    <option value="SEVP">SEVP</option>
                                                <?php }else { ?>
                                                    <option value="Direksi">Direksi</option>
                                                    <option value="SEVP">SEVP</option>
                                                <?php } ?>
                                                <option value="Pemateri">Divisi Pemateri</option>
                                                <option value="Pendamping">Divisi Pendamping</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-direksi" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label class="col-sm-2 control-label">Pilih Jabatan</label>
                                            <div class="col-sm-3">
                                                <select class="form-control select2" style="width: 100%;" name="dt[jabatan]" id="jabatan" onchange="cekJabatan()">
                                                    <option value="-">--- Pilih Jabatan ---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox-perwakilan" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="form-group" style="margin-top: 15px;">
                                                <label class="col-sm-2 control-label">Status</label>
                                                <div class="col-sm-3">
                                                    <input type="checkbox" value="Hadir" id="checkbox1" name="dt[status][]" onchange="cekStatus()" /> Hadir
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    <input type="checkbox" value="Hadir Mewakilkan" id="checkbox2" name="dt[status][]" onchange="cekStatus()" /> Hadir Mewakilkan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jabatan-perwakilan" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="form-group" style="margin-top: 25px;">
                                                <label class="col-sm-2 control-label"><small>Saya Hadir Mewakilkan</small></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control select2" style="width: 100%;" name="dt[jabatan_diwakilkan]" id="jabatan_perwakilan">
                                                        <option value="-">--- Mewakili Sebagai ---</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-divisi" style="display: none;">
                                    <div class="col-md-12 divisi-row">
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label class="col-sm-2 control-label">Pilih Divisi</label>
                                            <div class="col-sm-3">
                                                <select class="form-control select2" style="width: 100%;" name="dt[divisi]" id="divisi" onchange="cekDivisi()">
                                                    <option value="-">--- Pilih Divisi ---</option>
                                                    <?php $divisi = $this->mymodel->selectWhere('m_divisi', ['status' => "ENABLE"]); ?>
                                                    <?php foreach ($divisi as $div) {
                                                        echo "<option value='" . $div['md_id'] . "'>" . $div['md_nama'] . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 penjabat_nama_row">
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label class="col-sm-2 control-label">Nama Pejabat</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="dt[nama_pejabat]" id="nama_pejabat" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-ttd" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top: 25px;">
                                            <label class="col-sm-2 control-label">Tanda Tangan</label>
                                            <div class="col-sm-3">
                                                <div class="sigPad" id="smoothed" style="width:100%">
                                                    <ul class="sigNav">
                                                        <li class="clearButton"><a href="#clear">Clear</a></li>
                                                    </ul>
                                                    <div class="sig sigWrapper" style="height:auto;">
                                                        <div class="typed"></div>
                                                        <canvas class="pad" height="150"></canvas>
                                                        <input type="hidden" id="ttd" name="output-2" class="output">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ttd" id="ttd_fix" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-upload-ttd" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top: 25px;">
                                            <label class="col-sm-2 control-label">File Tanda Tangan</label>
                                            <div class="col-sm-3">
                                                <input type="file" name="file_ttd" id="file_ttd" class="form-control" accept="images/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="pull-left">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull-right">
                                            <button type="button" onclick="saveData()" class="btn btn-primary btn-send" disabled><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    // Handle Form
    $("#posisi").change(function() {
        var value_posisi = $(this).val();
        if (value_posisi == "-") {
            // Tidak ada pilihan posisi
            $(".form-direksi").hide(500);
            $(".checkbox-perwakilan").hide(500);
            $(".jabatan-perwakilan").hide(500);
            $(".form-divisi").hide(500);
            $(".form-ttd").hide(500);
            $(".form-upload-ttd").hide(500);
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
        } else if ((value_posisi == "Pemateri") || (value_posisi == "Pendamping")) {
            // Pilihan Posisi Divisi
            $(".form-direksi").hide(500);
            $(".checkbox-perwakilan").hide(500);
            $(".form-upload-ttd").hide(500);
            $(".form-divisi").show(500);
            $(".divisi-row").show(500);
            $(".penjabat_nama_row").show(500);
            $(".form-ttd").show(500);
        } else if (value_posisi == "SEVP") {
            $(".form-direksi").show(500);
            $(".checkbox-perwakilan").hide(500);
            $(".jabatan-perwakilan").hide(500);
            $(".form-divisi").hide(500);
            $(".form-ttd").hide(500);
            dropdown_jabatan();
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
        }else if(value_posisi == 'Non Komisaris'){

            $(".form-direksi").hide(500);
            $(".checkbox-perwakilan").hide(500);
            $(".form-upload-ttd").hide(500);
            $(".form-divisi").show(500);
            $(".divisi-row").hide(500);
            $(".penjabat_nama_row").show(500);
            $(".form-ttd").show(500);

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);

        } else {
            // Pilihan Posisi Direksi
            var value_ar_id = $("#ar_id").val();
            if (value_posisi == "Direksi") {
                $.ajax({
                    url: '<?= base_url('Form_absensi/cek_kuorum') ?>',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        ar_id: value_ar_id
                    },
                    beforeSend: function() {},
                    success: function(response, textStatus, xhr) {
                        var str = response;
                        if (str.indexOf("penuh") != -1) {
                            Swal.fire({
                                title: "Mohon Maaf",
                                html: "<b>Jumlah Kuorum sudah penuh.</b>",
                                icon: "error"
                            });
                            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
                        } else {
                            $(".form-direksi").show(500);
                            $(".checkbox-perwakilan").show(500);
                            $(".jabatan-perwakilan").hide(500);
                            $(".form-divisi").hide(500);
                            $(".form-ttd").hide(500);
                            dropdown_jabatan();
                            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                        }
                    }
                });
            }else if (value_posisi == "Komisaris") {
                $.ajax({
                    url: '<?= base_url('Form_absensi/cek_kuorum') ?>',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        ar_id: value_ar_id
                    },
                    beforeSend: function() {},
                    success: function(response, textStatus, xhr) {
                        var str = response;
                        if (str.indexOf("penuh") != -1) {
                            Swal.fire({
                                title: "Mohon Maaf",
                                html: "<b>Jumlah Kuorum sudah penuh.</b>",
                                icon: "error"
                            });
                            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
                        } else {
                            $(".form-direksi").show(500);
                            $(".checkbox-perwakilan").show(500);
                            $(".jabatan-perwakilan").hide(500);
                            $(".form-divisi").hide(500);
                            $(".form-ttd").show(500);
                            dropdown_jabatan();
                            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                        }
                    }
                });
            }else {
                $(".form-direksi").show(500);
                $(".checkbox-perwakilan").show(500);
                $(".jabatan-perwakilan").hide(500);
                $(".form-divisi").hide(500);
                $(".form-ttd").show(500);
                dropdown_jabatan();
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
            }
        }
    });

    function cekStatus() {
        var trap_perwakilan = 0;
        $('input[name="dt[status][]"]:checked').each(function() {
            var value_data = this.value;
            if (value_data == "Hadir Mewakilkan") {
                // $('#checkbox1').prop('checked', true);
                trap_perwakilan += 1;
            } else {
                trap_perwakilan += 0;
            }
        });

        if (trap_perwakilan == 0) {
            $(".jabatan-perwakilan").hide(500);
        } else if (trap_perwakilan == 1) {
            $(".jabatan-perwakilan").show(500);
            dropdown_jabatan_perwakilan();
        } else {
            $(".jabatan-perwakilan").hide(500);
        }
    }

    function dropdown_jabatan() {
        $('#jabatan').empty();
        var posisi = $("#posisi").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('Form_absensi/dropdown_perwakilan'); ?>",
            cache: false,
            dataType: "json",
            data: {
                posisi: posisi
            },
            success: function(data) {
                var newOption1 = new Option("--- Pilih Jabatan ---", "-", false, false);
                $('#jabatan').append(newOption1).trigger('change');
                $('#jabatan').select2({
                    data: data
                });
            },
            error: function() {
                var newOption1 = new Option("--- Pilih Jabatan ---", "-", false, false);
                $('#jabatan').append(newOption1).trigger('change');
            }
        });
        return false;
    }

    function dropdown_jabatan_perwakilan() {
        $('#jabatan_perwakilan').empty();
        var jabatan = $("#jabatan").val();
        var value_ar_id = $("#ar_id").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('Form_absensi/dropdown_jabatan_perwakilan'); ?>",
            cache: false,
            dataType: "json",
            data: {
                jabatan: jabatan,
                ar_id: value_ar_id
            },
            success: function(data) {
                var newOption2 = new Option("--- Mewakili Sebagai ---", "-", false, false);
                $('#jabatan_perwakilan').append(newOption2).trigger('change');
                $('#jabatan_perwakilan').select2({
                    data: data
                });
            },
            error: function() {
                var newOption2 = new Option("--- Mewakili Sebagai ---", "-", false, false);
                $('#jabatan_perwakilan').append(newOption2).trigger('change');
            }
        });
        return false;
    }

    // Cek Jabatan, sudah pernah absen atau belum
    function cekJabatan() {
        var value_posisi = $("#posisi").val();
        var value_jabatan = $("#jabatan").val();
        var value_ar_id = $("#ar_id").val();
        if (value_jabatan == "-") {
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
        } else {
            $.ajax({
                url: '<?= base_url('Form_absensi/cek_absensi_jabatan') ?>',
                type: 'post',
                dataType: 'html',
                data: {
                    posisi: value_posisi,
                    jabatan: value_jabatan,
                    ar_id: value_ar_id
                },
                beforeSend: function() {},
                success: function(response, textStatus, xhr) {
                    var str = response;
                    if (str.indexOf("sudah absen") != -1) {
                        Swal.fire({
                            title: "Mohon Maaf",
                            html: "<b>Jabatan tersebut sudah melakukan absensi.</b>",
                            icon: "error"
                        });
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
                    } else {
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    }
                }
            });
        }
    }

    // Cek Divisi, apakah divisi yang dipilih terdaftar dalam agenda rapat atau tidak
    function cekDivisi() {
        var value_posisi = $("#posisi").val();
        var value_divisi = $("#divisi").val();
        var value_ar_id = $("#ar_id").val();
        if (value_divisi == "-") {
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
        } else {
            $.ajax({
                url: '<?= base_url('Form_absensi/cek_absensi_divisi') ?>',
                type: 'post',
                dataType: 'html',
                data: {
                    posisi: value_posisi,
                    divisi: value_divisi,
                    ar_id: value_ar_id
                },
                beforeSend: function() {},
                success: function(response, textStatus, xhr) {
                    var str = response;
                    if (str.indexOf("tidak ada") != -1) {
                        Swal.fire({
                            title: "Mohon Maaf",
                            html: "<b>Divisi tersebut tidak terdapat pada agenda rapat.</b>",
                            icon: "error"
                        });
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
                    } else {
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    }
                }
            });
        }
    }

    $('#smoothed').signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 200,
        penColour: "rgb(0, 0, 0)"
    });

    function saveData() {
        var instance = $('.sigPad').signaturePad();
        var ttd = instance.getSignatureImage();
        $("#ttd_fix").val(ttd);
        Swal.fire({
            title: 'Perhatian',
            text: "Apakah data yang diinputkan Bapak/Ibu sudah benar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Kembali',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $("#upload-create").submit();
            }
        })
    }

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
                        title: "Sukses",
                        text: "Absensi Berhasil.",
                        icon: "success"
                    });
                    setTimeout(function() {
                        location.href = '<?= base_url('form-absensi/kehadiran-rapat/' . $ar_id) ?>';
                    }, 1000);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                } else {
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    Swal.fire({
                        title: "Absensi Gagal",
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
</script>