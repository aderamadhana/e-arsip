 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DB Playground
        <small>Database</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Database</a></li>
        <li class="active">DB Playground</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <div class="row">
                <div class="col-md-2">
                  <label for="">Nama Kolom</label>
                  <select id="select-table" style="width: 150px" class="form-control select2">
                      <?php 
                      foreach($table_list as $list):
                      ?>
                        <option><?= $list['_tables'] ?></option>
                      <?php 
                      endforeach;
                      ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <button type="button" onclick="showTable()" style="margin-top: 23px;" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Set</button>
                </div>
            </div>
            <div class="box-body">
                <div class="show_error"></div>

              <div class="table-responsive">
                <div id="load-table">
                  
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    function showTable()
    {
      var table= $("#select-table").val()
      $("#load-table").html('<i class="fa fa-loading fa-spinner"> Loading</i>').load('<?= base_url("Database/ajaxLoadTable?table=") ?>'+table)
    }
  </script>