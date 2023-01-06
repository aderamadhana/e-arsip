<!-- Import Library Signature Pad -->
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/signaturepad/assets/jquery.signaturepad.css">
<script src="<?= base_url('assets/') ?>plugins/signaturepad/jquery.signaturepad.js"></script>

<div class="content-wrapper" style="background-color: #F5F7FF;">
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
                        <form action="<?= base_url('Notulen_radisi/store_checkin_checkout') ?>" method="POST" id="upload-create" enctype="multipart/form-data">
                            <input type="hidden" name="dt[tnr_nr_id]" id="tnr_nr_id" value="<?= $nr_id;?>" />
                            <input type="hidden" name="dt[tnr_jenis]" id="tnr_jenis" value="<?= $status;?>" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Pilih Jabatan</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" style="width: 100%;" name="dt[tnr_posisi_jabatan_id]" id="tnr_posisi_jabatan_id">
                                                <?php
                                                if(count($jabatan) > 1) {
                                                    ?>
                                                    <option value="-">--- Pilih Jabatan ---</option>
                                                    <?php
                                                    foreach ($jabatan as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value['mpj_id']; ?>"><?= $value['mpj_nama']; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    foreach ($jabatan as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value['mpj_id']; ?>"><?= $value['mpj_nama']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if($page_name == "Check-Out Notulen Radisi") {
                                        ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Update Catatan</label>
                                            <div class="col-sm-3">
                                                <label>
                                                    <input type="radio" class="iradio_minimal-blue" id="update_catatan_y" name="slug_catatan" value="N" checked> Tidak
                                                </label>
                                                <label>
                                                    <input type="radio" class="iradio_minimal-blue" id="update_catatan_t" name="slug_catatan" value="Y"> Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none;" id="form-catatan">
                                            <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" name="dt[tnr_catatan]" id="tnr_catatan" rows="4" placeholder="Tuliskan catatan disini..."></textarea>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="pull-left">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull-right">
                                            <button type="button" onclick="saveData();" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if($page_name == "Check-In Notulen Radisi") { 
                ?>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4>Direktur yang telah tanda tangan :</h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover table-condensed table-striped" width="100%" border="1">
                                        <thead>
                                            <th>No</th>
                                            <th>Jabatan</th>
                                            <th>Checklist</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($timeline as $key => $value) {
                                                if($value['tnr_waktu_keluar'] != null) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $key + 1; ?></td>
                                                        <td><?= $value['tnr_posisi_jabatan']; ?></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</div>
<script type="text/javascript">

    $('input[type="radio"]').on('click change', function(e) {
        let valueUpdate = $(this).val();

        if(valueUpdate === "Y") {
            $('#form-catatan').show();
        } else {
            $('#form-catatan').hide();
        }
    });

    function saveData() {
        Swal.fire({
            title: 'Perhatian',
            text: "Apakah data yang diinputkan sudah benar?",
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
                let str = JSON.parse(response);
                if (str.status === 200){
                    Swal.fire({
                        title: "Sukses",
                        text: "Scan Berhasil.",
                        icon: "success"
                    });

                    setTimeout(function(){ 
                        window.location.href = "<?= base_url('Notulen_radisi/notif_scan'); ?>/" + str.id_jabatan + "/" + str.id_timeline;
                    }, 1000);

                } else {
                    Swal.fire({
                        title: "Scan Gagal",
                        text: str.message,
                        icon: "error"
                    });
                }

                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
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