 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" style="background-color: #F5F7FF;">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       DIGITALISASI SPK
     </h1>
     <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
       <li><a href="#">Master</a></li>
       <li class="active">Spk</li>
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
                 <div class="col-md-2 ">
                   <small for="">Tanggal</small>
                   <input class="form-control tgl" type="text" id="txt-tanggal">
                 </div>
                 <div class="col-md-2">
                   <button class="btn btn-primary" onclick="loadtable()" type="button" style="margin-top:25px;border-radius:0px"><i class="fa fa-filter"></i> Filter</button>
                 </div>
                 <div class="col-md-2"></div>
                 <div class="col-md-6">
                   <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
                     <a href="<?= base_url('master/Vendor/create') ?>">
                       <button type="button" class="btn btn-success pull-right" style="margin-left:5px;margin-top:25px;border-radius:0px"><i class="fa fa-plus"></i> Tambah Vendor/Konsultan</button>
                     </a>
                     <a href="<?= base_url('master/Spk/create') ?>">
                       <button type="button" class="btn btn-success pull-right" style="margin-left:5px;margin-top:25px;border-radius:0px"><i class="fa fa-plus"></i> Tambah SPK</button>
                     </a>
                   <?php endif ?>

                   <button class="btn btn-warning pull-right" onclick="exportdata()" type="button" style="margin-top:25px;border-radius:0px"><i class="fa fa-file-excel-o"></i> Export</button>
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
         <h4 class="modal-title">Impor Spk</h4>
       </div>
       <form action="<?= base_url('fitur/impor/Spk') ?>" method="POST" enctype="multipart/form-data">
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
     var tanggal = $('#txt-tanggal').val();
     var json_filter = {
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
       '       <th>Nomor SPK</th>' +
       '       <th>Tanggal SPK</th>' +
       '       <th>Nama Perusahaan</th>' +
       '       <th>Jenis Pekerjaan</th>' +
       // '       <th style="width:100px">Status</th>'+
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
         "url": "<?= base_url('master/Spk/json') ?>",
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
           "data": "nomor_spk",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['nomor_spk'] + '</span>';
             return html;
           }
         },
         {
           "data": "tanggal_spk",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['tanggal_spk'] + '</span>';
             return html;
           }
         },
         {
           "data": "nama_perusahaan",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['nama_perusahaan'] + '</span>';
             return html;
           }
         },
         {
           "data": "jenis_pekerjaan",
           render: function(data, type, row) {
             var html = '<span style="font-size:14px">' + row['jenis_pekerjaan'] + '</span>';
             return html;
           }
         },
         // {"data": "status", "className": "text-center"},
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


         // { targets : [6],
         // render : function (data, type, row, meta) {
         //   if(row['status']=='ENABLE'){
         //     var htmls = '<a href="<?= base_url('master/Spk/status/') ?>'+row['id']+'/DISABLE">'+
         //               '    <button type="button" class="btn btn-sm btn-sm btn-success"><i class="fa fa-home"></i> ENABLE</button>'+
         //               '</a>';
         // }else{
         //     var htmls = '<a href="<?= base_url('master/Spk/status/') ?>'+row['id']+'/ENABLE">'+
         //               '    <button type="button" class="btn btn-sm btn-sm btn-danger"><i class="fa fa-home"></i> DISABLE</button>'+
         //               '</a>';
         // }
         // return htmls;
         // return "<label class='badge bg-orange'>-</label>"
         // }
         // }
       ],

       rowCallback: function(row, data, iDisplayIndex) {
         var info = this.fnPagingInfo();
         var page = info.iPage;
         var length = info.iLength;
         var index = page * length + (iDisplayIndex + 1);
         $('td:eq(1)', row).html('<span style="font-size:14px">' + index + '</span>');

       }
     });
   }
   loadtable();

   function edit(id, e) {
     location.href = "<?= base_url('master/Spk/edit/') ?>" + id;
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
           url: '<?= base_url('master/spk/delete/') ?>',
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
           url: '<?= base_url('master/spk/Deletedata/') ?>',
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
     location.href = "<?= base_url('master/spk/exportexcel') ?>";
   }
 </script>