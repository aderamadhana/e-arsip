 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" style="background-color: #F5F7FF;">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       SPONSORSHIP
     </h1>
     <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
       <li><a href="#">Master</a></li>
       <li class="active">Sponsorship</li>
     </ol>
   </section>
   <!-- Main content -->
   <section class="content">
     <div class="row">

       <div class="col-md-12">
         <div class="panel">
           <!-- /.panel-header -->

           <div class="panel-body">
             <div class="filter">
               <div class="row" style="margin-bottom:10px">
                 <div class="col-md-12 table-responsive">
                   <table style="font-size: small;">
                     <tr>
                       <th>Nama Kegiatan</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th>Kategori Kegiatan</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th>Lingkup Kegiatan</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th>PIC</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th>Tanggal Pelaksanaan</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th style="width: 360px;">&nbsp;</th>
                     </tr>
                     <tr>
                       <td>
                         <input type="text" class="form-control" id="txt-nama-kegiatan" placeholder="Nama Kegiatan" />
                       </td>
                       <td>&nbsp;</td>
                       <td>
                         <?php $klasifikasi = $this->mymodel->selectWhere('klasifikasi', null); ?>
                         <select class="form-control select2" id="form-klasifikasi_id" style="width: 100%;" onchange="checkklasifikasi()">
                           <option value="">Semua Kategori</option>
                           <?php
                            foreach ($klasifikasi as $klasifikasi_record) {
                              echo "<option value=" . $klasifikasi_record['id'] . ">" . $klasifikasi_record['klasifikasi'] . "</option>";
                            }
                            ?>
                           <option value="0">Lainnya</option>
                         </select>
                         <input type="text" class="form-control" id="form-klasifikasi_nama" />
                       </td>
                       <td>&nbsp;</td>
                       <td>
                         <select id="form-lingkup_id" class="form-control select2" style="width: 100%;" onchange="checklingkup()">
                           <option value="">Semua Lingkup</option>
                           <?php
                            $lingkup = $this->mymodel->selectWhere('lingkup', null);
                            foreach ($lingkup as $lingkup_record) {
                              echo "<option value=" . $lingkup_record['id'] . ">" . $lingkup_record['lingkup'] . "</option>";
                            }
                            ?>
                           <option value="0">Lainnya</option>
                         </select>
                         <input type="text" class="form-control" id="form-lingkup_nama" />
                       </td>
                       <td>&nbsp;</td>
                       <td style="width: 100px;">
                         <select class="form-control select2" style="width: 100%;" multiple="multiple" id="sel-pic">
                           <?php
                            $user = $this->mymodel->selectWhere('user', ['departemen' => 2]);
                            foreach ($user as $user_record) {
                              echo "<option value=" . $user_record['id'] . ">" . $user_record['name'] . "</option>";
                            } ?>
                         </select>
                       </td>
                       <td>&nbsp;</td>
                       <td>
                         <input type="text" class="form-control tgl" id="form-tanggal" placeholder="Masukan Tanggal" />
                       </td>
                       <td>&nbsp;</td>
                       <td>
                         <button class="btn btn-primary" onclick="loadtable()" type="button" style="border-radius:0px"><i class="fa fa-filter"></i> Filter</button>
                         <button class="btn btn-warning" onclick="exportdata()" type="button" style="border-radius:0px"><i class="fa fa-file-excel-o"></i> Export</button>
                         <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
                           <a href="<?= base_url('master/Sponsorship/create') ?>">
                             <button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Sponsorship</button>
                           </a>
                         <?php endif ?>
                       </td>
                     </tr>
                   </table>
                 </div>
               </div>
             </div>
             <input type="hidden" id="dataId">
             <div class="table-responsive" id="load-table"></div>
             <button class="btn btn-danger btn-sm" type="button" onclick="hapuspilihdata()" id="btn-hapus-data"><i class="fa fa-trash"></i> Hapus Data Terpilih</button>
           </div>
           <!-- /.panel-body -->
         </div>
         <!-- /.panel -->
       </div>
       <!-- /.col -->
     </div>
     <!-- /.row -->
   </section>
   <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->

 <div class="modal fade" id="modal-impor">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         <h4 class="modal-title">Impor Sponsorship</h4>
       </div>
       <form action="<?= base_url('fitur/impor/sponsorship') ?>" method="POST" enctype="multipart/form-data">
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
 <script>
   function checkklasifikasi() {
     let klasifikasi = $("#form-klasifikasi_id").val();
     if (klasifikasi == 0 && klasifikasi != "") $("#form-klasifikasi_nama").show();
     else $("#form-klasifikasi_nama").hide();
   }

   function checklingkup() {
     let lingkup = $("#form-lingkup_id").val();
     if (lingkup == 0 && lingkup != "") $("#form-lingkup_nama").show();
     else $("#form-lingkup_nama").hide();
   }

   checklingkup();
   checkklasifikasi();
 </script>
 <script type="text/javascript">
   function buildData() {
     let nama_kegiatan = $("#txt-nama-kegiatan").val();
     let klasifikasi = $("#form-klasifikasi_id").val();
     let lingkup = $("#form-lingkup_id").val();
     let lain_klasifikasi = $("#form-klasifikasi_nama").val();
     let lain_lingkup = $("#form-lingkup_nama").val();
     let pic = $("#sel-pic").val();
     let tanggal = $("#form-tanggal").val();
     var json_filter = {
       nama_kegiatan: nama_kegiatan,
       klasifikasi: klasifikasi,
       lingkup: lingkup,
       lain_klasifikasi: lain_klasifikasi,
       lain_lingkup: lain_lingkup,
       pic: pic,
       tanggal: tanggal,
     }
     return json_filter;
   }

   var idrow = "";
   var idbutton = "";

   function loadtable() {
     var table = '<table class="table table-condensed table-striped datatables" id="mytable">' +
       '     <thead>' +
       '     <tr>' +
       '       <th style="width:20px">#</th>' +
       '       <th style="width:20px">No</th>' +
       '       <th>Nama kegiatan</th>' +
       '       <th>Lembaga / Organisasi Pengaju</th>' +
       '       <th>Nilai Sponsorship Disetujui</th>' +
       '       <th>Kategori Kegiatan</th>' +
       '       <th>Lingkup Kegiatan</th>' +
       '       <th>PIC</th>' +
       '       <th>Tanggal Pelaksanaan</th>' +
       '       <th style="width:100px">Status</th>' +
       '       <th style="width:150px"></th>' +
       '     </tr>' +
       '     </thead>' +
       '     <tbody>' +
       '     </tbody>' +
       ' </table>';
     // body...
     $("#load-table").html(table)
     var t = $("#mytable").DataTable({
       initComplete: function() {
         var api = this.api();
         $('#mytable_filter input')
           .off('.DT')
           .on('keyup.DT', function(e) {
             if (e.keyCode == 13) {
               api.search(this.value).draw();
             }
           });
       },
       oLanguage: {
         sProcessing: "loading..."
       },
       processing: true,
       serverSide: true,
       ajax: {
         "url": "<?= base_url('master/Sponsorship/json') ?>",
         "type": "POST",
         "data": buildData()
       },
       columns: [{
           "data": "id",
           "orderable": false,
           "className": "text-center"
         },
         {
           "data": "id",
           "orderable": false
         },
         {
           "data": "nama_kegiatan",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['nama_kegiatan'] + '</span>';
             return html;
           }
         },
         {
           "data": "lembaga_pengaju",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['lembaga_pengaju'] + '</span>';
             return html;
           }
         },
         {
           "data": "nilai_sponsor"
         },
         {
           "data": "klasifikasi_nama",
           render: function(data, type, row) {
             var val = row['klasifikasi_nama'] == null ? '' : row['klasifikasi_nama'];
             var html = '<span style="font-size:14px">' + val + '</span>';
             return html;
           }
         },
         {
           "data": "lingkup_nama",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['lingkup_nama'] + '</span>';
             return html;
           }
         },
         {
           "data": "pic",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['pic'] + '</span>';
             return html;
           }
         },
         {
           "data": "tanggal",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['tanggal'] + '</span>';
             return html;
           }
         },
         {
           "data": "informasi_pembayaran",
           "className": "text-center"
         },
         {
           "data": "view",
           "orderable": false
         }
       ],
       order: [
         [1, 'asc']
       ],
       columnDefs: [{
           targets: [0],
           render: function(data, type, row, meta) {
             var cbinput = $("#dataId").val();
             cb = cbinput.split(',');
             var checked = "";
             if (cb.includes(row['id'])) checked = "checked";
             if (cbinput == "all") checked = "checked";
             return "<input type='checkbox' onclick='checkdata($(this)," + row['id'] + ")' value='" + row['id'] + "' " + checked + ">";
           }
         },
         {
           targets: [4],
           render: function(data, type, row, meta) {
             if (data == null) {
               return data;
             } else {
               return '<span style="font-size:14px">' + numberWithCommas(data) + '</span>';
             }
           }
         },
         {
           targets: [9],
           render: function(data, type, row, meta) {
             if (row['informasi_pembayaran'] == 'Sudah Bayar') {
               var htmls = "<label class='badge bg-green'><span style='font-size:14px'>Lengkap</span></label>";
             } else {
               var htmls = "<label class='badge bg-red'><span style='font-size:14px'>Belum Lengkap</span></label>";
             }
             return htmls;
           }
         }
       ],

       rowCallback: function(row, data, iDisplayIndex) {
         var info = this.fnPagingInfo();
         var page = info.iPage;
         var length = info.iLength;
         var index = page * length + (iDisplayIndex + 1);
         $('td:eq(1)', row).html('<span style="font-size:14px">' + index + '</span>');
         jQuery.ajax({
           url: '<?= base_url('master/sponsorship/getdatapic'); ?>/' + data['id'],
           type: 'POST',
           dataType: 'html',
           beforeSend: function(datas, textStatus, xhr) {
             $('td:eq(7)', row).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
           },
           success: function(datas, textStatus, xhr) {
             $('td:eq(7)', row).html(datas);
           },
           error: function(xhr, textStatus, errorThrown) {
             $('td:eq(7)', row).html('-');
           }
         });

       }
     });
   }
   loadtable();

   function numberWithCommas(x) {
     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
   }

   function edit(id, e) {
     location.href = "<?= base_url('master/Sponsorship/edit/') ?>" + id;
   }

   function hapus(id, e) {
     idrow = e.parent().parent().parent();
     idbutton = e.parent().parent();
     Swal.fire({
       title: 'Warning ?',
       text: "Are you sure you delete this data",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, delete it!'
     }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: "<?= base_url('master/sponsorship/delete/') ?>",
           type: 'post',
           dataType: 'html',
           data: {
             id: id
           },
           beforeSend: function() {},
           success: function(response, textStatus, xhr) {
             var str = response;
             if (str.indexOf("success") != -1) {
               idbutton.html('<label class="badge bg-red">Deleted</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label>');
               idrow.addClass('bg-danger');
               Swal.fire(
                 'Deleted!',
                 'Your data has been deleted.',
                 'success'
               );
             } else {
               Swal.fire({
                 title: "Oppss!",
                 html: str,
                 icon: "error"
               });
             }
           }
         });
       }
     })
   }

   var array = [];

   function checkdata(e, id) {
     if (e.is(':checked')) {
       if (!array.includes(e.val())) array.push(e.val());
     } else {
       var removeItem = e.val();
       array = jQuery.grep(array, function(value) {
         return value != removeItem;
       });
     }
     $("#dataId").val(array.join())
   }

   function hapuspilihdata() {
     var data = $('#dataId').val();
     Swal.fire({
       title: 'Warning ?',
       text: "Are you sure you delete this data",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, delete it!'
     }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: '<?= base_url('master/sponsorship/Deletedata/') ?>',
           type: 'post',
           dataType: 'html',
           data: {
             data: data
           },
           beforeSend: function() {

           },
           success: function() {
             loadtable($("#select-status").val());
             $('#dataId').val('');
             Swal.fire(
               'Deleted!',
               'Your data has been deleted.',
               'success'
             )
           }
         });
       }
     })
   }

   function exportdata() {
     location.href = "<?= base_url('master/sponsorship/exportexcel') ?>";
   }
 </script>