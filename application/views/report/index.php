<div class="content-wrapper" style="background-color: #F5F7FF;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		<?= $page_name ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?= $page_name ?></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- /.col -->
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body ">
					    <div class="row">
					        <div class="col-md-3">
					        	<label>Kategori Surat</label>
					            <select class="form-control" id="kategori">
					            	<option value=""> Pilih </option>
									<?php
									$kategori_surat = $this->mymodel->selectWhere('m_kategori_surat',array('status'=>'ENABLE'));
									foreach($kategori_surat as $ks){
										?>
										<option value="<?=$ks['id']?>"><?=$ks['mkt_kategori']?></option>
										<?php
									}
									?>
								</select>
					        </div>
					        <div class="col-md-3">
					        	<button class="btn btn-primary" type="button" onclick="set_tables()" style="margin-top: 24px"><i class="fa fa-filter"></i></button>
					        </div>
					    </div>
						<br>
                        <div class="table-responsive">  
                            <div id="load-table">
                        </div>
						
							<!-- /.table -->
						</div>
						<script type="text/javascript">
	function set_tables() {
      $('#load-table').html('<table class="table table-hover table-responsive table-condensed table-bordered table-striped listSurat" id="myTable" style="width: 100%;">'+
							'	<thead class="bg-navy">'+
							'		<tr>'+
							'			<th>No</th>'+
							'			<th>Tanggal</th>'+
							'			<th>Signer</th>'+
							'			<th>Nomor Surat</th>'+
							'			<th>Dikirimkan Kepada</th>'+
							'			<th>Perihal</th>'+
							'			<th>PIC & NO.Telp</th>'+
                            '           <th>Aksi</th>'+
							'		</tr>'+
							'	</thead>'+
							'	<tbody>'+
							'	</tbody>'+
							'</table>');
      var url = '?kategori='+$('#kategori').val();
		loadtable(url);
    }

	function loadtable(url='') {

        var t = $("#myTable").dataTable({
        	// scrollX : true,
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
    		stateSave: true,
    		"bDestroy": true,
            ajax: {"url": "<?= base_url('report/json') ?>"+url, "type": "POST"},
            data: {param1: 'value1'},
            columns: [
                {"data": "ad_id","orderable": false},
                {
                	"data": "ad_tanggalsurat",
                	render : function (data, type, row) {
            			var html = row['tanggal_surat'];
            			return html;
            		}
            	},
                {"data": "ad_tandatangan"},
                {
                	"data": "ad_nomorsurat",
                	render : function (data, type, row) {
            			var html = '<a href="#">'+row['ad_nomorsurat']+'</a>';
            			return html;
            		}
            	},
                {"data": "ad_dikirim"},
                {"data": "ad_perihal"},
                 {
                	"data": "ad_notelp",
                	render : function (data, type, row) {
            			var html = row['ad_pic']+'/'+row['ad_notelp'];
            			return html;
            		}
            	},
                {"data": "view",'orderable':false},
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);

                var nomor = data['ad_nomorsurat'];
        		var array_nomor = nomor.split('/')
        		if(data['ad_is_booking']=='1') nomor = array_nomor[0]

                if(data['ad_pic']=='' || data['ad_is_booking'] == '1' ){
                    $('td:eq(3)', row).html('<a href="<?=base_url()?>arsip_dokumen/addSuratKeluar/'+data['ad_id']+'">'+nomor+'</a>');
                }else{
                    $.ajax({
                    	url : "<?=base_url()?>arsip_dokumen/getSonEncode/"+data['ad_id'],
                    	success : function(view){
                    		$('td:eq(3)', row).html('<a href="<?=base_url()?>arsip_dokumen/detail/'+view+'">'+nomor+'</a>');
                    	}
                    });    
                }
                
            }
        });
    }
    set_tables();
    function deleteSurat(id)
    {
        Swal.fire({
          title: 'Peringatan',
          text: "Apakah anda yakin akan menghapus surat ini ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.post('<?= base_url("Arsip_dokumen/aksiHapus") ?>',{ad_id : id},function(result){
                Swal.fire(
                  'Deleted!',
                  'Surat Berhasil Dihapus',
                  'success'
                )
                set_tables()
            })
          }
        })      
    }
</script>
						<!-- /.mail-box-messages -->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /. box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>