
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Asset
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Asset </li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/Konfig/store') ?>" id="upload-create" enctype="multipart/form-data">

      <div class="row">
        <div class="col-xs-8">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <h5 class="box-title">
                  Update Assets
              </h5>
            </div>
            <div class="box-body">
                <div class="show_error"></div><div class="form-group">
                      <label for="form-slug">Kode Barang</label>
                      <input type="text" class="form-control" id="form-slug" placeholder="Masukan data" name="dt[slug]" readonly="" value="1112012P">
                  </div>
                  <div class="form-group">
                      <label for="form-value">Upload Foto</label>
                      <input type="file" class="form-control" id="form-value" placeholder="Masukan data" name="dt[value]">
                  </div>
                   <div class="form-group">
                      <label for="form-file">Upload Dokumen</label>
                      <input type="file" class="form-control" id="form-value" placeholder="Masukan data" name="dt[value]">
                  </div>
                  <div class="form-group">
                      <label for="form-file">Tanggal Upload</label>
                      <input type="date" class="form-control" id="form-value" placeholder="Masukan data" name="dt[value]">
                  </div>
                   <div class="form-group">
                      <label for="form-file">Kondisi barang</label>
                      <input type="text" class="form-control" id="form-value" placeholder="Masukan data" name="dt[value]">
                  </div>

              <div class="box-footer">
                <a href="<?= base_url('update_asset/index')?>" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</a>
                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
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
                    form.find(".show_error").slideUp().html("");
                },
                success: function(response, textStatus, xhr) {
                    // alert(mydata);
                   var str = response;
                    if (str.indexOf("success") != -1){
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        setTimeout(function(){ 
                           window.location.href = "<?= base_url('master/Konfig') ?>";
                        }, 1000);
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);


                    }else{
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                        
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  console.log(xhr);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");

                }
            });
            return false;
    
        });
  </script>