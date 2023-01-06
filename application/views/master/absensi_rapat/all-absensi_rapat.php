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
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <input type="hidden" id="tipe_rapat" value="<?= $tipe_rapat; ?>" />
                                    <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
                                        <a href="<?= base_url('master/Absensi_rapat/create-agenda?tipe_rapat=' . $tipe_rapat); ?>" class="btn btn-success margin-bottom"><i class="fa fa-plus"></i> Tambah Agenda Rapat</a>
                                    <?php endif ?>
                                    <a href="<?= base_url('master/Absensi_rapat/ekspor-agenda?tipe_rapat=' . $tipe_rapat); ?>" class="btn btn-info margin-bottom"><i class="fa fa-file-excel-o"></i> Ekspor Agenda Rapat</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="load-table"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function loadtable() {
        var tipe_rapat = $("#tipe_rapat").val();

        if (tipe_rapat == 'rapat_gabungan') {
            var checked_arr = [2];
        } else {
            var checked_arr = false;
        }

        var table = '<table class="table table-condensed table-striped datatables" id="mytable">' +
            '     <thead>' +
            '     <tr>' +
            '       <th style="width:20px">No</th>' +
            '       <th style="width:100px">Tanggal</th>' +
            '       <th>Komite</th>' +
            '       <th>Agenda Rapat</th>' +
            '       <th>Divisi Pemateri</th>' +
            '       <th style="width:200px;">Aksi</th>' +
            '     </tr>' +
            '     </thead>' +
            '     <tbody>' +
            '     </tbody>' +
            ' </table>';

        if (tipe_rapat == 'rapat_direksi') {
            table = '<table class="table table-condensed table-striped datatables" id="mytable">' +
                '     <thead>' +
                '     <tr>' +
                '       <th style="width:20px">No</th>' +
                '       <th style="width:100px">Tanggal</th>' +
                '       <th>Agenda Rapat</th>' +
                '       <th>Divisi Pemateri</th>' +
                '       <th style="width:200px;">Aksi</th>' +
                '     </tr>' +
                '     </thead>' +
                '     <tbody>' +
                '     </tbody>' +
                ' </table>';
        }

        // body...
        $("#load-table").html(table);

        if (tipe_rapat == 'rapat_direksi') {
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
                    "url": "<?= base_url('master/Absensi_rapat/json_absensi') ?>",
                    "type": "POST",
                    "data": {
                        "tipe_rapat": tipe_rapat
                    }
                },
                columns: [{
                        "data": "ar_id",
                        "orderable": false,
                        "className": "text-center"
                    },
                    {
                        "data": "ar_tanggal",
                        "className": "text-center",
                        render: function(data, type, row) {
                            var html = '<span style="font-size:14px">' + row['ar_tanggal'] + '</span>';
                            return html;
                        }
                    },
                    {
                        "data": "agenda_rapat"
                    },
                    {
                        "data": "divisi_pemateri"
                    },
                    {
                        "data": "view",
                        "orderable": false,
                        "className": "text-center"
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: [2],
                    render: function(data, type, row, meta) {
                        var htmls = "";
                        var data_agenda = row['agenda_rapat'];
                        if (data_agenda.indexOf("success") != -1) {
                            htmls = "<span style='font-size:14px'>1. " + row['agenda_rapat'] + "</span>";
                        } else {
                            var split_agenda = data_agenda.split(';');
                            htmls = "<ol>"
                            for (var y = 0; y < split_agenda.length; y++) {
                                htmls += "<li><span style='font-size:14px'>" + split_agenda[y] + "</span></li>";
                            }
                            htmls += "</ol>";
                        }
                        return htmls;
                    },
                }, {
                    targets: [3],
                    render: function(data, type, row, meta) {
                        var htmls = "";
                        if (row['divisi_pemateri'] != null) {
                            var divisi_pemateri = row['divisi_pemateri'];
                            if (divisi_pemateri.indexOf("success") != -1) {
                                htmls = "<span style='font-size:14px'>1. " + row['divisi_pemateri'] + "</span>";
                            } else {
                                var split_divisi_pemateri = divisi_pemateri.split(';');
                                htmls = "<ol>"
                                for (var y = 0; y < split_divisi_pemateri.length; y++) {
                                    var split_item_divisi_pemateri = split_divisi_pemateri[y].replace("[", "").replace("]", "").split('"').join('');
                                    htmls += "<li><span style='font-size:14px'>" + split_item_divisi_pemateri + "</span></li>";
                                }
                                htmls += "</ol>";
                            }
                        }

                        return htmls;
                    }
                }],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html('<span style="font-size:14px">' + index + '</span>');
                }
            });
        } else {
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
                    "url": "<?= base_url('master/Absensi_rapat/json_absensi') ?>",
                    "type": "POST",
                    "data": {
                        "tipe_rapat": tipe_rapat
                    }
                },
                columns: [{
                        "data": "ar_id",
                        "orderable": false,
                        "className": "text-center"
                    },
                    {
                        "data": "ar_tanggal",
                        "className": "text-center",
                        render: function(data, type, row) {
                            var html = '<span style="font-size:14px">' + row['ar_tanggal'] + '</span>';
                            return html;
                        }
                    },
                    {
                        "data": "ar_mk_nama",
                        "className": "text-center",
                        render: function(data, type, row) {
                            var html = '<span style="font-size:14px">' + row['ar_mk_nama'] + '</span>';
                            return html;
                        }
                    },
                    {
                        "data": "agenda_rapat"
                    },
                    {
                        "data": "divisi_pemateri"
                    },
                    {
                        "data": "view",
                        "orderable": false,
                        "className": "text-center"
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: [3],
                    render: function(data, type, row, meta) {
                        var htmls = "";
                        var data_agenda = row['agenda_rapat'];
                        if (data_agenda.indexOf("success") != -1) {
                            htmls = "<span style='font-size:14px'>1. " + row['agenda_rapat'] + "</span>";
                        } else {
                            var split_agenda = data_agenda.split(';');
                            htmls = "<ol>"
                            for (var y = 0; y < split_agenda.length; y++) {
                                htmls += "<li><span style='font-size:14px'>" + split_agenda[y] + "</span></li>";
                            }
                            htmls += "</ol>";
                        }
                        return htmls;
                    }
                }, {
                    targets: [4],
                    render: function(data, type, row, meta) {
                        var htmls = "";
                        if (row['divisi_pemateri'] != null) {
                            var divisi_pemateri = row['divisi_pemateri'];
                            if (divisi_pemateri.indexOf("success") != -1) {
                                htmls = "<span style='font-size:14px'>1. " + row['divisi_pemateri'] + "</span>";
                            } else {
                                var split_divisi_pemateri = divisi_pemateri.split(';');
                                htmls = "<ol>"
                                for (var y = 0; y < split_divisi_pemateri.length; y++) {
                                    var split_item_divisi_pemateri = split_divisi_pemateri[y].replace("[", "").replace("]", "").split('"').join('');
                                    htmls += "<li><span style='font-size:14px'>" + split_item_divisi_pemateri + "</span></li>";
                                }
                                htmls += "</ol>";
                            }
                        }

                        return htmls;
                    }
                }],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html('<span style="font-size:14px">' + index + '</span>');
                }
            });
        }



        if (checked_arr) {
            t.columns(checked_arr).visible(false);
        }


    };
    loadtable();

    function detail(ar_id) {
        var tipe_rapat = $("#tipe_rapat").val();
        window.open("<?= base_url('master/Absensi-rapat/detail-agenda/') ?>" + ar_id + "?tipe_rapat=" + tipe_rapat, '_blank');
    }

    function edit(ar_id) {
        var tipe_rapat = $("#tipe_rapat").val();
        window.open("<?= base_url('master/Absensi-rapat/edit-agenda/') ?>" + ar_id + "?tipe_rapat=" + tipe_rapat, '_blank');
    }

    function hapus(id, e) {
        idrow = e.parent().parent().parent();
        idbutton = e.parent().parent();
        Swal.fire({
            title: 'Perhatian ?',
            text: "Anda yakin ingin menghapus data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data.'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('master/Absensi_rapat/delete_agenda') ?>',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        id: id
                    },
                    beforeSend: function() {},
                    success: function(response, textStatus, xhr) {
                        var str = response;
                        if (str.indexOf("success") != -1) {
                            idbutton.html('<label class="badge bg-red">Deleted</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable();"><i class="fa fa-refresh"></i> </label>');
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
</script>