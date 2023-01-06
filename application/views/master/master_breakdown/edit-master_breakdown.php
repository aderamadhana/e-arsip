  <!-- Content Wrapper. Contains page content -->
    <form method="POST" action="<?= base_url('master/Master_breakdown/update') ?>" id="upload-create" enctype="multipart/form-data">
      <input type="hidden" name="id_breakdown" value="<?= $master_breakdown['id_breakdown'] ?>">
      <div class="show_error"></div>

      <div class="form-group">
        <label for="form-mb_keterangan">Keterangan</label>
        <input type="text" class="form-control" id="form-mb_keterangan" placeholder="Masukan Keterangan" name="dt[mb_keterangan]" value="<?= $master_breakdown['mb_keterangan'] ?>">
      </div>

      <div class="form-group">
        <label for="form-mb_biaya">Breakdown Biaya Sponsorship</label>
        <input type="text" class="form-control money" id="form-mb_biaya" placeholder="Masukan Breakdown Biaya Sponsorship" name="dt[mb_biaya]" value="<?= $master_breakdown['mb_biaya'] ?>">
      </div>

      <div class="form-group">
        <label for="form-mb_periode_awal">Periode awal</label>
        <input type="text" class="form-control tgl" id="form-mb_periode_awal" placeholder="Masukan Periode awal" name="dt[mb_periode_awal]" value="<?= $master_breakdown['mb_periode_awal'] ?>">
      </div>

      <div class="form-group">
        <label for="form-mb_periode_akhir">Periode akhir</label>
        <input type="text" class="form-control tgl" id="form-mb_periode_akhir" placeholder="Masukan Periode akhir" name="dt[mb_periode_akhir]" value="<?= $master_breakdown['mb_periode_akhir'] ?>">
      </div>

      <div class="text-right"> 
        <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
      </div>

    </form>
<!-- /.content-wrapper -->
<script type="text/javascript">
$(".money").simpleMoneyFormat();
tinymce.remove();
tinymce.init({
  selector: '.tinymces',
    cleanup : true,
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
            // alert(mydata);
          var str = response;
          if (str.indexOf("success") != -1){
              Swal.fire({
                  title: "It works!",
                  text: "Successfully updated data",
                  icon: "success"
              });

              setTimeout(function(){ 
                  idrow.html('<td>#</td>'+
                            '   <td></td>'+
'   <td>'+$("#form-mb_keterangan").val()+'</td>'+
                            '   <td>'+$("#form-mb_biaya").val()+'</td>'+
                            '   <td>'+$("#form-mb_periode_awal").val()+'</td>'+
                            '   <td>'+$("#form-mb_periode_akhir").val()+'</td>'+
                            '   <td>'+$("#form-mb_sisa_anggaran").val()+'</td>'+
                            
                            '   <td></td>'+
                            '   <td><label class="badge bg-green">Updated</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label></td>');
idrow.addClass('bg-warning');
                  
                  $("#modal-form").modal('hide');
              }, 1000);
              $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
          }else{
              $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
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
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
      }
  });
  return false;

  });
  $('.select2').select2();
  $('.tgl').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
  });

</script>