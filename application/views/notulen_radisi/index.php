<style>
    .datatables {
        font-size: 14px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NOTULEN RAPAT DIREKSI
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Monitoring</a></li>
            <li class="active">Notulen Rapat Direksi</li>
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
                                    <!-- <a href="<?= base_url('Notulen_radisi/create') ?>">
                                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Notulen</button> 
                                </a> -->
                                    <!-- <a href="" target="_blank"> -->
                                    <!-- <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> Export Excel</button>  -->
                                    <!-- </a> -->
                                    <!-- <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> Import Jabatan</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="filter">

                            <div class="row" style="margin-bottom:10px">
                                <!-- <div class="col-md-2 ">
                                    <small for="">Status</small>
                                    <select onchange="loadtable(this.value)" id="select-status" style="" class="form-control input-sm">
                                        <option value="ENABLE">ENABLE</option>
                                        <option value="DISABLE">DISABLE</option>
                                    </select>
                                </div>
                                <div class="col-md-2 ">
                                    <button class="btn btn-primary" onclick="loadtable('ENABLE')" type="button" style="margin-top:25px;border-radius:0px"><i class="fa fa-filter"></i> Filter</button>
                                </div> -->
                                <div class="col-md-2 ">
                                    <small for="">Tanggal Notulen</small>
                                    <input type="text" name="tanggal_notulen" id="tanggal_notulen" class="form-control input-sm tgl" placeholder="yyyy-mm-dd">
                                    <input type="hidden" name="tanggal_notulen_search" id="tanggal_notulen_search" class="form-control input-sm tgl" placeholder="yyyy-mm-dd">
                                </div>
                                <!-- <div class="col-md-2 ">
                                    <small for="">PIC</small>
                                    <select id="select-pic" style="" class="form-control input-sm">
                                        
                                    </select>
                                </div> -->
                                <div class="col-md-4 ">
                                    <button type="button" class="btn btn-primary" style="margin-top:18px;border-radius:0px" onclick="loadtable();"><i class="fa fa-filter"></i> Filter</button>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-warning" style="margin-top:18px;border-radius:0px" onclick="exportExcel()"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                                        <?php if ($this->session->userdata('role_slug') != 'kepala_divisi') : ?>
                                            <button type="button" class="btn btn-success" style="margin-top:18px;border-radius:0px" onclick="create();"><i class="fa fa-plus"></i> Tambah Notulen</button>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" id="dataId">
                        <div class="table-responsive">
                            <div id="load-table"></div>
                        </div>
                        <!-- <button class="btn btn-danger btn-sm" type="button" onclick="hapuspilihdata()" id="btn-hapus-data"><i class="fa fa-trash"></i> Hapus Data Terpilih</button> -->
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

<div class="modal fade bd-example-modal-sm" tabindex="-1" m_departemen="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="title-form"></span>
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


<script type="text/javascript">
    var idrow = "";
    var idbutton = "";

    loadtable();

    function loadtable() {

        let tglNotulen = $('#tanggal_notulen').val();
        $('#tanggal_notulen_search').val(tglNotulen);
        let pic = $('#select-pic').val();

        var table = '<table class="table table-condensed table-striped datatables" id="mytable">' +
            '     <thead>' +
            '     <tr>' +
            '       <th style="width:20px">No</th>' +
            '       <th style="width:150px">Notulen Tanggal</th>' +
            '       <th>Agenda</th>' +
            '       <th>PIC Notulen</th>' +
            '       <th style="width:150px">Detail</th>' +
            '     </tr>' +

            '     </thead>' +
            '     <tbody>' +
            '     </tbody>' +
            ' </table>';
        // body...
        $("#load-table").html(table);
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
                "url": "<?= base_url('Notulen_radisi/json') ?>?tanggal=" + tglNotulen,
                "type": "POST"
            },
            columns: [{
                    "data": "nr_id",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nr_tanggal_awal_sirkuler"
                },
                {
                    "data": "agenda_rapat"
                },
                {
                    "data": "nr_pic",
                    render: function(data, type, row) {
                        var html = '<span style="font-size:14px">' + row['nr_pic'] + '</span>';
                        return html;
                    }
                },
                // {"data": "nr_catatan", "className": "text-center"},
                {
                    "data": "view",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            order: [
                [1, 'asc']
            ],
            columnDefs: [{
                    targets: [1],
                    render: function(data, type, row, meta) {
                        let htmls = "";
                        const myArray = row['nr_tanggal_awal_sirkuler'].split(" ");

                        htmls = '<span style="font-size:14px">' + myArray[0] + "</span>";

                        return htmls;
                    }
                },
                {
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
                    }
                },
                // { 
                //     targets : [4],
                //     render : function (data, type, row, meta) {
                //         let html = `<button type="button" class="btn btn-sm btn-info" onclick="detailContent(${row.nr_id}, 'Catatan')">Detail</button>`;

                //         return html;
                //     }
                // }
            ],

            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html('<span style="font-size:14px">' + index + '</span>');

            }
        });
    }

    function create() {
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Tambah Notulen');
        $("#load-form").load("<?= base_url('Notulen_radisi/create/') ?>");
    }

    function detailContent(id, title) {
        $("#load-form").html('loading...');
        $("#modal-form").modal();

        let judul = title;

        if (judul == "Agenda") {
            judul = "Agenda Rapat Direksi";
        }

        $("#title-form").html(`<b>${judul}</b>`);
        $("#load-form").load("<?= base_url('Notulen_radisi/detailContent/') ?>" + id + "/" + title);
    }

    function detailNotula(id) {
        window.location.href = "<?= base_url('Notulen_radisi/detailNotula'); ?>/" + id;
    }

    $('.tgl').datepicker({
        autoclose: true,
        dateFormat: 'yy-mm-dd'
    });

    function exportExcel() {
        let tglNotulen = $('#tanggal_notulen_search').val();
        window.open("<?= base_url('Notulen_radisi/exportExcel') ?>?tanggal=" + tglNotulen, "_blank");
    }
</script>