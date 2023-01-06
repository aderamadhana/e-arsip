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
                            <div class="col-md-2">
                                <label>Bentuk Surat</label>
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
                                    <?php
                                    $data_departement = $this->mymodel->selectWhere('m_departemen', ['status' => 'ENABLE']);
                                    foreach ($data_departement as $departement) :
                                    ?>
                                        <option value="<?= $departement[id] ?>"><?= $departement['nama'] ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label><i>Due Date</i></label>
                                <input type="text" class="form-control tgl" name="duedate" value="<?= @$_GET['duedate'] ?>" id="filter-duedate">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-primary" style="margin-top: 27px;" onclick="set_tables()">
                                    <i class="fa fa-search"> </i> Filter
                                </button>
                            </div>
                            <?php
                            if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_departemen', 'sekretaris_divisi'])) :
                            ?>
                                <div class="col-md-1">
                                    <button class="btn btn-warning" style="margin-top: 27px;" onclick="showAkses()"><i class="fa fa-users"></i> Akses</button>
                                </div>
                            <?php
                            endif;
                            ?>
                            <?php
                            if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_departemen', 'team_leader', 'sekretaris_divisi']) or ($this->session->userdata('role_slug') == 'officer' and $this->session->userdata('jabatan') == 'Sekretaris')) :
                            ?>
                                <div class="col-md-1">
                                    <button class="btn btn-success pull-right" style="margin-top: 27px;" onclick="exportExcel()">
                                        <i class="fa fa-file-excel-o"> </i> Excel
                                    </button>
                                </div>
                                <div class="col-md-9"></div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('arsip_dokumen/addSuratKeluar') ?>" class="btn btn-danger btn-block" style="margin-top:10px;"><i class="fa fa-sign-out"></i> Tambah Surat Keluar</a>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>
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
    let role_slug = '<?= $this->session->userdata('role_slug') ?>'
    let user_id = '<?= $this->session->userdata('id') ?>'

    function exportExcel() {
        var sifat = $('#filter-sifat').val();
        var bentuk = $('#filter-bentuk').val();
        var kategori = $('#filter-kategori').val();
        var duedate = $('#filter-duedate').val();
        var url = '<?= base_url('arsip_dokumen/excelSuratKeluar') ?>'
        url += '?status=<?= @$_GET['status'] ?>&tipe=<?= @$_GET['tipe'] ?>' + '&   sifat=' + sifat + '&bentuk=' + bentuk + '&kategori=' + kategori + '&duedate=' + duedate;
        location.href = url
    }

    function set_tables() {
        $('#load-table').html('<table class="table table-hover table-responsive table-condensed table-bordered table-striped listSurat" id="myTable" style="width: 100%;font-size:12px;">' +
            '	<thead class="bg-navy">' +
            '		<tr>' +
            '			<th>No</th>' +
            '			<th>Nomor surat</th>' +
            '			<th>Tanggal surat</th>' +
            '			<th>Instansi Penerima</th>' +
            '			<th>Perihal Surat</th>' +
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

        var url = '?sifat=' + sifat + '&bentuk=' + bentuk + '&kategori=' + kategori + '&duedate=' + duedate;
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
                "url": "<?= base_url('arsip_dokumen/getDataArsipKeluar') ?>" + url,
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
                    "data": "ad_nomorsurat",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['ad_nomorsurat'] + '</span>';
                        return html;
                    }
                    // render : function (data, type, row) {
                    //     if (row['ad_sifatsurat'] == 'biasa') {
                    //         var html = '<span class="badge bg-green" ">'+row['ad_nomorsurat']+'</span>';
                    //     }else if(row['ad_sifatsurat']=='rahasia'){
                    //         var html = '<span class="badge bg-yellow" ">'+row['ad_nomorsurat']+'</span>';
                    //     }
                    //     else{
                    //         var html = '<span class="badge bg-red">'+row['ad_nomorsurat']+'</span>';
                    //     }
                    //     return html;
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
                {
                    "data": "ad_id",
                    render: function(data, type, row) {
                        if (row['status'] == 'draft') {
                            var html = '<div style="width:100%;" class="btn btn-primary btn-xs" onclick="editArsip(' + row['ad_id'] + ',\'' + row['ad_tipesurat'] + '\')"><i class="fa fa-eye"></i> <span style="font-size:14px">Edit</span></div>';
                            if (role_slug == 'super_admin' || role_slug == 'sekretaris_divisi' || user_id == row['created_by']) {
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
        window.location.href = "<?= base_url('arsip_dokumen/toDetailArsip/') ?>" + idArsip;
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

    function showAkses() {
        $("#modal-akses").modal()
    }
</script>