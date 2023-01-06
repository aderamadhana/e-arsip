<form method="POST" action="<?= base_url('Notulen_radisi/store') ?>" id="upload-create" enctype="multipart/form-data">
    <div class="show_error"></div>
    <div class="form-group">
        <label for="form-tanggal-rapat">Tanggal Rapat Direksi</label>
        <select class="form-control select2" name="dt[nr_absensi_rapat_id]" id="form-tanggal-rapat" style="width: 100%">
            <option value="">-- Pilih Tanggal Rapat --</option>
            <?php
            foreach ($absensiRapat as $key => $value) {
                ?>
                <option value="<?= $value['ar_id']; ?>"><?= $value['ar_tanggal']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="form-agenda">Agenda Rapat</label>
        <textarea class="form-control" name="dt[nr_absensi_rapat_agenda]" id="form-agenda" rows="4" readonly></textarea>
    </div>

    <div class="form-group">
        <label for="form-pic">PIC</label>
        <input type="text" class="form-control" id="form-pic" placeholder="Masukan Nama PIC" name="dt[nr_pic]">
    </div>

    <div class="form-group">
        <label for="form-nama">Catatan/Reminder</label>
        <textarea class="form-control" name="dt[nr_catatan]" id="form-catatan" rows="4"></textarea>
    </div>

    <div class="text-right"> 
        <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
    </div>
</form>

<!-- /.content-wrapper -->
<script type="text/javascript">

$("#upload-create").submit(function(){
    var form = $(this);
    var mydata = new FormData(this);
    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: mydata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend : function(){
            $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
        },
        success: function(response, textStatus, xhr) {

            let str = JSON.parse(response);
            if (str.status === 200){
                Swal.fire({
                    title: "It works!",
                    text: "Successfully added data",
                    icon: "success"
                });

                setTimeout(function(){ 
                    loadtable();
                    $("#modal-form").modal('hide');
                }, 1000);

            } else {
                Swal.fire({
                    title: "Oppss!",
                    html: str.message,
                    icon: "error"
                });
            }

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
            Swal.fire({
                    title: "Oppss!",
                    text: xhr,
                    icon: "error"
                });
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
        }
    });
    return false;

});
$('.select2').select2();
$('.tgl').datepicker({
  autoclose: true,
  format:'yyyy-mm-dd'
});

$('#form-tanggal-rapat').on('change', function() {
    let idAbsensi = $(this).find(":selected").val();
    $.ajax({
        type: "GET",
        url: "<?= base_url('Notulen_radisi/getAgendaRapat') ?>/" + idAbsensi,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend : function(){
            $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
        },
        success: function(response, textStatus, xhr) {

            let str = JSON.parse(response);
            if (str.status === 200){
                $('#form-agenda').val(str.agenda);
                console.log(str.agenda);
            } else {
                Swal.fire({
                    title: "Oppss!",
                    html: str.message,
                    icon: "error"
                });
            }

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
            Swal.fire({
                    title: "Oppss!",
                    text: xhr,
                    icon: "error"
                });
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
        }
    });
});

</script>