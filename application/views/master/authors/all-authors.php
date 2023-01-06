 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Authors
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Authors</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="panel">
            <!-- /.panel-header -->
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-12">
                  <div class="pull-right">          
                    <button type="button" onclick="create()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Authors</button>
                    <a href="<?= base_url('fitur/ekspor/authors') ?>" target="_blank">
                      <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> Ekspor Authors</button> 
                    </a>
                    <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> Import Authors</button>
                  </div>
                </div>  
              </div>
            </div>
            <div class="panel-body">
                <div class="filter">
                  
      <div class="row" style="margin-bottom:10px">
            
                    <div class="col-md-2 ">
                      <small for="">Status</small>
                      <select onchange="loadtable(this.value)" id="select-status" style="" class="form-control input-sm">
                          <option value="ENABLE">ENABLE</option>
                          <option value="DISABLE">DISABLE</option>
                      </select>
                    </div>
        <div class="col-md-2 ">
            <button class="btn btn-primary" onclick="loadtable('ENABLE')" type="button" style="margin-top:25px;border-radius:0px"><i class="fa fa-filter"></i> Filter</button>
        </div>
      </div>

                </div>
                <input type="hidden" id="dataId">
                <div id="load-table"></div>
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

  <div class="modal fade bd-example-modal-sm" tabindex="-1" authors="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">
                  <span  id="title-form" ></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                  </h5>
                  
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                  <div id="load-form"></div>
                </div>
              </div>

          </div>
      </div>
  </div> 

  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Impor Authors</h4>
        </div>
        <form action="<?= base_url('fitur/impor/authors') ?>" method="POST"  enctype="multipart/form-data">
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
    

    var idrow = "";
    var idbutton = "";

    function loadtable(status) {
          var table = '<table class="table table-condensed table-striped datatables" id="mytable">'+
                      '     <thead>'+
                      '     <tr>'+
                      '       <th style="width:20px">#</th>'+
                      '       <th style="width:20px">No</th>'+
                      '       <th>First name</th>'+
                      '       <th>Last name</th>'+
                      '       <th>Email</th>'+
                      '       <th>Birthdate</th>'+
                      '       <th>Address</th>'+
                      '       <th style="width:100px">Status</th>'+
                      '       <th style="width:150px"></th>'+
                      '     </tr>'+

                      '     </thead>'+
                      '     <tbody>'+
                      '     </tbody>'+
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
                ajax: {"url": "<?= base_url('master/Authors/json?status=') ?>"+status, "type": "POST"},
                columns: [
                    {"data": "id","orderable": false, "className": "text-center"},
                    {"data": "id","orderable": false},
                    {"data": "first_name"},
                    {"data": "last_name"},
                    {"data": "email"},
                    {"data": "birthdate"},
                    {"data": "address"},
                    {"data": "status", "className": "text-center"},
                    {"data": "view", "orderable": false
                    }
                ],
                order: [[1, 'asc']],
                columnDefs : [
                    { 
                      targets : [0],
                        render : function (data, type, row, meta) {
                          var cbinput = $("#dataId").val();
                          cb = cbinput.split(',');
                          var checked = "";
                          if(cb.includes(row['id'])) checked = "checked";
                          if(cbinput=="all") checked = "checked";
                          return "<input type='checkbox' onclick='checkdata($(this),"+row['id']+")' value='"+row['id']+"' "+checked+">";
                          }
                    },
                  
                    
                    { targets : [7],
                        render : function (data, type, row, meta) {
                                if(row['status']=='ENABLE'){
                                  var htmls = '<a href="<?= base_url('master/Authors/status/') ?>'+row['id']+'/DISABLE">'+
                                            '    <button type="button" class="btn btn-sm btn-sm btn-success"><i class="fa fa-home"></i> ENABLE</button>'+
                                            '</a>';
                              }else{
                                  var htmls = '<a href="<?= base_url('master/Authors/status/') ?>'+row['id']+'/ENABLE">'+
                                            '    <button type="button" class="btn btn-sm btn-sm btn-danger"><i class="fa fa-home"></i> DISABLE</button>'+
                                            '</a>';
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
                    $('td:eq(1)', row).html(index);
                    
                }
            });
         }
         loadtable($("#select-status").val());
           
      function edit(id,e) {
        idrow = e.parent().parent().parent();
        idbutton = e.parent().parent();
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Edit Authors');
        $("#load-form").load("<?= base_url('master/Authors/edit/') ?>"+id);
      }

      function create() {
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Create Authors');
        $("#load-form").load("<?= base_url('master/Authors/create/') ?>");
      }
                  
      function hapus(id,e) {
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
                  url: '<?= base_url('master/'.authors.'/delete/')?>',
                type: 'post',
                dataType: 'html',
                data: {id: id},
                beforeSend:function () { },
                success:function(response, textStatus, xhr) {
                  var str = response;
                    if (str.indexOf("success") != -1){
                      idbutton.html('<label class="badge bg-red">Deleted</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label>');
                      idrow.addClass('bg-danger');
                      Swal.fire(
                          'Deleted!',
                        'Your data has been deleted.',
                        'success'
                      );
                    }else{
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
      function checkdata(e,id) {
        if(e.is(':checked')){
          if(!array.includes(e.val())) array.push(e.val());
        }else{ 
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
              url: '<?= base_url('master/'.authors.'/Deletedata/')?>',
              type: 'post',
              dataType: 'html',
              data: {data: data},
              beforeSend:function () {

              },
              success:function() {
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
  </script>