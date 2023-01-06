 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Pegawai
        <small>master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">pegawai</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
          
            <div class="box-body">
                <div class="show_error"></div>

              <div class="table-responsive">
                <table class="table table-bordered" id="mytable">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>username</th>
                      <th>Nama</th>
                      <th>Satker</th>
                      <th>Nama Barang</th>
                      <th>Merk/Type</th>
                      <th>Tipe Konfirmasi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>15515020512</td>
                      <td>Alif</td>
                      <td>BIRO UMUM DAN PENGADAAN</td>
                      <td>Komputer</td>
                      <td>Comp</td>
                      <td><span class="label label-success">Ajukan Barang</span>
                      </td>
                      <td>
                        <button class="btn btn-success btn-sm"><i class="fa fa-check"> Konfirmasi</i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>15515020512</td>
                      <td>Prasetyo</td>
                      <td>BIRO UMUM DAN PENGADAAN</td>
                      <td>Komputer</td>
                      <td>Comp</td>
                      <td><span class="label label-warning">Update Kondisi</span>
                      </td>
                      <td>
                        <button class="btn btn-success btn-sm"><i class="fa fa-check"> Konfirmasi</i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>15515020512</td>
                      <td>Aji</td>
                      <td>BIRO UMUM DAN PENGADAAN</td>
                      <td>Komputer</td>
                      <td>Comp</td>
                      <td><span class="label label-danger">Menolak Barang</span>
                      </td>
                      <td>
                        <button class="btn btn-success btn-sm"><i class="fa fa-check"> Konfirmasi</i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
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

  <div class="modal fade bd-example-modal-sm" tabindex="-1" konfig="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <form id="upload-delete" action="<?= base_url('master/Konfig/delete') ?>">
              <div class="modal-header">
                  <h5 class="modal-title">Confirm delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id" id="delete-input">
                  <p>Are you sure to delete this data?</p>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
              </form>
          </div>
      </div>
  </div> 

  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Impor</h4>
        </div>
        <form action="<?= base_url('fitur/impor/konfig') ?>" method="POST"  enctype="multipart/form-data">

        <div class="modal-body">
            <div class="form-group">
              <label for="">File Excel</label>
              <input type="file" class="form-control" id="" name="file" placeholder="Input field">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
        </form>

      </div>
    </div>
  </div>

  <script type="text/javascript">
$(document).ready(function() {

 
    // DataTable
    var table = $('#mytable').DataTable();
 
    // Apply the search

});
</script>
