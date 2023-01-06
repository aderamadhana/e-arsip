  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        M Kategori Surat
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">M Kategori Surat</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/M_kategori_surat/update') ?>" id="upload-create" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $m_kategori_surat['id'] ?>">
      <div class="row">
        <div class="col-xs-8">
          <div class="panel">
            <!-- /.panel-header -->
            <div class="panel-heading">
              <h5 class="panel-title">
                  Edit M Kategori Surat
              </h5>
            </div>
            <div class="panel-body">
                <div class="show_error"></div>

                  <div class="form-group">
                      <label for="form-mkt_kategori">Kategori</label>
                      <input type="text" class="form-control" id="form-mkt_kategori" placeholder="Masukan Kategori" name="dt[mkt_kategori]" value="<?= $m_kategori_surat['mkt_kategori'] ?>">
                  </div>

                  <div class="form-group">
                     <label for="form-mkt_tipe">Tipe</label>
                     <select name="dt[mkt_tipe]" class="form-control">
                      <option value="">Pilih</option>
                      <option value="Surat Keluar" <?=($m_kategori_surat['mkt_tipe']=="Surat Keluar")?"selected":""?> >Surat Keluar</option>
       <option value="Surat Masuk" <?=($m_kategori_surat['mkt_tipe']=="Surat Masuk")?"selected":""?> >Surat Masuk</option>
       
                     </select>
                 </div>

                  <div class="form-group">
                    <label for="form-tsk_id">Surat Keluar</label>
                    <select name="dt[tsk_id]" class="form-control select2" style="width:100%">
                      <option value="0">Pilih</option>
                      <?php 
                      $tipe_surat_keluar = $this->mymodel->selectWhere('tipe_surat_keluar',null);
                      foreach ($tipe_surat_keluar as $tipe_surat_keluar_record) {
                      $text="";
                      if($tipe_surat_keluar_record['id']==$m_kategori_surat['tsk_id']){
                      $text = "selected";
                      }
                      echo "<option value=".$tipe_surat_keluar_record['id']." ".$text." >".$tipe_surat_keluar_record['nama']."</option>";
                      }
                      ?>
                    </select>
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
                             window.location.href = "<?= base_url('master/M_kategori_surat') ?>";
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