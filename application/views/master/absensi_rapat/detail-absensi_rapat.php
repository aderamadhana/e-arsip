<?php
function hari_ini($hari)
{
    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }
    return $hari_ini;
}


    $judulrapat['rapat_direksi'] = 'Rapat Direksi';
    $judulrapat['komite_komisaris'] = 'Rapat Komisaris';
    $judulrapat['komite_direksi'] = 'Rapat Komite Direksi';
    $judulrapat['rapat_gabungan'] = 'Rapat Gabungan';


?>
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
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#detail_rapat" data-toggle="tab">Detail Rapat</a></li>
                        <?php if ($tipe_rapat == "komite_komisaris") { ?>
                             <li><a href="#absensi_komisaris" data-toggle="tab">Absensi Komisaris</a></li>
                             <li><a href="#absensi_non_komisaris" data-toggle="tab">Absensi Non Komisaris</a></li>
                        <?php }elseif ($tipe_rapat == "rapat_gabungan") { ?>
                             <li><a href="#absensi_komisaris" data-toggle="tab">Absensi Komisaris</a></li>
                             <li><a href="#absensi_direksi" data-toggle="tab">Absensi Direksi</a></li>
                             <li><a href="#absensi_sevp" data-toggle="tab">Absensi SEVP</a></li>
                        <?php } else{ ?>
                             <li><a href="#absensi_direksi" data-toggle="tab">Absensi Direksi</a></li>
                             <li><a href="#absensi_sevp" data-toggle="tab">Absensi SEVP</a></li>
                        <?php } ?>
                       
                        <li><a href="#absensi_pemateri" data-toggle="tab">Absensi Pemateri</a></li>
                        <li><a href="#absensi_pendamping" data-toggle="tab">Absensi Pendamping</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="detail_rapat">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh-pdf/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                        <a href="<?= base_url('master/Absensi-rapat/unduh-ppt/' . $absensi_rapat['ar_id']); ?>" role="button" class="btn btn-danger" role="button"><i class="fa fa-file-o"></i> Download PPT</a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4>Detail Data Rapat</h4>
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <?php if ($tipe_rapat == "komite_direksi" || $tipe_rapat == "komite_komisaris") { ?>
                                            <tr>
                                                <th style="width:200px">Komite</th>
                                                <th style="width:1px">:</th>
                                                <td><?= $absensi_rapat['ar_mk_nama'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($tipe_rapat == "komite_direksi") { ?>
                                            <tr>
                                                <th style="width:200px">Sub Komite</th>
                                                <th style="width:1px">:</th>
                                                <td>
                                                    <?php
                                                    $data_sub_komite = json_decode($absensi_rapat['ar_sub_komite']);
                                                    if ($data_sub_komite) {
                                                        $number_sub = 1;
                                                        foreach ($data_sub_komite as $key_sub => $val_sub) {
                                                            echo $number_sub . ". " . $val_sub . "<br/>";
                                                            $number_sub++;
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Lokasi Rapat</th>
                                            <th style="width:1px"> : </th>
                                            <td><?= ($absensi_rapat['ar_lokasi'] == "Lainnya") ? $absensi_rapat['ar_lokasi_lainnya'] : $absensi_rapat['ar_lokasi'];  ?> </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Jumlah Kuorum Rapat</th>
                                            <th style="width:1px"> : </th>
                                            <td><?= $absensi_rapat['ar_jumlah']; ?> </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h4>QR Code</h4>
                                    <center>
                                        <div style="border: 1px solid #dddd;padding: 8px;">
                                            <img src="<?= base_url('webfile/qr_absensi_rapat/qrcode-' . $absensi_rapat['ar_id'] . '.jpg') ?>" style="width: 100px;">
                                        </div>
                                    </center>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Chart Direksi -->
                                            <div class="box">
                                                <div class="box-header">
                                                    <h4><b>Kehadiran Direksi</b></h4>
                                                </div>
                                                <div class="box-body">
                                                    <div id="chart-direksi"></div>
                                                    <br>
                                                    <table class="table table-bordered" style="width: 100%;">
                                                        <tr>
                                                            <td colspan="2">Keterangan</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Hadir</td>
                                                            <td class="text-center">Tidak Hadir</td>
                                                        </tr>
                                                        <?php
                                                        $this->db->order_by('mpj_sortingcustom', 'asc');
                                                        $data_direksi_all = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '1', 'status' => 'ENABLE']);
                                                        foreach ($data_direksi_all as $dda) {
                                                            $cek_kehadiran = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Direksi', 'are_mpj_id' => $dda['mpj_id']]);
                                                            if ($cek_kehadiran['are_id'] != NULL) {
                                                        ?>
                                                                <tr>
                                                                    <td><?= $dda['mpj_nama']; ?></td>
                                                                    <td class="text-center">-</td>
                                                                </tr>
                                                            <?php
                                                            } else { ?>
                                                                <tr>
                                                                    <td class="text-center">-</td>
                                                                    <td><?= $dda['mpj_nama']; ?></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            // $jumlah_kuorum = $absensi_rapat['ar_jumlah'];
                                            $jumlah_kuorum = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);
                                            $this->db->select('COUNT(are_id) as jumlah_hadir');
                                            $this->db->where_in('are_status_kehadiran', ['Hadir', 'Hadir Diwakilkan']);
                                            $this->db->where('are_ar_id', $absensi_rapat['ar_id']);
                                            $query_kehadiran = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_tipe' => 'Direksi']);
                                            $jumlah_hadir = $query_kehadiran['jumlah_hadir'];
                                            $jumlah_tidak_hadir = count($jumlah_kuorum) - $jumlah_hadir;
                                            ?>
                                            <script type="text/javascript">
                                                // Build the chart
                                                Highcharts.chart('chart-direksi', {
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
                                                    }]
                                                });
                                            </script>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Chart SEVP -->
                                            <div class="box">
                                                <div class="box-header">
                                                    <h4><b>Kehadiran SEVP</b></h4>
                                                </div>
                                                <div class="box-body">
                                                    <div id="chart-sevp"></div>
                                                    <br>
                                                    <table class="table table-bordered" style="width: 100%;">
                                                        <tr>
                                                            <td colspan="2">Keterangan</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Hadir</td>
                                                            <td class="text-center">Tidak Hadir</td>
                                                        </tr>
                                                        <?php
                                                        $data_sevp_all = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '2', 'status' => 'ENABLE']);
                                                        foreach ($data_sevp_all as $dsa) {
                                                            $cek_kehadiran = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'SEVP', 'are_mpj_id' => $dsa['mpj_id']]);
                                                            if ($cek_kehadiran['are_id'] != NULL) {
                                                        ?>
                                                                <tr>
                                                                    <td><?= $dsa['mpj_nama']; ?></td>
                                                                    <td class="text-center">-</td>
                                                                </tr>
                                                            <?php
                                                            } else { ?>
                                                                <tr>
                                                                    <td class="text-center">-</td>
                                                                    <td><?= $dsa['mpj_nama']; ?></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            $this->db->select('COUNT(are_id) as jumlah_hadir');
                                            $this->db->where_in('are_status_kehadiran', ['Hadir', 'Hadir Diwakilkan']);
                                            $this->db->where('are_ar_id', $absensi_rapat['ar_id']);
                                            $query_kehadiran_sevp = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_tipe' => 'SEVP']);
                                            $jumlah_hadir_sevp = $query_kehadiran_sevp['jumlah_hadir'];

                                            $sevp_all = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '2', 'status' => "ENABLE"]);
                                            $jumlah_sevp = count($sevp_all);
                                            $jumlah_tidak_hadir = $jumlah_sevp - $jumlah_hadir_sevp;
                                            ?>
                                            <script type="text/javascript">
                                                // Build the chart
                                                Highcharts.chart('chart-sevp', {
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
                                                            y: <?= $jumlah_hadir_sevp; ?>
                                                        }, {
                                                            name: 'Tidak Hadir',
                                                            y: <?= $jumlah_tidak_hadir; ?>
                                                        }]
                                                    }]
                                                });
                                            </script>
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
                                                    <?php
                                                    // if($tipe_rapat == "rapat_direksi") {
                                                        ?>
                                                        <!-- <th style="text-center">Stopwatch </th> -->
                                                        <?php
                                                    // }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 1; ?>
                                                <?php foreach ($absensi_rapat_agenda as $key => $value) { 
                                                    $agendaRapat = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_nama' => $value['ara_nama']]);
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $number . "."; ?></td>
                                                        <td><?= $value['ara_nama']; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            $jam_mulai = strtotime($value['ara_mulai']);
                                                            echo date('H:i', $jam_mulai);
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            $jam_selesai = strtotime($value['ara_selesai']);
                                                            echo date('H:i', $jam_selesai);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo "<ol>";
                                                            foreach (json_decode($value['ara_nama_divisi_materi']) as $materi) {
                                                                if($value['ara_singkatan_divisi_materi'] != null) {
                                                                    echo "<li>" . $materi . " ( " . json_decode($value['ara_singkatan_divisi_materi'])[$key]. " ) </li>";
                                                                } else {
                                                                    echo "<li>" . $materi . " </li>";
                                                                }
                                                                
                                                            }
                                                            echo "</ol>";
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo "<ol>";
                                                            foreach (json_decode($value['ara_nama_divisi_pendamping']) as $pendamping) {
                                                                if($value['ara_singkatan_divisi_materi'] != null) {
                                                                    echo "<li>" . $pendamping . " ( " . json_decode($value['ara_singkatan_divisi_pendamping'])[$key]. " ) </li>";
                                                                } else {
                                                                    echo "<li>" . $pendamping . " </li>";
                                                                }
                                                                
                                                            }
                                                            echo "</ol>";
                                                            ?>
                                                        </td>
                                                        <?php
                                                        // if($tipe_rapat == "rapat_direksi") {
                                                        //     if ($this->session->userdata('role_slug') != 'kepala_divisi') {
                                                        //         ?>
                                                                     <!-- <td style="text-center"> -->
                                                                         <?php
                                                        //                 if($agendaRapat['ara_stopwatch_mulai'] == null) {
                                                        //                     ?>
                                                                                 <!-- <button class="btn btn-md btn-success" onclick="startStopWatch(<?= $agendaRapat['ara_id']; ?>);"><i class="fa fa-clock-o"></i> Mulai</button> -->
                                                                             <?php
                                                        //                 } else {
                                                        //                     if($agendaRapat['ara_stopwatch_selesai'] != null) {
                                                        //                         $stopwatchMulai = new DateTime($agendaRapat['ara_stopwatch_mulai']);
                                                        //                         $stopwatchSelesai = new DateTime($agendaRapat['ara_stopwatch_selesai']);
                                                        //                         $jarak = $stopwatchSelesai->diff($stopwatchMulai);

                                                        //                         $hari = $jarak->d;
                                                        //                         $jam = $jarak->h;
                                                        //                         $menit = $jarak->i;
                                                        //                         $detik = $jarak->s;

                                                        //                         $waktuStopwatch = "";

                                                        //                         if($hari > 0) {
                                                        //                             $waktuStopwatch = $hari." Hari ".$jam." Jam ".$menit." Menit ".$detik." Detik";
                                                        //                         } elseif($jam > 0) {
                                                        //                             $waktuStopwatch = $jam." Jam ".$menit." Menit ".$detik." Detik";
                                                        //                         } elseif($menit > 0) {
                                                        //                             $waktuStopwatch = $menit." Menit ".$detik." Detik";
                                                        //                         } elseif($detik > 0) {
                                                        //                             $waktuStopwatch = $detik." Detik";
                                                        //                         }

                                                        //                         echo $waktuStopwatch;
                                                        //                     }
                                                        //                 }
                                                        //                 ?>
                                                                     <!-- </td> -->
                                                                 <?php
                                                        //     }
                                                        // }
                                                        ?>
                                                    </tr>
                                                    <?php $number++; ?>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi_direksi">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <h4>Absensi Kehadiran <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Waktu</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                $jam_mulai = strtotime($waktu['mulai']);
                                                $jam_selesai = strtotime($waktu['selesai']);
                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh_absensi_direksi/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th colspan="2">Tanda Tangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number = 1;

                                                // Direksi 
                                                $this->db->order_by('mpj_id', 'ASC');
                                                $direksi = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '1', 'status' => 'ENABLE']);
                                                foreach ($direksi as $dir) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <center><?= $number . "."; ?></center>
                                                        </td>
                                                        <td><?= $dir['mpj_nama']; ?></td>
                                                        <?php
                                                        // Get Tanda tangan
                                                        $absensi_direksi = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Direksi', 'are_mpj_id' => $dir['mpj_id']]);
                                                        ?>
                                                        <?php if (($number % 2) != 0) { ?>
                                                            <td style="width: 250px;">
                                                                <?= $number . "."; ?>
                                                                &nbsp;
                                                                <?php
                                                                if ($absensi_direksi) {
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="width: 250px;"></td>
                                                        <?php } else { ?>
                                                            <td style="width: 250px;"></td>
                                                            <td style="width: 250px;">
                                                                <?= $number . "."; ?>
                                                                &nbsp;
                                                                <?php
                                                                if ($absensi_direksi) {
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $number++; ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi_komisaris">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <h4>Absensi Kehadiran Rapat Komisaris</h4>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Waktu</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                $jam_mulai = strtotime($waktu['mulai']);
                                                $jam_selesai = strtotime($waktu['selesai']);
                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh_absensi_komisaris/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th colspan="2">Tanda Tangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number = 1;

                                                // Direksi 
                                                $this->db->order_by('mpj_id', 'ASC');
                                                $komisaris = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '3', 'status' => 'ENABLE']);
                                                foreach ($komisaris as $dir) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <center><?= $number . "."; ?></center>
                                                        </td>
                                                        <td><?= $dir['mpj_nama']; ?></td>
                                                        <?php
                                                        // Get Tanda tangan
                                                        $absensi_komisaris = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Komisaris', 'are_mpj_id' => $dir['mpj_id']]);
                                                        ?>
                                                        <?php if (($number % 2) != 0) { ?>
                                                            <td style="width: 250px;">
                                                                <?= $number . "."; ?>
                                                                &nbsp;
                                                                <?php
                                                                if ($absensi_komisaris) {
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="width: 250px;"></td>
                                                        <?php } else { ?>
                                                            <td style="width: 250px;"></td>
                                                            <td style="width: 250px;">
                                                                <?= $number . "."; ?>
                                                                &nbsp;
                                                                <?php
                                                                if ($absensi_komisaris) {
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_komisaris['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $number++; ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi_sevp">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <h4>Absensi Kehadiran SEVP pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Waktu</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                $jam_mulai = strtotime($waktu['mulai']);
                                                $jam_selesai = strtotime($waktu['selesai']);
                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh_absensi_sevp/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th colspan="2">Tanda Tangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number = 1;
                                                // SEVP 
                                                $this->db->order_by('mpj_id', 'ASC');
                                                $sevp = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '2', 'status' => 'ENABLE']);
                                                foreach ($sevp as $sev) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <center><?= $number . "."; ?></center>
                                                        </td>
                                                        <td><?= $sev['mpj_nama']; ?></td>
                                                        <?php
                                                        // Get Tanda tangan
                                                        $absensi_direksi = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'SEVP', 'are_mpj_id' => $sev['mpj_id']]);
                                                        ?>
                                                        <?php if (($number % 2) != 0) { ?>
                                                            <td style="width: 250px;">
                                                                <?= $number . "."; ?>
                                                                &nbsp;
                                                                <?php
                                                                if ($absensi_direksi) {
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="width: 250px;"></td>
                                                        <?php } else { ?>
                                                            <td style="width: 250px;"></td>
                                                            <td style="width: 250px;">
                                                                <?= $number . "."; ?>
                                                                &nbsp;
                                                                <?php
                                                                if ($absensi_direksi) {
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $absensi_direksi['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $number++; ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi_non_komisaris">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <h4>Absensi Kehadiran Divisi Non Komisaris pada Rapat Komisaris</h4>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Waktu</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                $jam_mulai = strtotime($waktu['mulai']);
                                                $jam_selesai = strtotime($waktu['selesai']);
                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh_absensi_non_komisaris/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Pejabat</th>
                                                    <th colspan="2">Tanda Tangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number = 1;
                                                $this->db->order_by('are_id', 'ASC');
                                                $non_komisaris = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Non Komisaris', 'are_status_kehadiran' => 'Hadir']);
                                                if ($non_komisaris) {
                                                    foreach ($non_komisaris as $div) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <center><?= $number . "."; ?></center>
                                                            </td>
                                                            <td><?= $div['are_nama_pejabat_divisi']; ?></td>
                                                            <?php if (($number % 2) != 0) { ?>
                                                                <td style="width: 250px;">
                                                                    <?= $number . "."; ?>
                                                                    &nbsp;
                                                                    <?php
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="width: 250px;"></td>
                                                            <?php } else { ?>
                                                                <td style="width: 250px;"></td>
                                                                <td style="width: 250px;">
                                                                    <?= $number . "."; ?>
                                                                    &nbsp;
                                                                    <?php
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php $number++; ?>
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="4">
                                                            <center>
                                                                <b>
                                                                    Belum ada Non Komisaris yang melakukan Absensi.
                                                                </b>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi_pemateri">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <h4>Absensi Kehadiran Divisi Pemateri pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Waktu</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                $jam_mulai = strtotime($waktu['mulai']);
                                                $jam_selesai = strtotime($waktu['selesai']);
                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh_absensi_pemateri/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Pejabat</th>
                                                    <th>Nama Divisi</th>
                                                    <th colspan="2">Tanda Tangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number = 1;
                                                $this->db->order_by('are_id', 'ASC');
                                                $divisi = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Pemateri', 'are_status_kehadiran' => 'Hadir']);
                                                if ($divisi) {
                                                    foreach ($divisi as $div) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <center><?= $number . "."; ?></center>
                                                            </td>
                                                            <td><?= $div['are_nama_pejabat_divisi']; ?></td>
                                                            <td><?= $div['are_md_nama']; ?></td>
                                                            <?php if (($number % 2) != 0) { ?>
                                                                <td style="width: 250px;">
                                                                    <?= $number . "."; ?>
                                                                    &nbsp;
                                                                    <?php
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="width: 250px;"></td>
                                                            <?php } else { ?>
                                                                <td style="width: 250px;"></td>
                                                                <td style="width: 250px;">
                                                                    <?= $number . "."; ?>
                                                                    &nbsp;
                                                                    <?php
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php $number++; ?>
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="4">
                                                            <center>
                                                                <b>
                                                                    Belum ada Divisi Pemateri yang melakukan Absensi.
                                                                </b>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi_pendamping">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <h4>Absensi Kehadiran Divisi Pendamping pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h4>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped" style="width:100%">
                                        <tr>
                                            <th style="width:200px">Hari, Tanggal</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                                                $day = date('D', $timestamp);
                                                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:200px">Waktu</th>
                                            <th style="width:1px"> : </th>
                                            <td>
                                                <?php
                                                $this->db->select('MIN(ara_mulai) as mulai, MAX(ara_selesai) as selesai');
                                                $waktu = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $absensi_rapat['ar_id']]);
                                                $jam_mulai = strtotime($waktu['mulai']);
                                                $jam_selesai = strtotime($waktu['selesai']);
                                                echo date('H:i', $jam_mulai) . " - " . date('H:i', $jam_selesai);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="pull-right">
                                        <a href="<?= base_url('master/Absensi-rapat/unduh_absensi_pendamping/' . $absensi_rapat['ar_id']); ?>" target="_blank" role="button" class="btn btn-warning" role="button"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Pejabat</th>
                                                    <th>Nama Divisi</th>
                                                    <th colspan="2">Tanda Tangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number = 1;
                                                $this->db->order_by('are_id', 'ASC');
                                                $divisi = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Pendamping', 'are_status_kehadiran' => 'Hadir']);
                                                if ($divisi) {
                                                    foreach ($divisi as $div) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <center><?= $number . "."; ?></center>
                                                            </td>
                                                            <td><?= $div['are_nama_pejabat_divisi']; ?></td>
                                                            <td><?= $div['are_md_nama']; ?></td>
                                                            <?php if (($number % 2) != 0) { ?>
                                                                <td style="width: 250px;">
                                                                    <?= $number . "."; ?>
                                                                    &nbsp;
                                                                    <?php
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="width: 250px;"></td>
                                                            <?php } else { ?>
                                                                <td style="width: 250px;"></td>
                                                                <td style="width: 250px;">
                                                                    <?= $number . "."; ?>
                                                                    &nbsp;
                                                                    <?php
                                                                    $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                                                    if (file_exists($filename)) {
                                                                        $file_path = base_url('webfile/ttd_absensi_rapat/' . $div['are_ttd']);
                                                                        echo "<img src='" . $file_path . "' style='width:200px;' />";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php $number++; ?>
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="4">
                                                            <center>
                                                                <b>
                                                                    Belum ada Divisi Pendamping yang melakukan Absensi.
                                                                </b>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <a href="<?= base_url('master/Absensi-rapat?tipe_rapat=' . $tipe_rapat); ?>" role="button" class="btn btn-warning" role="button"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal" data-backdrop="static" tabindex="-1" role="dialog" id="modalstopwatch">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" data-dismiss="modal" aria-label="Close">Waktu Agenda <span id="namaagenda"></span></h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="agendaId" value="" />
                <div class="row">
                    <div class="col-md-12 text-center">
                        <b>
                            <h2>
                                <div class="timerDisplay">
                                    00 : 00 : 00 : 00
                                </div>
                            </h2>
                        </b>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-md btn-default" onclick="batalStopwatch();">Batal</button>
                <button type="button" class="btn btn-md btn-danger" onclick="selesaiStopwatch();">Berhenti</button>
            </div>
        </div>
    </div>
</div>

<script>

    <?php
    if($tipe_rapat == "rapat_direksi") {
        foreach ($absensi_rapat_agenda as $key => $value) { 
            $agendaRapat = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_nama' => $value['ara_nama']]);

            if($agendaRapat['ara_stopwatch_mulai'] != null && $agendaRapat['ara_stopwatch_selesai'] == null) {
                ?>
                    $('#agendaId').val(<?= $agendaRapat['ara_id']; ?>);
                    continueStopwatch(<?= $agendaRapat['ara_id']; ?>);
                <?php
            }
        }
    }
    ?>

    let [milliseconds,seconds,minutes,hours] = [0,0,0,0];
    let timerRef = document.querySelector('.timerDisplay');
    let int = null;

    function startStopWatch(id) {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah anda ingin memulai agenda rapat ini ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Ya",
            cancelButtonColor: '#d33',
            cancelButtonText: "Tidak",
            closeOnConfirm: true,
            closeOnCancel: true
        }).then((result) => {
            if(result.isConfirmed) {
                $('#modalstopwatch').show();
                $('#agendaId').val(id);

                getDataAgenda(id);
            }
        });
    }

    function getDataAgenda(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('master/Absensi_rapat/get_data_agenda'); ?>/" + id,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(response, textStatus, xhr) {
                let str = JSON.parse(response);
                if (str.status_code === 200){

                    int = setInterval(displayTimer, 10);

                    document.querySelector('#namaagenda').innerHTML = str.agenda;
                } else {
                    Swal.fire({
                        title: "Oppss!",
                        html: "Terjadi kesalahan",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                Swal.fire({
                    title: "Oppss!",
                    text: "Terjadi kesalahan",
                    icon: "error"
                });
            }
        });
    }

    function displayTimer(){
        milliseconds+=1;
        if(milliseconds == 100){
            milliseconds = 0;
            seconds++;
            if(seconds == 60){
                seconds = 0;
                minutes++;
                if(minutes == 60){
                    minutes = 0;
                    hours++;
                }
            }
        }

        let h = hours < 10 ? "0" + hours : hours;
        let m = minutes < 10 ? "0" + minutes : minutes;
        let s = seconds < 10 ? "0" + seconds : seconds;
        let ms = milliseconds < 10 ? "0" + milliseconds : milliseconds;

        timerRef.innerHTML = ` ${h} : ${m} : ${s} : ${ms}`;
    }

    function batalStopwatch() {
        let id = $('#agendaId').val();
         $.ajax({
            type: "POST",
            url: "<?= base_url('master/Absensi_rapat/batal_stopwatch_agenda'); ?>/" + id,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(response, textStatus, xhr) {
                let str = JSON.parse(response);
                if (str.status_code === 200){
                    clearInterval(int);
                    [milliseconds,seconds,minutes,hours] = [0,0,0,0];
                    timerRef.innerHTML = '00 : 00 : 00 : 00 ';

                    $('#modalstopwatch').hide();

                    window.location.reload();
                } else {
                    Swal.fire({
                        title: "Oppss!",
                        html: "Terjadi kesalahan",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                Swal.fire({
                    title: "Oppss!",
                    text: "Terjadi kesalahan",
                    icon: "error"
                });
            }
        });
        
    }

    function selesaiStopwatch() {
        let id = $('#agendaId').val();
         $.ajax({
            type: "POST",
            url: "<?= base_url('master/Absensi_rapat/selesai_stopwatch_agenda'); ?>/" + id,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(response, textStatus, xhr) {
                let str = JSON.parse(response);
                if (str.status_code === 200){

                    window.location.reload();
                } else {
                    Swal.fire({
                        title: "Oppss!",
                        html: "Terjadi kesalahan",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                Swal.fire({
                    title: "Oppss!",
                    text: "Terjadi kesalahan",
                    icon: "error"
                });
            }
        });
        
    }

    function continueStopwatch() {
        let id = $('#agendaId').val();
         $.ajax({
            type: "POST",
            url: "<?= base_url('master/Absensi_rapat/lanjut_stopwatch_agenda'); ?>/" + id,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(response, textStatus, xhr) {
                let str = JSON.parse(response);
                if (str.status_code === 200){
                    
                    let waktuMulai = new Date(str.waktu_mulai).getTime();
                    let skrg = new Date().getTime();

                    let jarak = skrg - waktuMulai;

                     hours = Math.floor((jarak % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                     minutes = Math.floor((jarak % (1000 * 60 * 60)) / (1000 * 60));
                     seconds = Math.floor((jarak % (1000 * 60)) / 1000);
                     milliseconds = 0;

                    let h = hours < 10 ? "0" + hours : hours;
                    let m = minutes < 10 ? "0" + minutes : minutes;
                    let s = seconds < 10 ? "0" + seconds : seconds;
                    let ms = "00";

                    document.querySelector('#namaagenda').innerHTML = str.agenda;

                    $('#modalstopwatch').show();
                    clearInterval(int);
                    int = setInterval(displayTimer, 10);
                } else {
                    Swal.fire({
                        title: "Oppss!",
                        html: "Terjadi kesalahan",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                Swal.fire({
                    title: "Oppss!",
                    text: "Terjadi kesalahan",
                    icon: "error"
                });
            }
        });
        
    }

    document.addEventListener('visibilitychange', function() {
        if(document.hidden) {
            //abaikan
        } else {
            let id = $('#agendaId').val();
            if(id !== "") {
                continueStopwatch(id);
            }
        }
    });
</script>