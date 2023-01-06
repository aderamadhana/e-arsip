<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $page_name ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4><b>Kuorum Kehadiran</b></h4>
                    </div>
                    <div class="box-body">
                        <div id="chart-bentuk"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="hr-dashed">
                <h4>Agenda Rapat</h4>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Agenda Rapat</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Divisi Pemateri</th>
                                <th>Divisi Pendamping</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 1; ?>
                            <?php foreach ($absensi_rapat_agenda as $key) { ?>
                                <tr>
                                    <td class="text-center"><?= $number . "."; ?></td>
                                    <td><?= $key['ara_nama']; ?></td>
                                    <td class="text-center">
                                        <?php
                                        $jam_mulai = strtotime($key['ara_mulai']);
                                        echo date('H:i', $jam_mulai);
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $jam_selesai = strtotime($key['ara_selesai']);
                                        echo date('H:i', $jam_selesai);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo "<ol>";
                                        foreach (json_decode($key['ara_nama_divisi_materi']) as $materi) {
                                            echo "<li>" . $materi . "</li>";
                                        }
                                        echo "</ol>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo "<ol>";
                                        foreach (json_decode($key['ara_nama_divisi_pendamping']) as $pendamping) {
                                            echo "<li>" . $pendamping . "</li>";
                                        }
                                        echo "</ol>";
                                        ?>
                                    </td>
                                </tr>
                                <?php $number++; ?>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
// $jumlah_kuorum = $absensi_rapat['ar_jumlah'];
$jumlah_kuorum = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);
$this->db->select('COUNT(are_id) as jumlah_hadir');
$this->db->where_in('are_status_kehadiran', ['Hadir', 'Hadir Diwakilkan']);
$this->db->where('are_ar_id', $ar_id_decode);
$query_kehadiran = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_tipe' => 'Direksi']);
$jumlah_hadir = $query_kehadiran['jumlah_hadir'];
$jumlah_tidak_hadir = count($jumlah_kuorum) - $jumlah_hadir;
?>
<script type="text/javascript">
    // Build the chart
    Highcharts.chart('chart-bentuk', {
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
                name: 'Hadir',
                y: <?= $jumlah_hadir; ?>
            }, {
                name: 'Tidak Hadir',
                y: <?= $jumlah_tidak_hadir; ?>
            }]
        }],
        exporting: {
            enabled: false
        }
    });
</script>