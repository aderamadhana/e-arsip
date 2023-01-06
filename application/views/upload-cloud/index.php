<link rel="stylesheet" href="<?= base_url('/assets/plugins/json-viewer/jquery.jsonPresenter.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/plugins/json-viewer/jjsonviewer.css'); ?>">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Cloud Storage
    <small>fitur</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"> Cloud Storage</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
          <!-- /.box-header -->
          <div class="box-header hidden">
            <div class="row">
            </div>
            
          </div>
          <div class="box-body">
          <form method="post" action="<?= base_url('upload_cloud/prosesUploadCloud') ?>" enctype="multipart/form-data">
            <h4>Upload file</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Choose file</label>
                  <input type="file" id="upload-cloud" name="file" /> <!-- Filename -->
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>   
              </div>
              <div class="col-md-6">
                  <label>Choose file (ajax)</label>
                  <input type="file" id="input-upload-cloud" /> <!-- Filename -->
                  <a href="#" id="btn-download" style="display: none;"><button type="button" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-download"></i> Download</button></a>
                  <label id="txt-link"></label>
              </div>
            </div>
          </form>
            <hr>
            <h4>Get file</h4>
            <div class="row">
              <div class="col-md-6">
                <label>Image</label><br>
                <img src="http://dev.alfahuma.tech/cloud/files/v1/file/download/3?apikey=mg5L20smka0kHKhKIAkVqkWItm0JuaJzagysX1LiufR8q1CLQzRyEARIzm1TTltE-1" style="height: 200px; width: auto;">
                <br>
                <br>
              </div>
              <div class="col-md-6">
                <label>Download File PDF</label><br>
                <a href="http://dev.alfahuma.tech/cloud/files/v1/file/download/2?apikey=mg5L20smka0kHKhKIAkVqkWItm0JuaJzagysX1LiufR8q1CLQzRyEARIzm1TTltE-1" target="_blank"><button type="button" class="btn btn-primary"><i class="fa fa-download"></i> Download</button></a>
              </div>
            </div>
            <hr>
            <div class="row">
              <form action="<?= base_url('upload-cloud/prosesCreateFolder'); ?>" method="post">
              <div class="col-md-6">
                <h4>Create Folder</h4>
                <?php $folder = file_get_contents("http://dev.alfahuma.tech/cloud/files/v1/folder/list/1?apikey=mg5L20smka0kHKhKIAkVqkWItm0JuaJzagysX1LiufR8q1CLQzRyEARIzm1TTltE-1"); ?>
                <div class="form-group">
                  <label>Folder</label>
                  <select name="folderid" class="form-control select2">
                      <option value="1">Utama</option>
                    <?php foreach (json_decode($folder)->items as $value): ?>
                      <?php if ($value->type=="folder"): ?>
                      <option value="<?= $value->id ?>"><?= $value->name ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Folder Name</label>
                  <input type="text" name="name" class="form-control" value="" required="required">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Create</button>
              </div>
              </form>
            </div>
            <hr>
            <h4>List Folder</h4>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Folder</label>
                  <select class="form-control select2" id="sel-folder">
                      <option value="1">Utama</option>
                    <?php foreach (json_decode($folder)->items as $value): ?>
                      <?php if ($value->type=="folder"): ?>
                      <option value="<?= $value->id ?>"><?= $value->name ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                </div>
                <div id="list-wrapper" style="max-height: 300px;overflow: auto"></div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
  <script src="<?= base_url('assets/plugins/json-viewer/jjsonviewer.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/json-viewer/jquery.jsonPresenter.js'); ?>"></script>
  <script type="text/javascript">

      $('#input-upload-cloud').change(function(event) {
        var form_data = new FormData();  
        form_data.append("file", $(this).prop("files")[0]);  
        $.ajax({
          url: '<?= base_url('upload-cloud/ajaxUploadCloud'); ?>',
          type: 'POST',
          processData: false, // important
          contentType: false, // important
          dataType : 'json',
          data: form_data,
          success: function(response){  
            if (response.success==true) {
              alert("Upload to cloud storage server success");
              $('#btn-download').attr({
                href: '<?= base_url('upload-cloud/getFile/')?>'+response.id,
                target: '_blank'
                // download: '<?= base_url('upload-cloud/getFile/')?>'+response.id
              }).show();
              $('#txt-link').text('<?= base_url('upload-cloud/getFile/')?>'+response.id);
            } else {
              alert("Failed to upload file, please try again or use another files");
            }
          },
          error: function(xhr, textStatus, errorThrown) {
              alert("Error");
          }
        });
      });

      $("#sel-folder").change(function(event) {
        jQuery.ajax({
          url: '<?= base_url('upload-cloud/getList/'); ?>'+this.value,
          type: 'POST',
          dataType: 'json',
          beforeSend: function(xhr, textStatus) {
            //called when complete
            $("#list-wrapper").html('');
          },
          success: function(data, textStatus, xhr) {
            //called when successful

          $('#list-wrapper').jsonPresenter({
            json: {data}, // JSON objects here
          });
          },
          error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
          }
        });
        
      });
      $("#sel-folder").change();
  </script>