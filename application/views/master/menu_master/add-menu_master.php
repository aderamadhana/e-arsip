
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> 
        Menu Master
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Menu Master</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/Menu_master/store') ?>" id="upload-create" enctype="multipart/form-data">

      <div class="row">
        <div class="col-xs-8">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <h5 class="box-title">
                  Tambah Menu Master
              </h5>
            </div>
            <div class="box-body">
              <div class="show_error"></div>
              <div class="form-group">
                <label for="form-name">Name</label>
                <input type="text" class="form-control" id="form-name" placeholder="Masukan Name" name="dt[name]">
              </div>
              <div class="form-group">
                <label>Menu Type</label>
                <select name="dt[type]" id="sel-type" class="form-control">
                  <option value="menu">Menu</option>
                  <option value="label">Menu Label</option>
                </select>
                <small><i class="fa fa-info"></i> Menu Label untuk header menu seperti "MENU BUILD"</small>
              </div>
              <div class="form-group">
                <label for="form-link">Tipe Icon</label>
                <select name="dt[type_icon]" class="form-control select2" id="tipe-icon" required="required">
                  <option value="icon">Icon</option>
                  <option value="image">Image</option>
                </select>
              </div>
              <div class="form-group" id="icon">
                <label for="form-icon">Icon</label>
                <select name="dt[icon]" id="sel-icon" class="form-control">
                </select>
                <small><i class="fa fa-info"></i> fa fa-info</small>
              </div>
              <div class="form-group" id="image">
                <label for="form-name">Image</label>
                <input type="file" class="form-control" id="form-image-icon" name="file_image_icon">
              </div>
              <div class="form-group txt-menu">
                <label for="form-link">Link</label>
                <select name="dt[function]" class="form-control select2 txt-menu" id="sel-link">
                  <option value="">- Pilih Link -</option>
                  <?php foreach ($data_url as $k => $v): ?>
                  <option value="<?= $v['val'] ?>" data-func="<?= str_replace("/index", "", $v['val']) ?>"><?= str_replace("/index", "", $v['val']) ?></option>
                  <?php endforeach ?>
                </select>
                <input type="hidden" class="form-control txt-menu" id="form-link" placeholder="Masukan Link" name="dt[link]">
                <small><i class="fa fa-info"></i> master/user</small>
              </div>
              <div class="form-group hidden">
                <label for="form-urutan">Urutan</label>
                <input type="text" class="form-control" id="form-urutan" placeholder="Masukan Urutan" name="dt[urutan]">
              </div>
              <div class="form-group">
                <label for="form-parent">Parent</label>
                <select name="dt[parent]" class="form-control select2" id="sel-parent">
                  <option value="0">Utama</option>
                  <?php
                    $menu_master = $this->mymodel->selectWhere('menu_master',['parent'=>0]);
                    foreach ($menu_master as $menu_master_record) {
                      echo "<option value=".$menu_master_record['id'].">".$menu_master_record['name']."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group txt-menu">
                <label for="form-notif">Notif</label>
                <input type="text" class="form-control txt-menu" id="form-notif" placeholder="Masukan Notif" name="dt[notif]">
                <small><i class="fa fa-info"></i> slug notif</small>
                
              </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
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
  <script type="text/javascript" src="<?= base_url('assets/fontawesome_icons.js'); ?>"></script>
  <script type="text/javascript">

    function format (icon) {
        return '<i class="fa fa-lg '+icon.text+'"></i>'+icon.text;
    } 
    jQuery(document).ready(function($) {
      getOptIcon();
      $("#sel-icon").select2({
          templateResult: format,
          templateSelection: format,
          escapeMarkup: function(m) { return m; }
      });
    });

    function getOptIcon() {
      $('#sel-icon').append('<option value="">- Pilih Icon -</option>');
      jQuery.each(fontawesome_icons, function(index, val) {
        $('#sel-icon').append('<option value="fa '+val+'"><span class="fa '+val+'"></span> '+val+'</option>');
      });
    }

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
                           window.location.href = "<?= base_url('master/Menu_master') ?>";
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

      $('#sel-parent').change(function(event) {
        jQuery.ajax({
          url: '<?= base_url('master/menu_master/getParent/'); ?>'+this.value,
          type: 'POST',
          dataType: 'json',
          success: function(data, textStatus, xhr) {
            $('#form-urutan').val(data.result)
          },
          error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
          }
        });
        
      });

      $('#sel-parent').change();

      $('#sel-type').change(function(event) {
        if (this.value=="label") {
          $('.txt-menu').val('');
          $('.txt-menu').hide();
        } else {
          $('.txt-menu').show();
        }
      });
      $('#sel-type').change();

      $('#sel-link').change(function(event) {
        link = $('option:selected', this).attr('data-func');
        $('#form-link').val(link);
      });

      document.getElementById("image").style.display = "none";
      
      $('#tipe-icon').change(function(event) {
        let val = this.value;
        if(val == "icon") {
          document.getElementById("icon").style.display = "block";
          document.getElementById("image").style.display = "none";
        } else {
          document.getElementById("icon").style.display = "none";
          document.getElementById("image").style.display = "block";
        }
      });
  </script>