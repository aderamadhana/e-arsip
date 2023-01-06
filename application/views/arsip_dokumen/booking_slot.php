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
            <div class="col-md-12">
                <?= $view_menu ?>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body ">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
                                <a href="<?= base_url('arsip_dokumen/addSuratKeluar') ?>" class="btn btn-danger btn-block margin-bottom"><i class="fa fa-sign-out"></i> Tambah Surat Keluar</a>
                            <?php endif ?>
                        </div>
                        <!-- <div class="row">
					    		<div class="col-md-2">
						        	<label for="">Sifat Surat</label>
						            <select class="form-control" name="sifat" id="filter-sifat">
										<option value="">Semua</option>
										<option value="biasa">Biasa</option>
										<option value="rahasia">Rahasia</option>
										<option value="sangat_rahasia">Sangat Rahasia</option>
									</select>
						        </div>
						        <div class="col-md-2">
						        	<label >Bentuk Surat</label>
						            <select class="form-control" name="bentuk" id="filter-bentuk">
										<option value="">Semua</option>
										<option value="surat">Surat</option>
										<option value="surat_dan_proposal">Surat dan Proposal</option>
										<option value="surat_dan_dokumen_pendukung_lainnya">Surat dan Pendukung Lainnya</option>
									</select>
						        </div>
						        <div class="col-md-3">
						         	<label>Kategori Tujuan</label>
					            	<select class="form-control" name="kategori" id="filter-kategori">
	    								<option value="">Semua</option>
	    								<option value="CSR & Community Development">CSR & Community Development</option>
										<option value="Corporate Communication">Corporate Communication</option>
										<option value="Office of The Board 1">Office of The Board 1</option>
										<option value="Office of The Board 2">Office of The Board 2</option>
										<option value="Corsec & Stakeholder Management">Corsec & Stakeholder Management</option>
	    							</select>
						        </div>
						        <div class="col-md-2">
						         	<label><i>Due Date</i></label>
					            	<input type="text" class="form-control tgl" name="duedate" value="<?= @$_GET['duedate'] ?>" id="filter-duedate">
						        </div>
						        <div class="col-md-1">
						            <button class="btn btn-primary" style="margin-top: 27px;" onclick="set_tables()">Filter</button>
						        </div>
                                <?php
                                if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_departemen'])) :
                                ?>
                                    <div class="col-md-1">
                                        <button class="btn btn-warning" style="margin-top: 27px;" onclick="showAkses()"><i class="fa fa-users"></i> Akses</button>
                                    </div>
                                <?php
                                endif;
                                ?>
					    </div> -->
                        <br>
                        <div class="" id="load-table">
                            <!-- /.table -->
                        </div>
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

<form action="<?= base_url('Arsip_dokumen/aksiEditAksesSuratKeluar') ?>" method="POST">
    <div class="modal fade" id="modal-akses">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Akses</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Akses</label>
                        <select name="akses[]" class="form-control select2" multiple style="width: 100%;">
                            <?php
                            //departemen user
                            $data_user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

                            $this->db->select('user_id');
                            $akses = $this->mymodel->selectWhere('surat_keluar_akses', []);
                            $idselect = [];
                            foreach ($akses as $key => $value) {
                                $idselect[] = $value['user_id'];
                            }

                            if ($this->session->userdata('role_slug') == 'kepala_departemen') {
                                $this->db->where('departemen', $data_user['departemen']);
                            }
                            // $this->db->where_in('jabatan_id', ['4','5','6','7','8']);
                            $muser = $this->mymodel->selectWhere('user', []);
                            foreach ($muser as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>" <?= (in_array($value['id'], $idselect)) ? 'selected' : ''; ?>><?= $value['role_name'] ?> - <?= $value['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    function set_tables() {
        $('#load-table').html('<table class="table table-hover table-responsive table-condensed table-bordered table-striped listSurat" id="myTable" style="width: 100%;">' +
            '   <thead class="bg-navy">' +
            '       <tr>' +
            '           <th>No</th>' +
            '           <th>Tanggal</th>' +
            '           <th>Signer</th>' +
            '           <th>Nomor Surat</th>' +
            '           <th>Dikirimkan Kepada</th>' +
            '           <th>Perihal</th>' +
            '           <th>PIC & NO.Telp</th>' +
            '           <th>Aksi</th>' +
            '       </tr>' +
            '   </thead>' +
            '   <tbody>' +
            '   </tbody>' +
            '</table>');
        var url = '';
        loadtable(url);
    }

    function loadtable(url = '') {

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
            ajax: {
                "url": "<?= base_url('report/json') ?>" + url,
                "type": "POST"
            },
            data: {
                param1: 'value1'
            },
            columns: [{
                    "data": "ad_id",
                    "orderable": false
                },
                {
                    "data": "ad_tanggalsurat",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_tanggalsurat'] + '</span>';
                        return html;
                    }
                },
                {
                    "data": "ad_tandatangan",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_tandatangan'] + '</span>';
                        return html;
                    }
                },
                {
                    "data": "ad_nomorsurat",
                    render: function(data, type, row) {
                        var html = '<a href="#"><span style="font-size:14px">' + row['ad_nomorsurat'] + '</span></a>';
                        return html;
                    }
                },
                {
                    "data": "ad_dikirim",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_dikirim'] + '</span>';
                        return html;
                    }
                },
                {
                    "data": "ad_perihal",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_perihal'] + '</span>';
                        return html;
                    }
                },
                {
                    "data": "ad_notelp",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_pic'] + '/' + row['ad_notelp'] + '</span>';
                        return html;
                    }
                },
                {
                    "data": "view",
                    "orderable": false
                },
            ],
            order: [
                [1, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html('<span style="font-size:14px">' + index + '</span>');

                var nomor = data['ad_nomorsurat'];
                var array_nomor = nomor.split('/')
                if (data['ad_is_booking'] == '1') nomor = array_nomor[0]

                if (data['ad_pic'] == '' || data['ad_is_booking'] == '1') {
                    $('td:eq(3)', row).html('<a href="<?= base_url() ?>arsip_dokumen/addSuratKeluar/' + data['ad_id'] + '">' + nomor + '</a>');
                } else {
                    $.ajax({
                        url: "<?= base_url() ?>arsip_dokumen/getSonEncode/" + data['ad_id'],
                        success: function(view) {
                            $('td:eq(3)', row).html('<a href="<?= base_url() ?>arsip_dokumen/detail/' + view + '">' + nomor + '</a>');
                        }
                    });
                }

            }
        });
    }
    set_tables();

    function deleteSurat(id) {
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
                $.post('<?= base_url("Arsip_dokumen/aksiHapus") ?>', {
                    ad_id: id
                }, function(result) {
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