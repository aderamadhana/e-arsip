  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update
        <small>Status Penggunaan Aset</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Update</a></li>
        <li class="active">Aset</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
       <!--    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Assign Assets</a></li>
              <li><a href="#tab_2" data-toggle="tab">Daftar Pengajuan</a></li>
              <li><a href="#tab_3" data-toggle="tab">Update Asset</a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane in active" id="tab_1"> -->
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#subtab_1" data-toggle="tab">Pegawai</a></li>
                      <li><a href="#subtab_2" data-toggle="tab">DIR</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane in active" id="subtab_1">
                         <div class="row">
                          <div class="col-md-6">
                              <label>Cari Pegawai</label>
                              <input type="text" name="" placeholder="Cari.." class="form-control">
                              <button class="btn btn-primary pull-right" style="margin-top: 10px;margin-bottom: 10px; " onclick = "showtable()">Pilih</button>
                            <br>
                            <div style="display: none;margin-top: 30px;" id="showtable1" >                        
                            <table class="table table-bordered" width="100%">
                              <tr>
                                <th colspan="2">DETAIL PEGAWAI</th>
                              </tr>
                              <tr>
                                <td colspan="2" align="center"><img src="https://www.pngitem.com/pimgs/m/334-3344170_user-vector-user-flat-png-transparent-png.png" width="150px" height="200px"></td>
                              </tr>
                              <tr>
                                <td>username</td>
                                <td>000000001</td>
                              </tr>
                              <tr>
                                <td>NAMA PEGAWAI</td>
                                <td>XX SAMPLE NAMA</td>
                              </tr>
                              <tr>
                                <td>Jenis Kelamin</td>
                                <td>P</td>
                              </tr>
                              <tr>
                                <td>Nama Satker</td>
                                <td>BIRO UMUM DAN PENGADAAN</td>
                              </tr>
                            </table>
                            </div>
                          </div>
                            <div class="col-md-6" style="display: none;" id="showtable2">
                              <label>List Barang yang sedang dikelola ( XX SAMPLE NAMA ) </label>
                            <br>        
                              <table class="table table-bordered table-striped mytable">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk/Type</th>
                                    <th>Kondisi</th>
                                    <th>Tanggal Awal Perizinan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>Toyota New Cor. / Altis</td>
                                    <td>Baik</td>
                                    <td>12 Juni 2019</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>TOYOTA INNOVA</td>
                                    <td>Baik</td>
                                    <td>01 April 2019</td>
                                  </tr>
                                    <tr>
                                    <td>3</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>CHEVROLET</td>
                                    <td>Baik</td>
                                    <td>05 Mei 2019</td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>L-300 MITSUBISHI</td>
                                    <td>Baik</td>
                                    <td>12 Desember 2019</td>
                                  </tr>
                                  <tr>
                                    <td>5</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>TOYOTA KIJANG INNOVA</td>
                                    <td>Baik</td>
                                    <td>17 November 2019</td>
                                  </tr>
                                </tbody>   
                              </table>
                              <label>Cari Barang</label>
                              <input type="text" name="" placeholder="Cari.." class="form-control">
                              <button class="btn btn-primary pull-right" style="margin-top: 10px;margin-bottom: 10px; " onclick="listbarang()">Pilih</button>
                            <br>
                              <div style="display: none;" id="listbarang1">
                              <table class="table table-bordered" >
                                <tr>
                                  <th>#</th>
                                  <th>Detail Barang</th>
                                  <th width="5">Action</th>
                                </tr>
                                <tr>
                                  <td>1</td>
                                  <td>3100101999 / 1<br><small><b>WIRELESS ACSES POINT WAP 610N</b></small>
                                  <br><small>Komputer Jaringan Lainnya</small>
                                  </td>
                                  <td><button type="button" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close"></i></button></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>3020101001 / 3<br><small><b>NISSAN SERENA 2.0LA/T HWS A</b></small>
                                  <br><small>Sedan</small>
                                  </td>
                                  <td><button type="button" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close"></i></button></td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>3100102001 / 2<br><small><b>HP PAVILION 200</b></small>
                                  <br><small>P.C Unit</small>
                                  </td>
                                  <td><button type="button" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close"></i></button></td>
                                </tr>                
                              </table>
                              </div>
                                  <div class="box-footer" style="display: none;" id="btn-assign1">
                                  <button type="submit" class="pull-right btn btn-primary"><i class="fa fa-send "> Assign asset</i></button>

                                  </div>            

                                  </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.panel -->
                            </div>
                       <div class="tab-pane" id="subtab_2">
                         <div class="row">
                          <div class="col-md-6">
                              <label>Cari Ruangan</label>
                              <input type="text" name="" placeholder="Cari.." class="form-control">
                              <button class="btn btn-primary pull-right" style="margin-top: 10px;margin-bottom: 10px; " onclick="cariruangan()">Pilih</button>
                            <br>

                              <div style="display: none;" id="table3">
                              <table class="table table-bordered">
                                <tr>
                                  <th colspan="2">DETAIL RUANGAN</th>
                                </tr>
                                <tr>
                                  <td>KODE RUANGAN</td>
                                  <td>701</td>
                                </tr>
                                <tr>
                                  <td>NAMA RUANGAN</td>
                                  <td>RUANG ADMINISTRASI</td>
                                </tr>
                                <tr>
                                  <td>LOKASI</td>
                                  <td>LANTAI 7 GEDUNG A</td>
                                </tr>
                            </table>
                          </div>
                          </div>
                                  <div class="col-md-6" style="display: none;" id="table4">
                              <label>List Barang yang sedang dikelola ( XX SAMPLE NAMA ) </label>
                            <br>        
                              <table class="table table-bordered table-striped mytable">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk/Type</th>
                                    <th>Kondisi</th>
                                    <th>Tanggal Awal Perizinan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>Toyota New Cor. / Altis</td>
                                    <td>Baik</td>
                                    <td>12 Juni 2019</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>TOYOTA INNOVA</td>
                                    <td>Baik</td>
                                    <td>01 April 2019</td>
                                  </tr>
                                    <tr>
                                    <td>3</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>CHEVROLET</td>
                                    <td>Baik</td>
                                    <td>05 Mei 2019</td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>L-300 MITSUBISHI</td>
                                    <td>Baik</td>
                                    <td>12 Desember 2019</td>
                                  </tr>
                                  <tr>
                                    <td>5</td>
                                    <td>3020101001</td>
                                    <td>Sedan</td>
                                    <td>TOYOTA KIJANG INNOVA</td>
                                    <td>Baik</td>
                                    <td>17 November 2019</td>
                                  </tr>
                                </tbody>   
                              </table>
                              <label>Cari Barang</label>
                              <input type="text" name="" placeholder="Cari.." class="form-control">
                              <button class="btn btn-primary pull-right" style="margin-top: 10px;margin-bottom: 10px; " onclick="daftarbarang()">Pilih</button>
                            <br>
                              <div style="display: none;" id="listbarang2">
                              <table class="table table-bordered" >
                                <tr>
                                  <th>#</th>
                                  <th>Detail Barang</th>
                                  <th width="5">Action</th>
                                </tr>
                                <tr>
                                  <td>1</td>
                                  <td>3100101999 / 1<br><small><b>WIRELESS ACSES POINT WAP 610N</b></small>
                                  <br><small>Komputer Jaringan Lainnya</small>
                                  </td>
                                  <td><button type="button" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close"></i></button></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>3020101001 / 3<br><small><b>NISSAN SERENA 2.0LA/T HWS A</b></small>
                                  <br><small>Sedan</small>
                                  </td>
                                  <td><button type="button" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close"></i></button></td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>3100102001 / 2<br><small><b>HP PAVILION 200</b></small>
                                  <br><small>P.C Unit</small>
                                  </td>
                                  <td><button type="button" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close"></i></button></td>
                                </tr>                
                              </table>
                              </div>
                                  <div class="box-footer" style="display: none;" id="btn-assign2">
                                  <button type="submit" class="pull-right btn btn-primary"><i class="fa fa-send "> Assign asset</i></button>

                                  </div>            

                                  </div>
                      </div>
                    </div>
                </div>
              </div>
<!--               <div class="tab-pane" id="tab_2">
                <label>Daftar Pegawai</label>
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
              </div> -->
          
       <!--    </div>
        </div>
      </div> -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
      function showtable() { 
        document.getElementById("showtable1").style.display="inline";
        document.getElementById("showtable2").style.display="inline";
    }
      function listbarang() { 
        document.getElementById("listbarang1").style.display="inline";
        document.getElementById("btn-assign1").style.display="inline";

    }
         function cariruangan() { 
        document.getElementById("table3").style.display="inline";
        document.getElementById("table4").style.display="inline";

    }
      function daftarbarang() { 
        document.getElementById("listbarang2").style.display="inline";
        document.getElementById("btn-assign2").style.display="inline";

    }


$(document).ready(function() {


    // DataTable
    var table = $('.mytable').DataTable();
     var tables = $('#mytables').DataTable();

    // Apply the search

});
</script>
