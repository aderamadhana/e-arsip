<html lang="en">
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
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi Pemateri</title>
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> -->
    <style>
        * {
            font-family: tahoma;
            src: url("<?= base_url('assets/font/tahoma.ttf') ?>") format('truetype');
            /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
        }

        @page {
            size: 21cm 29.7cm;
        }
    </style>
</head>

<body>
    <center>
         <?php 

            $judulrapat['rapat_direksi'] = 'Rapat Direksi';
            $judulrapat['komite_komisaris'] = 'Rapat Komisaris';
            $judulrapat['komite_direksi'] = 'Rapat Komite Direksi';
            $judulrapat['rapat_gabungan'] = 'Rapat Gabungan';

        ?> 
        <?php if (@$absensi_rapat['ar_mk_nama'] != '') { ?>
            <?= $absensi_rapat['ar_mk_nama'] ?>
        <?php } ?>
        <h2>Absensi Kehadiran Divisi Pemateri pada <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></h2>
    </center>
    <table style="width:500px;">
        <?php if (@$absensi_rapat['ar_sub_komite'] != '') { ?>
            <tr>
                <th style="width:100px;text-align: left;">Sub Komite</th>
                <th style="width:1px"> : </th>
                <td style="text-align: left;">
                    <?php
                    $sub_komite = json_decode($absensi_rapat['ar_sub_komite'], true);
                    
                    $dataString = implode(",", $sub_komite);
                    echo $dataString; 
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th style="width:100px;text-align: left;">Hari, Tanggal</th>
            <th style="width:1px"> : </th>
            <td style="text-align: left;">
                <?php
                $timestamp = strtotime($absensi_rapat['ar_tanggal']);
                $day = date('D', $timestamp);
                echo hari_ini($day) . ", " . date("d-m-Y", strtotime($absensi_rapat['ar_tanggal']));
                ?>
            </td>
        </tr>
        <tr>
            <th style="width:100px;text-align: left;">Waktu</th>
            <th style="width:1px"> : </th>
            <td style="text-align: left;">
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
    <table style="width: 100%;" border="1px;">
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
            $divisi = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $absensi_rapat['ar_id'], 'are_tipe' => 'Non Komisaris', 'are_status_kehadiran' => 'Hadir']);
            if ($divisi) {
                foreach ($divisi as $div) {
            ?>
                    <tr>
                        <td>
                            <center><?= $number . "."; ?></center>
                        </td>
                        <td><?= $div['are_nama_pejabat_divisi']; ?></td>
                        <?php if (($number % 2) != 0) { ?>
                            <td style="width: 250px;height:100px;">
                                <?= $number . "."; ?>
                                &nbsp;
                                <?php
                                $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                if (file_exists($filename)) {
                                    $path = $filename;
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    echo "<img src='" . $base64 . "' style='width:100px;' />";
                                }
                                ?>
                            </td>
                            <td style="width: 250px;"></td>
                        <?php } else { ?>
                            <td style="width: 250px;"></td>
                            <td style="width: 250px;height:100px;">
                                <?= $number . "."; ?>
                                &nbsp;
                                <?php
                                $filename = './webfile/ttd_absensi_rapat/' . $div['are_ttd'];
                                if (file_exists($filename)) {
                                    $path = $filename;
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    echo "<img src='" . $base64 . "' style='width:100px;' />";
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
</body>

</html>