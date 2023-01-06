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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body ">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="">Sifat Surat</label>
                                <select class="form-control" name="sifat" id="filter-sifat">
                                    <option value="">Semua</option>
                                    <option value="biasa">Biasa</option>
                                    <option value="rahasia">Rahasia</option>
                                    <option value="sangat_rahasia">Sangat Rahasia</option>
                                </select>
                            </div>
                            <div class="col-md-2 <?= ($this->session->userdata('role_slug') == 'kepala_divisi') ? 'hide' : '' ?>">
                                <label>Bentuk Surat</label>
                                <select class="form-control" name="bentuk" id="filter-bentuk">
                                    <option value="">Semua</option>
                                    <option value="surat">Surat</option>
                                    <option value="surat_dan_proposal">Surat dan Proposal</option>
                                    <option value="surat_dan_dokumen_pendukung_lainnya">Surat dan Pendukung Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-3 <?= ($this->session->userdata('role_slug') == 'kepala_divisi') ? '' : 'hide' ?>">
                                <label>Kategori Surat</label>
                                <select class="form-control" name="kategori" id="filter-kategori">
                                    <option value="">Semua</option>
                                    <?php
                                    $list_departement = $this->mymodel->selectWhere('m_departemen', ['status' => 'ENABLE']);
                                    foreach ($list_departement as $departement) :
                                    ?>
                                        <option value="<?= $departement['id'] ?>"><?= $departement['nama'] ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <!-- <div class="col-md-2 <?= ($this->session->userdata('role_slug') == 'kepala_divisi') ? 'hide' : '' ?>">
						         	<label><i>Due Date</i></label>
					            	<input type="text" class="form-control tgl" name="duedate" value="<?= @$_GET['duedate'] ?>" id="filter-duedate">
						        </div> -->
                            <div class="col-md-2">
                                <label><i>Tanggal Surat</i></label>
                                <input type="text" class="form-control tgl" name="tanggal_surat" value="<?= @$_GET['tanggal_surat'] ?>" id="filter-tanggalsurat">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-primary" style="margin-top: 27px;" onclick="set_tables()">
                                    <i class="fa fa-search"> </i> Filter
                                </button>
                            </div>
                            <?php
                            if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_departemen', 'team_leader', 'sekretaris_divisi']) or ($this->session->userdata('role_slug') == 'officer' and $this->session->userdata('jabatan') == 'Sekretaris')) :
                            ?>
                                <div class="col-md-5">
                                    <?php if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi' || ($this->session->userdata('role_slug') == 'officer' and ($this->session->userdata('jabatan') == 'Sekretaris' or $this->session->userdata('jabatan') == 'Sekretaris Divisi'))) : ?>
                                        <a href="<?= base_url('arsip_dokumen/add') ?>" class="btn btn-success pull-right" style="margin-top: 27px;margin-left:5px"><i class="fa fa-sign-in"></i> Tambah Surat Masuk</a>
                                        <!-- <a href="<?= base_url('arsip_dokumen/addSuratKeluar') ?>" class="btn btn-danger btn-block margin-bottom"><i class="fa fa-sign-out"></i> Tambah Surat Keluar</a> -->
                                    <?php endif ?>
                                    <button class="btn btn-success pull-right" style="margin-top: 27px;" onclick="exportExcel()">
                                        <i class="fa fa-file-excel-o"> </i> Download Excel
                                    </button>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <div class="" id="load-table">
                            </div>

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
<script type="text/javascript">
    let role_slug = '<?= $this->session->userdata('role_slug') ?>'
    let user_id = '<?= $this->session->userdata('id') ?>'

    function exportExcel() {
        var sifat = $('#filter-sifat').val();
        var bentuk = $('#filter-bentuk').val();
        var kategori = $('#filter-kategori').val();
        var duedate = $('#filter-duedate').val();
        var tanggal_surat = $("#filter-tanggalsurat").val();
        var url = '<?= base_url('arsip_dokumen/excelSuratMasuk') ?>'
        url += '?status=<?= @$_GET['status'] ?>&tipe=<?= @$_GET['tipe'] ?>' + '&sifat=' + sifat + '&bentuk=' + bentuk + '&kategori=' + kategori + '&duedate=' + duedate + '&tanggal_surat=' + tanggal_surat;
        location.href = url
    }

    function set_tables() {
        $('#load-table').html('<table class="table table-hover table-responsive table-condensed table-bordered table-striped listSurat" id="myTable" style="width: 100%;font-size:12px">' +
            '	<thead class="bg-navy">' +
            '		<tr>' +
            '			<th>No</th>' +
            '			<th>Nomor surat</th>' +
            '			<th>Tanggal surat</th>' +
            '			<th>Instansi Pengirim</th>' +
            '			<th>Perihal</th>' +
            <?php if (@$_GET['tipe'] == 'inbox') { ?> '			<th>Dari</th>' +
            <?php } ?> '			<th>Status</th>' +
            '			<td style="width:1px;">#</td>' +
            '		</tr>' +
            '	</thead>' +
            '	<tbody>' +
            '	</tbody>' +
            '</table>');

        var sifat = $('#filter-sifat').val();
        var bentuk = $('#filter-bentuk').val();
        var kategori = $('#filter-kategori').val();
        var duedate = $('#filter-duedate').val();
        var tanggal_surat = $("#filter-tanggalsurat").val();

        var url = '?status=<?= @$_GET['status'] ?>&tipe=<?= @$_GET['tipe'] ?>' + '&sifat=' + sifat + '&bentuk=' + bentuk + '&kategori=' + kategori + '&duedate=' + duedate + '&tanggal_surat=' + tanggal_surat;
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
            // stateSave: true,
            "bDestroy": true,
            ajax: {
                "url": "<?= base_url('arsip_dokumen/getDataArsip') ?>" + url,
                "type": "POST"
            },
            data: {
                param1: 'value1'
            },
            columns: [{
                    "data": "ad_id",
                    "orderable": false,
                },
                {
                    "data": "ad_nomorsurat",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_nomorsurat'] + '</span>';
                        return html;
                    }
                    // render : function (data, type, row) {
                    // 	if (row['ad_sifatsurat'] == 'biasa') {
                    // 		var html = '<span class="badge bg-green" ">'+row['ad_nomorsurat']+'</span>';
                    // 	}else if(row['ad_sifatsurat']=='rahasia'){
                    //         var html = '<span class="badge bg-yellow" ">'+row['ad_nomorsurat']+'</span>';
                    //     }
                    // 	else{
                    // 		var html = '<span class="badge bg-red">'+row['ad_nomorsurat']+'</span>';
                    // 	}
                    // 	return html;
                    // }
                },
                {
                    "data": "ad_tanggalsurat",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_tanggalsurat'] + '</span>';
                        return html;
                    }

                },
                {
                    "data": "ad_instansipengirim",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_instansipengirim'] + '</span>';
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
                <?php if (@$_GET['tipe'] == 'inbox') { ?> {
                        "data": "nama_pengirim"
                    },
                <?php } ?> {
                    "data": "status",
                    render: function(data, type, row) {
                        let html = ''
                        let status = ''
                        let label_color = ''
                        let id_user = '<?= $this->session->userdata('id') ?>'
                        let tipe = '<?= @$_GET['tipe'] ?>'
                        let list_pengirim = row['list_pengirim']
                        let array_list_pengirim = list_pengirim.split(',')
                        let role_slug = '<?= $this->session->userdata('role_slug') ?>'
                        let role_pengirim = row['role_pengirim']
                        if (row['status'] == 'diajukan') {
                            if (role_pengirim == 'sekretaris_divisi' && (role_slug == 'super_admin' || role_slug == 'sekretaris_divisi')) {
                                status = 'Telah Disposisi'
                                label_color = 'yellow'
                            } else {
                                status = 'Menunggu Disposisi'
                                label_color = 'red'
                            }
                            // if((row['status']=='diajukan' && role_pengirim  ) || (row['status']=='didisposisikan' && !array_list_pengirim.includes(id_user) && role_slug!='super_admin' )  ){
                            //     status = 'Menunggu Disposisi'
                            //     label_color = 'red'
                        } else if (row['status'] == 'didisposisikan') {
                            if (!array_list_pengirim.includes(id_user) && role_slug != 'super_admin') {
                                status = 'Menunggu Disposisi'
                                label_color = 'red'
                            } else if ((array_list_pengirim.includes(id_user) || role_slug == 'super_admin') && row['adld_is_tindaklanjut'] != '1') {
                                status = 'Telah Disposisi'
                                label_color = 'yellow'
                            } else if (row['adld_is_tindaklanjut'] == '1') {
                                status = 'Telah Ditindaklanjuti'
                                label_color = 'green'
                            }
                            // }else if (row['status']=='didisposisikan' &&  (array_list_pengirim.includes(id_user) || role_slug=='super_admin' )  ){
                            //     status = 'Telah Disposisi'
                            //     label_color = 'yellow'
                        } else if (row['status'] == 'ditindaklanjuti') {
                            status = 'Telah Ditindaklanjuti'
                            label_color = 'green'
                        } else {
                            status = row['status']
                            label_color = 'red'
                        }
                        if (label_color == 'yellow') {
                            html = '<span class="badge bg-yellow" style="font-size:14px">' + status + '</span>'
                        } else {
                            html = '<span class="badge" style="background-color:' + label_color + ';font-size:14px">' + status + '</span>'
                        }

                        return html;
                    }
                },
                {
                    "data": "ad_id",
                    render: function(data, type, row) {
                        if (row['status'] == 'draft') {
                            var html = '<div style="width:100%;" class="btn btn-primary btn-xs" onclick="editArsip(' + row['ad_id'] + ',\'' + row['ad_tipesurat'] + '\')"><i class="fa fa-eye"></i> <span style="font-size:14px">Edit</span></div>';
                            if (role_slug == 'super_admin' || user_id == row['created_by']) {
                                html += '<div style="width:100%;" onclick="deleteArsip(' + row['ad_id'] + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span style="font-size:14px">Delete</span></div>';
                            }

                        } else {
                            var html = '<div style="width:100%;" class="btn btn-primary btn-xs" onclick="detailArsip(' + row['ad_id'] + ')"><i class="fa fa-eye"></i> <span style="font-size:14px">Detail</span></div>';
                        }
                        <?php if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'sekretaris_divisi') { ?>
                            if (row['status'] != 'void') {
                                // html += ' <div class="btn btn-danger btn-xs" onclick="voidArsip('+row['ad_id']+')"><i class="fa fa-trash"></i> Void</div>';
                            }
                        <?php } ?>
                        return html;
                    }
                }
            ],
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html('<span style="font-size:14px">' + index + '</span>');
                <?php if (@$_GET['tipe'] == 'inbox') { ?>
                    if (data['adld_isread'] == 0) {
                        $('td', row).css('background-color', '#fff7b1');
                    }
                <?php } ?>
            }
        });
    }
    set_tables();

    function detailArsip(idArsip) {
        // alert(idArsip);
        window.open("<?= base_url('arsip_dokumen/toDetailArsip/') ?>" + idArsip, '_blank');
        // window.location.href = "<?= base_url('arsip_dokumen/toDetailArsip/') ?>"+idArsip;
    }

    function editArsip(idArsip, tipesurat) {
        // alert(idArsip);
        if (tipesurat == 'Surat Masuk') {
            window.location.href = "<?= base_url('arsip_dokumen/add/') ?>" + idArsip;
        } else {
            window.location.href = "<?= base_url('arsip_dokumen/addSuratKeluar/') ?>" + idArsip;
        }
    }

    function voidArsip(idArsip) {
        // alert(idArsip);
        if (confirm('Apakah anda yakin ingin void arsip ini ?')) {
            window.location.href = "<?= base_url('arsip_dokumen/aksiVoid/') ?>" + idArsip;
        } else {
            return false;
        }
    }

    function deleteArsip(idArsip) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url("Arsip_dokumen/aksiHapus") ?>', {
                    ad_id: idArsip
                }, function(result) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    location.reload()
                })
            }
        })
    }
</script>