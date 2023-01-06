<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #F5F7FF;">
    <section class="content-header">
        <h1>
            Detail Notulen Radisi
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Monitoring</a></li>
            <li><a href="<?= base_url('Notulen_radisi'); ?>">Notulen Radisi</a></li>
            <li class="active">Detail Notulen Radisi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Notulen Radisi</h3>               
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed table-striped" width="100%" border="1">
                                <tbody>
                                    <tr>
                                        <td>Tanggal Rapat Direksi</td>
                                        <td><?= date('Y-m-d', strtotime($data['nr_absensi_rapat_tanggal'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Agenda Rapat</td>
                                        <td>
                                            <?php
                                            $agenda = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $data['nr_absensi_rapat_id']]);
                                            foreach ($agenda as $key => $value) {
                                                $noAgenda = $key + 1;
                                                $pemateri = str_replace('["', '', str_replace('"]', '', str_replace('","', ', ', $value['ara_nama_divisi_materi'])));
                                                $pendamping = str_replace('["', '', str_replace('"]', '', str_replace('","', ', ', $value['ara_nama_divisi_pendamping'])));

                                                echo $noAgenda.". ".$value['ara_nama']." <br>( Pemateri : ".$pemateri." )<br>( Pendamping : ".$pendamping." )<br><br>";
                                                ?>
                                                
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PIC</td>
                                        <td><?= $data['nr_pic'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Catatan</td>
                                        <td><?= $data['nr_catatan'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Scan</h3>               
                    </div>
                    <div class="box-body">
                        <div class="text-center">
                            <img src="<?= base_url('webfile/qr_notula_radisi/qrcodenotulen-' . $data['nr_id'] . '.jpg') ?>" style="width: 100px;">
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="<?= base_url('Notulen_radisi/download_qrnotulen/'.$data['nr_id']); ?>" target="_blank"><button type="button" class="btn btn-md btn-success">Download QR Code</button></a>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Timeline Notulen Tanggal <?= date('d/m/Y', strtotime($data['nr_tanggal_awal_sirkuler'])); ?></h3>               
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed table-striped" width="100%" border="1" id="timeline">
                                <thead>
                                    <tr>
                                        <th>Waktu CheckIn</th>
                                        <th>Waktu CheckOut</th>
                                        <th>Jabatan</th>
                                        <th>Catatan</th>
                                        <th>SLA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">TTD Direksi Notulen</h3>               
                    </div>
                    <div class="box-body">
                        <div id="chart-ttd-notulen"></div>
                        <?php
                        $this->db->select('COUNT(mpj_id) as jumlah_direksi');
                        $direksi = $this->mymodel->selectDataOne('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);
                        $jumlah_direksi = $direksi['jumlah_direksi'];

                        $this->db->select('COUNT(tnr_id) as jumlah_ttd');
                        $ttd = $this->mymodel->selectDataOne('timeline_notula_radisi', ['tnr_nr_id' => $data['nr_id'], 'tnr_waktu_keluar !=' => null]);
                        $jumlahSudahTtd = $ttd['jumlah_ttd'];

                        $jumlahBelumTtd = $jumlah_direksi - $jumlahSudahTtd;
                        ?>
                        <script type="text/javascript">
                            // Build the chart
                            Highcharts.chart('chart-ttd-notulen', {
                                colors: ["#0045e6", "#e64500"],
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                                },
                                title: {
                                    text: ''
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: false
                                        },
                                        showInLegend: true
                                    }
                                },
                                legend: {
                                    labelFormatter: function() {
                                        return this.name + ' (' + this.y + ')';
                                    }
                                },
                                series: [{
                                    name: 'Jumlah',
                                    colorByPoint: true,
                                    data: [{
                                        name: 'Sudah TTD',
                                        y: <?= $jumlahSudahTtd; ?>
                                    }, {
                                        name: 'Belum TTD',
                                        y: <?= $jumlahBelumTtd; ?>
                                    }]
                                }]
                            });
                        </script>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>               
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed table-striped" width="100%" border="1">
                                <thead>
                                    <th>No</th>
                                    <th>Jabatan Direksi</th>
                                    <th>Sudah / Belum</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($absenjabatan as $key => $value) {
                                        $ttdJabatan = $this->mymodel->selectDataOne('timeline_notula_radisi', ['tnr_nr_id' => $data['nr_id'], 'tnr_waktu_keluar !=' => null, 'tnr_posisi_jabatan_id' => $value['mpj_id']]);

                                        if($ttdJabatan) {
                                            $statusTtd = 'Sudah (<i class="fa fa-check"></i>)';
                                        } else {
                                            $statusTtd = 'Belum (<i class="fa fa-times"></i>)';
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $value['mpj_nama']; ?></td>
                                            <td><?= $statusTtd; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
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

<script>
    loadTableTimeline();
    function loadTableTimeline() {
        $('#timeline').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('Notulen_radisi/jsonTimeline') ?>?notulaRadisi=" + <?= $data['nr_id']; ?>,
                "type": "GET",
            },
            "deferRender": true,
            "columns": [
                {
                    "data": "tnr_waktu_masuk"
                },
                {
                    "data": "tnr_waktu_keluar"
                },
                {
                    "data": "tnr_posisi_jabatan"
                },
                {
                    "data": "tnr_catatan"
                },
                {
                    "data": "tnr_catatan"
                },
            ],
            "columnDefs" : [
                {
                    targets : [4],
                    render : function (data, type, row, meta) {
                        let value = '-';

                        if(row['tnr_waktu_keluar'] != null) {
                            value = jarakWaktu(row['tnr_waktu_keluar'], row['tnr_waktu_masuk']);
                        }

                        return value;
                    }
                },
                // {
                //     targets : [4],
                //     render : function (data, type, row, meta) {
                //         let value = '';

                //         if(row['pegang_tanggal_lahir']) {
                //             value = formatDate(row['pegang_tanggal_lahir']);
                //         }

                //         return value;
                //     }
                // },
            ],
            "bDestroy": true,
        });
    }

    function jarakWaktu(tglAkhir, tglAwal) {
        let dalamMs = Math.abs(new Date(tglAkhir) - new Date(tglAwal)) / 1000;

        // hari
        const hari = Math.floor(dalamMs / 86400);
        dalamMs -= hari * 86400;

        // jam
        const jam = Math.floor(dalamMs / 3600) % 24;
        dalamMs -= jam * 3600;

        // menit
        const menit = Math.floor(dalamMs / 60) % 60;
        dalamMs -= menit * 60;

        let jarak = '';

        if (hari > 0) {
            jarak += (hari === 1) ? `${hari} hari ` : `${hari} hari `;
        }

        if(jam > 0) {
            jarak += (jam === 0 || jam === 1) ? `${jam} jam ` : `${jam} jam `;
        }

        if(menit > 0) {
            jarak += (menit === 0 || jam === 1) ? `${menit} menit ` : `${menit} menit `; 
        }

        jarak += `${dalamMs} detik`; 

        return jarak;
    }
</script>