<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Agenda Rapat</title>
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> -->
    <?php
    $path = './webfile/background-bri.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    <style>
        * {
            font-family: tahoma;
            src: url("<?= base_url('assets/font/tahoma.ttf') ?>") format('truetype');
            /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
        }

        @page {
            size: 29.7cm 21cm;
        }

        .background {
            background-image: url("<?= $base64; ?>");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            /* responsive height */
        }
    </style>
</head>

<body class="background">
    <?php
    if ($absensi_rapat_agenda) :
        $display = 6;
        //echo $display;exit();
        // inisialisasi variabel page
        $page = 1;

        // mengatur data dalam array
        foreach ($absensi_rapat_agenda as $pesertaBagi) :
            $arrdata[] = $pesertaBagi;
        endforeach;

        $jumlah = count($absensi_rapat_agenda);
        if (($jumlah % $display) == 0) {
            $total = (int)($jumlah / $display);
        } else {
            $total = ((int)($jumlah / $display) + 1);
        }
    endif;

    if ($absensi_rapat_agenda) {
        for ($page = 1; $page <= $total; $page++) {
            $start  = ($page * $display) - $display;
            $view   = array_slice($arrdata, $start, $display);
            $end    = $display * $page;
    ?>
            <div <?= ($page != 1) ? "style='page-break-after: always;'" : ""; ?>>
                <center>
                    <p style="font-size: 26px;">
                        <b>
                            PT BANK RAKYAT INDONESIA (Persero) Tbk.
                            <br />

                            <?php 

                                $judulrapat['rapat_direksi'] = 'Rapat Direksi';
                                $judulrapat['komite_komisaris'] = 'Rapat Komisaris';
                                $judulrapat['komite_direksi'] = 'Rapat Komite Direksi';
                                $judulrapat['rapat_gabungan'] = 'Rapat Gabungan';

                            ?>  


                            <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?> - <?= $data_tanggal; ?>
                        </b>
                    </p>
                </center>
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;width:500px;">
                            <table style="width: 100%;font-size:18px;">
                                <?php
                                $seq_number = 1;
                                foreach ($view as $ara) { ?>
                                    <tr>
                                        <td style="vertical-align: top;text-align:left;width:50px;"><b><?= $seq_number . "."; ?></b></td>
                                        <td>
                                            <b><?= $ara['ara_nama']; ?></b>
                                            <br>
                                            <?php
                                            $jam_mulai = strtotime($ara['ara_mulai']);
                                            $jam_selesai = strtotime($ara['ara_selesai']);
                                            ?>
                                            Pukul: <?= date('H:i', $jam_mulai); ?> - <?= date('H:i', $jam_selesai); ?> WIB
                                            <br />
                                            <?php
                                            $data_pemateri = json_decode($ara['ara_id_divisi_materi']);
                                            $count_pemateri = count($data_pemateri);
                                            $str_pemateri = "";
                                            $number_pemateri = 1;
                                            foreach ($data_pemateri as $dtm) {
                                                $this->db->select('md_singkatan');
                                                $div_mat = $this->mymodel->selectDataone('m_divisi', ['md_id' => $dtm]);
                                                if ($number_pemateri == $count_pemateri) {
                                                    $str_pemateri .= $div_mat['md_singkatan'] . ".";
                                                } else {
                                                    $str_pemateri .= $div_mat['md_singkatan'] . ", ";
                                                }
                                                $number_pemateri++;
                                            }
                                            ?>
                                            Pemateri: Divisi <?= $str_pemateri; ?>
                                            <br />
                                            <?php
                                            $data_pendamping = json_decode($ara['ara_id_divisi_pendamping']);
                                            $count_pendamping = count($data_pendamping);
                                            $str_pendamping = "";
                                            $number_pendamping = 1;
                                            foreach ($data_pendamping as $dtm) {
                                                $this->db->select('md_singkatan');
                                                $div_mat = $this->mymodel->selectDataone('m_divisi', ['md_id' => $dtm]);
                                                if ($number_pendamping == $count_pendamping) {
                                                    $str_pendamping .= $div_mat['md_singkatan'] . ".";
                                                } else {
                                                    $str_pendamping .= $div_mat['md_singkatan'] . ", ";
                                                }
                                                $number_pendamping++;
                                            }
                                            ?>
                                            Pendamping: Divisi <?= $str_pendamping; ?>
                                        </td>
                                    </tr>
                                    <?php $seq_number++; ?>
                                <?php } ?>
                            </table>
                        </td>
                        <td style="vertical-align: top;width:450px;">
                            <table style="width: 100%;font-size:20px;">
                                <tr>
                                    <td style="vertical-align: top;text-align:left;width:50px;">
                                        <center>
                                            <b>Daftar Hadir <?= $judulrapat[$absensi_rapat['ar_tipe_rapat']] ?></b>
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <center>
                                            <?php
                                            $path = './webfile/qr_absensi_rapat/qrcode-' . $absensi_rapat['ar_id'] . '.jpg';
                                            $type = pathinfo($path, PATHINFO_EXTENSION);
                                            $data = file_get_contents($path);
                                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                            ?>
                                            <img src="<?= $base64; ?>" alt="image" style="width: 200px;">
                                        </center>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
    <?php }
    } ?>
</body>

</html>