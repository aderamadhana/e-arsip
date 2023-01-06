  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tipe Surat Keluar
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Tipe Surat Keluar</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/Tipe_surat_keluar/update') ?>" id="upload-create" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $tipe_surat_keluar['id'] ?>">
      <div class="row">
        <div class="col-xs-8">
          <div class="panel">
            <!-- /.panel-header -->
            <div class="panel-heading">
              <h5 class="panel-title">
                  Edit Tipe Surat Keluar
              </h5>
            </div>
            <div class="panel-body">
                <div class="show_error"></div>

                  <div class="form-group">
                      <label for="form-nama">Nama</label>
                      <input type="text" class="form-control" id="form-nama" placeholder="Masukan Nama" name="dt[nama]" value="<?= $tipe_surat_keluar['nama'] ?>">
                  </div>

                  <div class="form-group">
                      <label for="form-kode">Kode</label>
                      <input type="text" class="form-control" id="form-kode" placeholder="Masukan Kode" name="dt[kode]" value="<?= $tipe_surat_keluar['kode'] ?>">
                  </div>

          </div>
          <div class="panel-footer">
              <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
              <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

          </div>
          <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!-- /.panel -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
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
                    //form.find(".show_error").slideUp().html("");
              },
              success: function(response, textStatus, xhr) {
                      // alert(mydata);
                   var str = response;
                    if (str.indexOf("success") != -1){
                          //form.find(".show_error").hide().html(response).slideDown("fast");
                        
                          Swal.fire({
                              title: "It works!",
                              text: "Successfully updated data",
                              icon: "success"
                          });
                          setTimeout(function(){ 
                             window.location.href = "<?= base_url('master/Tipe_surat_keluar') ?>";
                      }, 1000);
                      $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                  }else{
                          Swal.fire({
                            title: "Oppss!",
                            html: str,
                            icon: "error"
                          });
                          // form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                  }
              },
              error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    Swal.fire({
                        title: "Oppss!",
                        text: xhr,
                        icon: "error"
                    });
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    // form.find(".show_error").hide().html(xhr).slideDown("fast");
              }
          });
          return false;

      });
</script>