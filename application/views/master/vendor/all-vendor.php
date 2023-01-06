 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" style="background-color: #F5F7FF;">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       VENDOR/KONSULTAN
     </h1>
     <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
       <li><a href="#">Master</a></li>
       <li class="active">Vendor</li>
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
                       <th style="width:13%">Tipe</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th style="width:13%">PIC</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th style="width:13%">Status</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th style="width:13%">Tanggal</th>
                       <th style="width: 15px;">&nbsp;</th>
                       <th style="width:5%">&nbsp;</th>
                       <th>&nbsp;</th>
                       <th>&nbsp;</th>
                     </tr>
                     <tr>
                       <td>
                         <select id="form-kategori" class="form-control">
                           <option value="">Semua Tipe</option>
                           <option value="consultant">Consultant</option>
                           <option value="vendor">Vendor</option>
                         </select>
                       </td>
                       <td>&nbsp;</td>
                       <td style="width: 150px;">
                         <select class="form-control select2" style="width: 100%;" multiple="multiple" id="sel-pic">
                           <option value="">Semua PIC</option>
                           <?php
                            $user = $this->mymodel->selectWhere('user', null);
                            foreach ($user as $user_record) {
                              echo "<option value=" . $user_record['id'] . ">" . $user_record['name'] . "</option>";
                            }
                            ?>
                         </select>
                       </td>
                       <td>&nbsp;</td>
                       <td style="width: 130px;">
                         <select id="sel-status" class="form-control input-sm">
                           <option value="">Semua Status</option>
                           <option value="1">Terlaksana</option>
                           <option value="2">Tidak Terlaksana</option>
                         </select>
                       </td>
                       <td>&nbsp;</td>
                       <td style="width: 100px;">
                         <input type="text" class="form-control tgl input-sm" id="form-tanggal" placeholder="Masukan Tanggal">
                       </td>
                       <td>&nbsp;</td>
                       <td>
                         <button class="btn btn-primary" onclick="loadtable()" type="button" style="border-radius:0px"><i class="fa fa-filter"></i> Filter</button>
                       </td>
                       <td>&nbsp;</td>
                       <td style="float: right;">
                         <button class="btn btn-warning" onclick="exportdata()" type="button" style="border-radius:0px"><i class="fa fa-file-excel-o"></i> Export</button>

                         <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
                           <a href="<?= base_url('master/Vendor/create') ?>">
                             <button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Vendor/Konsultan</button>
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
             <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
               <button class="btn btn-danger btn-sm" type="button" onclick="hapuspilihdata()" id="btn-hapus-data"><i class="fa fa-trash"></i> Hapus Data Terpilih</button>
             <?php endif ?>
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
         <h4 class="modal-title">Impor Vendor</h4>
       </div>
       <form action="<?= base_url('fitur/impor/Vendor') ?>" method="POST" enctype="multipart/form-data">
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
   function buildData() {
     let tipe = $('#form-kategori').val();
     let pic = $('#sel-pic').val();
     let status = $('#sel-status').val();
     let tanggal = $('#form-tanggal').val();
     var json_filter = {
       tipe: tipe,
       pic: pic,
       status: status,
       tanggal: tanggal
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
       '       <th>Nama Vendor/Konsultan</th>' +
       '       <th>Tanggal Mulai Pelaksanaan</th>' +
       '       <th>Tanggal Selesai Pelaksanaan</th>' +
       '       <th>Penjelasan Singkat</th>' +
       '       <th>Penilaian</th>' +
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
         "url": "<?= base_url('master/Vendor/json') ?>",
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
           "data": "nama",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['nama'] + '</span>';
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
           "data": "tanggal_selesai",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['tanggal_selesai'] + '</span>';
             return html;
           }
         },
         {
           "data": "penjelasan_singkat",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['penjelasan_singkat'] + '</span>';
             return html;
           }
         },
         {
           "data": "penilaian_hasil",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['penilaian_hasil'] + '</span>';
             return html;
           }
         },
         {
           "data": "is_kegiatan_terlaksana",
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
           targets: [7],
           render: function(data, type, row, meta) {
             if (row['is_kegiatan_terlaksana'] == '1') {
               var htmls = "<label class='badge bg-green'><span style='font-size:14px'>Terlaksana</span></label>";
             } else {
               var htmls = "<label class='badge bg-red'><span style='font-size:14px'>Tidak Terlaksana</span></label>";
             }
             return htmls;
             // return "<label class='badge bg-orange'>-</label>"
           }
         }
       ],

       rowCallback: function(row, data, iDisplayIndex) {
         var info = this.fnPagingInfo();
         var page = info.iPage;
         var length = info.iLength;
         var index = page * length + (iDisplayIndex + 1);
         $('td:eq(1)', row).html('<span style="font-size:14px">' + index + '</span>');
         // jQuery.ajax({
         //   url: '<?= base_url('master/vendor/getdatapic'); ?>/'+data['id'],
         //   type: 'POST',
         //   dataType: 'html',
         //   beforeSend: function(datas, textStatus, xhr) {
         //   $('td:eq(6)', row).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
         //   },
         //   success: function(datas, textStatus, xhr) {
         //   $('td:eq(6)', row).html(datas);
         //   },
         //   error: function(xhr, textStatus, errorThrown) {
         //   $('td:eq(6)', row).html('-');
         //   }
         // });

       }
     });
   }
   loadtable();

   function edit(id, e) {
     location.href = "<?= base_url('master/vendor/edit/') ?>" + id;
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
           url: '<?= base_url('master/' . vendor . '/delete/') ?>',
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
           url: '<?= base_url('master/' . vendor . '/Deletedata/') ?>',
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
     location.href = "<?= base_url('master/vendor/exportexcel/') ?>";
   }
 </script>