<form method="POST" action="<?= base_url('master/Absensi_rapat/store_absensi_direksi') ?>" id="upload-absensi-direksi" enctype="multipart/form-data">
    <div class="show_error"></div>
    <input type="hidden" name="dt[are_ar_id]" value="<?= $ar_id; ?>" />
    <input type="hidden" id="ar_id_direksi" value="<?= $ar_id_encode; ?>" />
    <input type="hidden" name="dt[are_tipe]" id="posisi" value="<?= $posisi; ?>">
    <div class="form-group">
        <label for="form-are_mpj_nama">Jabatan</label>
        <input type="text" class="form-control" id="form-are_mpj_nama" value="<?= $direksi['mpj_nama']; ?>" name=" dt[are_mpj_nama]" readonly>
        <input type="hidden" value="<?= $direksi['mpj_id']; ?>" name="dt[are_mpj_id]" />
    </div>
    <div class="form-group">
        <label>Tanda Tangan</label>
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
    <div class="text-right">
        <button type="button" onclick="saveDataDireksi()" class="btn btn-primary btn-send-direksi"><i class="fa fa-save"></i> Save</button>
        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
    </div>
</form>

<!-- /.content-wrapper -->
<script type="text/javascript">
    $('.select2').select2();

    $('#smoothed').signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 200,
        penColour: "rgb(0, 0, 0)"
    });

    function saveDataDireksi() {
        var instance = $('.sigPad').signaturePad();
        var ttd = instance.getSignatureImage();
        $("#ttd_fix").val(ttd);
        Swal.fire({
            title: 'Perhatian ?',
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
                $("#upload-absensi-direksi").submit();
            }
        })
    }

    $("#upload-absensi-direksi").submit(function() {
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
                $(".btn-send-direksi").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);
            },
            success: function(response, textStatus, xhr) {
                // alert(mydata);
                var str = response;
                if (str.indexOf("success") != -1) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Absensi Telah Ditambahkan.",
                        icon: "success"
                    });
                    setTimeout(function() {
                        $("#modal-form").modal('hide');
                        window.location.reload();
                    }, 1000);
                    $(".btn-send-direksi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                } else {
                    $(".btn-send-direksi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
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
                $(".btn-send-direksi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
            }
        });
        return false;
    });
</script>