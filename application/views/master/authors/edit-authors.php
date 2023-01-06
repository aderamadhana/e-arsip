  <!-- Content Wrapper. Contains page content -->
    <form method="POST" action="<?= base_url('master/Authors/update') ?>" id="upload-create" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $authors['id'] ?>">
      <div class="show_error"></div>

      <div class="form-group">
        <label for="form-first_name">First name</label>
        <input type="text" class="form-control" id="form-first_name" placeholder="Masukan First name" name="dt[first_name]" value="<?= $authors['first_name'] ?>">
      </div>

      <div class="form-group">
        <label for="form-last_name">Last name</label>
        <input type="text" class="form-control" id="form-last_name" placeholder="Masukan Last name" name="dt[last_name]" value="<?= $authors['last_name'] ?>">
      </div>

      <div class="form-group">
        <label for="form-email">Email</label>
        <input type="text" class="form-control" id="form-email" placeholder="Masukan Email" name="dt[email]" value="<?= $authors['email'] ?>">
      </div>

      <div class="form-group">
        <label for="form-birthdate">Birthdate</label>
        <input type="text" class="form-control tgl" id="form-birthdate" placeholder="Masukan Birthdate" name="dt[birthdate]" value="<?= $authors['birthdate'] ?>">
      </div>

      <div class="form-group">
        <label for="form-address">Address</label>
        <textarea name="dt[address]" id="form-address" class="form-control"><?= $authors['address'] ?></textarea>
      </div>

        <?php
          if($file['dir']!=""){
            $types = explode("/", $file['mime']);
          if($types[0]=="image"){
            ?>
            <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">
            <br>
          <?php }else{ ?>

            <i class="fa fa-file fa-5x text-danger"></i>
            <br>
            <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>
            <br>
          <br>
        <?php } ?>
      <?php } ?>
      <div class="form-group">
          <label for="form-file">File</label>
          <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">
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
'   <td>'+$("#form-first_name").val()+'</td>'+
                            '   <td>'+$("#form-last_name").val()+'</td>'+
                            '   <td>'+$("#form-email").val()+'</td>'+
                            '   <td>'+$("#form-birthdate").val()+'</td>'+
                            '   <td>'+$("#form-address").val()+'</td>'+
                            
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