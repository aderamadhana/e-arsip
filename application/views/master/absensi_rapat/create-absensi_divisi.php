<form method="POST" action="<?= base_url('master/Absensi_rapat/store_absensi_divisi') ?>" id="upload-absensi-divisi" enctype="multipart/form-data">
    <div class="show_error"></div>
    <input type="hidden" name="dt[are_tipe]" id="posisi" value="<?= $posisi; ?>">
    <input type="hidden" name="dt[are_ar_id]" value="<?= $ar_id; ?>" />
    <input type="hidden" id="ar_id_divisi" value="<?= $ar_id_encode; ?>" />
    <?php if ($posisi != 'Non Komisaris') { ?>
        <div class="form-group">
            <label for="form-md_nama">Pilih Divisi</label>
            <select class="form-control select2" style="width: 100%;" name="dt[are_md_id]" id="divisi" onchange="cekDivisi()">
                <option value="-">--- Pilih Posisi ---</option>
                <?php if ($divisi) { ?>
                    <?php foreach ($divisi as $div) { ?>
                        <option value="<?= $div['md_id']; ?>"><?= $div['md_nama']; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
    <div class="form-group">
        <label for="form-are_nama_pejabat_divisi">Nama Pejabat</label>
        <input type="text" class="form-control" id="form-are_nama_pejabat_divisi" placeholder="Masukan Nama Pejabat" name=" dt[are_nama_pejabat_divisi]">
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
        <?php if ($posisi != 'Non Komisaris') { ?>\
            <button type="button" onclick="saveDataDivisi()" class="btn btn-primary btn-send-divisi" disabled><i class="fa fa-save"></i> Save</button>
        <?php }else{ ?>
            <button type="button" onclick="saveDataDivisi()" class="btn btn-primary btn-send-divisi"><i class="fa fa-save"></i> Save</button>
        <?php } ?>
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

    function cekDivisi() {
        var value_posisi = $("#posisi").val();
        var value_divisi = $("#divisi").val();
        var value_ar_id = $("#ar_id_divisi").val();
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
                        $(".btn-send-divisi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', true);
                    } else {
                        $(".btn-send-divisi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    }
                }
            });
        }
    }

    function saveDataDivisi() {
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
                $("#upload-absensi-divisi").submit();
            }
        })
    }

    $("#upload-absensi-divisi").submit(function() {
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
                $(".btn-send-divisi").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);
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
                    $(".btn-send-divisi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                } else {
                    $(".btn-send-divisi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
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
                $(".btn-send-divisi").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
            }
        });
        return false;
    });
</script>