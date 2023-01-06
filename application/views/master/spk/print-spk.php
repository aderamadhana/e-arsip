<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Print SPK</title>

</head>

<style>

@font-face {

  font-family: tahoma;

  src: url("<?= base_url('assets/font/tahoma.ttf') ?>") format('truetype'); /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */

}  

body{

    color: #369;

    font-family: tahoma, Arial, sans-serif !important;

    font-size:10pt !important;

    color-adjust: exact;

    -webkit-print-color-adjust: exact;

}

@page {

  size: A4;

}

@media print {

  html, body {

    size: A4;

  }

  /* ... the rest of the rules ... */

}

aside {

  display: block;

  position: relative;

  border-left: 50px solid #369;

  padding-left: 10px;



}



aside h3 {

    font: bold 14px Sans-Serif;

    letter-spacing: 2px;

    text-transform: uppercase;

    color: #fff;

    background: #369;

    padding: 0px 10px;

    margin: 0px 0 15px -9px;

    line-height: 24px;

    position: absolute;

    bottom: -40px;

    left: -35px;

    background: none;

    transform-origin: 0 0;

    transform: rotate(270deg);

    

}   



table{

    width: 100%;

}



table.t-padding td, table th {

  /* border: 1px solid #ddd; */

  padding: 8px;

}



table.boxs td, table th {

  border: 1px solid #ddd;

  font-weight:bold;

  /* padding: 8px; */

}



hr{

    border: 1px solid #369;

}



.box{

    border: solid 1px #ddd;

}



.bg-blue{

    background: #369;

} 



.text-white{

    color: #fff;

}



.text-black{

    color: #000;

}



</style>

<?php

    $datafile = json_decode($spk['file_attachment']);

    if ($datafile) {

        $page = 4;

    }else{

        $page = 3;

    }

?>

<body onload="window.print()">

    <table class="">

        <tr>

            <td style="width:60%" class="box">

            <img src="<?= base_url('assets/logo-bri-polos.png') ?>" alt="" style="float:left;width: 35px; padding: 2px 5px;">

             <b style="padding-top: 4px;"><u>PT. BANK RAKYAT INDONESIA (PERSERO) TBK</u><br>

             UNIT KERJA : Corporate Secretary Division</b>

            </td>

            <td></td>

            <td style="width:25%; padding-top: 5px;">

                <table class="boxs" style="text-align: center">

                    <tr>

                        <td rowspan="2" style="transform: rotate(270deg);transform-origin: 0 0;top: 43px;position: relative;width: 35px;">

                            FORM

                        </td>

                        <td>SPK</td>



                    </tr>

                    <tr>

                        <td style="font-size: 11pt;">PAGE 1/<?= $page?></td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    

    <hr>

    <div>

        <table style="border: solid 1px #ddd;">

            <tr>

                <th class="bg-blue text-white">SURAT PERINTAH KERJA (SPK)</th>

            </tr>

        </table>

    </div>

    <hr>

    <table>

        <tr>

            <td style="width: 50%">

                NOMOR SPK : <span style="color: #333"><?= $spk['nomor_spk'] ?></span>

            </td>

            <td style="width: 50%">

                TANGGAL SPK : <span style="color: #333"><?= $this->template->dateBahasaIndo($spk['tanggal_spk']) ?></span>

            </td>

        </tr>

    </table>

    <hr>

        <aside>

            <h3>PENERIMA TUGAS</h3>

            <div style="min-height:180px">

                <table class="t-padding">

                    <tr>

                        <td style="width:25%">NAMA PERUSAHAAN</td>

                        <td style="width:15px"> : </td>

                        <td colspan="3" class="box">

                          <b><?= $spk['nama_perusahaan'] ?></b>

                        </td>

                    </tr>

                    <tr>

                        <td>ALAMAT PERUSAHAAN</td>

                        <td> : </td>

                        <td colspan="3" class="box text-black">

                            <b><?= $spk['alamat_perusahaan'] ?></b>

                        </td>

                    </tr>

                    <tr>

                        <td>NO TELP / FACSIMILE</td>

                        <td> : </td>

                        <td colspan="3" class="box text-black">

                            <b><?= $spk['telp_facsimile'] ?></b>

                        </td>

                    </tr>

                    <tr>

                        <td>SURAT PENAWARAN</td>

                        <td> : </td>

                        <td style="width:25%" class="box text-black"><?= $spk['surat_penawaran'] ?></td>

                        <td style="width:10%">TGL</td>

                        <td class="box text-black"><?= $this->template->dateBahasaIndo($spk['tanggal_surat_penawaran']) ?></td>



                    </tr>

                </table>

            </div>

        </aside>

    <hr>

    

        <p style="text-align:justify">Berdasarkan penawaran tersebut di atas, dengan ini disampaikan bahwa PT. Bank Rakyat Indonesia (Persero) Tbk

            (selanjutnya disebut BRI), menugaskan Perusahaan <?= $spk['nama_perusahaan'] ?> (selanjutnya disebut Pelaksana Pekerjaan)

            untuk melaksanakan Pekerjaan dengan syarat dan kondisi sebagai berikut</p>

        

        <aside>

            <h3>RUANG LINGKUP</h3>

            <div style="min-height:180px">

            <br>

                <table class="t-padding">

                    <tr>

                        <td style="width:25%">JENIS PEKERJAAN<br>RUANG LINGKUP PEKERJAAN</td>

                        <td style="width:15px"> : <br> : </td>

                        <td colspan="3" class="box text-black">

                            <?= $spk['jenis_pekerjaan'] ?><br>

                            <?= $spk['ruang_lingkup_pekerjaan'] ?>

                        </td>

                    </tr>

                    <tr>

                        <td colspan="5" class="box text-black">

                            <div style="min-height:70px">

                                <?= $spk['catatan_ruang_lingkup'] ?>

                            </div>

                        </td>

                    </tr>

                    

                </table>

            </div>

        </aside>

    <hr>

        <aside>

            <h3>IMBALAN JASA</h3>

            <div style="min-height:180px">

            <br>

                <table class="t-padding">

                    <tr>

                        <td style="width:10%">HARGA</td>

                        <td style="width:2%"> : </td>

                        <td  style="width:40%">

                            <div class="box" style="padding : 10px;text-align:center;min-height:50px">

                                <b><?= "Rp " . number_format($spk['harga'],0,',','.') ?>,-<br></b>

                                <small>(termasuk agency fee, PPN 10% dan pajak lainnya)</small>

                            

                            </div>

                        </td>

                        <td colspan="2">

                            <div class="box text-black" style="padding : 10px;text-align:center;min-height:50px">

                                <b><u>TOTAL HARGA TERBILANG :</u></b> <br>

                                <i>"<?= $spk['total_harga_terbilang'] ?>"</i>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td colspan="5" class="box">

                            <div style="min-height:70px">

                                <b> CATATAN :</b>

                                <?= $spk['catatan_imbalan_jasa'] ?>

                            </div>

                        </td>

                    </tr>

                    

                </table>

            </div>

        </aside>

    <hr>

        

        <div style="page-break-before: always;"></div>

    

        <table class="">

        <tr>

            <td style="width:60%" class="box">

            <img src="<?= base_url('assets/logo-bri-polos.png') ?>" alt="" style="float:left;width: 35px; padding: 2px 5px;">

             <b style="padding-top: 4px;"><u>PT. BANK RAKYAT INDONESIA (PERSERO) TBK</u><br>

             UNIT KERJA : Corporate Secretary Division</b>

            </td>

            <td></td>

            <td style="width:25%; padding-top: 5px;">

                <table class="boxs" style="text-align: center">

                    <tr>

                        <td rowspan="2" style="transform: rotate(270deg);transform-origin: 0 0;top: 43px;position: relative;width: 35px;">

                            FORM

                        </td>

                        <td>SPK</td>



                    </tr>

                    <tr>

                        <td style="font-size: 11pt;">PAGE 2/<?= $page?></td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <hr>

        <aside>

            <h3>JANGKA WAKTU <br> DELIVERABLES</h3>

            <div style="min-height:180px">

                <table class="t-padding">

                    <tr>

                        <td>

                            <div class="box text-black" style="padding : 10px;min-height:100px">

                                <?= $spk['jangka_waktu'] ?>

                            </div>

                        </td>

                    </tr>

                    

                </table>

            </div>

        </aside>

        <hr>

        <aside>

            <h3>CARA PEMBAYARAN</h3>

            <div style="min-height:180px">

                <table class="t-padding">

                    <tr>

                        <td>

                            <div class="box text-black" style="padding : 10px;min-height:100px">

                                <?= $spk['cara_pembayaran'] ?>

                            </div>

                        </td>

                    </tr>

                    

                </table>

            </div>

        </aside>

        <div style="page-break-before: always;"></div>

    

        <table class="">

        <tr>

            <td style="width:60%" class="box">

            <img src="<?= base_url('assets/logo-bri-polos.png') ?>" alt="" style="float:left;width: 35px; padding: 2px 5px;">

             <b style="padding-top: 4px;"><u>PT. BANK RAKYAT INDONESIA (PERSERO) TBK</u><br>

             UNIT KERJA : Corporate Secretary Division</b>

            </td>

            <td></td>

            <td style="width:25%; padding-top: 5px;">

                <table class="boxs" style="text-align: center">

                    <tr>

                        <td rowspan="2" style="transform: rotate(270deg);transform-origin: 0 0;top: 43px;position: relative;width: 35px;">

                            FORM

                        </td>

                        <td>SPK</td>



                    </tr>

                    <tr>

                        <td style="font-size: 11pt;">PAGE 3/<?= $page?></td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <div>

        <table style="border: solid 1px #ddd;">

            <tr>

                <th class="bg-blue text-white">SURAT PERINTAH KERJA (SPK)</th>

            </tr>

            <tr>

                <th class="bg-blue text-white">JAMINAN DARI PELAKSANA PEKERJAAN</th>

            </tr>

            <tr>

                <td style="text-align: justify;">

                Pelaksana Pekerjaan dengan ini menjamin bahwa jasa yang akan disediakan dan diserahkan kepada BRI adalah dalam

                keadaan baik, bebas dari kesalahan pembuatan dan cacat tersembunyi dan sesuai dengan spesifikasi atau fungsinya serta

                apabila mengandung unsur Hak Atas Kekayaan intelektual (HAKI) maka HAKI yang digunakan sepenuhnya terbebas dari

                segala bentuk pelanggaran hukum dan atau tuntutan apapun dari pihak manapun berkaitan dengan penggunaan HAKI

                dimaksud. <b> Penugasan ini tidak dijamin dengan Jaminan Pelaksanaan Pekerjaan mengingat pekerjaan telah selesai

                dilaksanakan.</b>

                </td>

            </tr>

            

        </table>

    </div>



    <hr>

        <aside>

            <h3>LAIN LAIN</h3>

            <div style="min-height:180px">

                <table class="t-padding">

                    <tr>

                        <td>

                            <div class="box text-black" style="padding : 10px;min-height:100px">

                                <?= $spk['lain_lain'] ?>

                            </div>

                        </td>

                    </tr>

                    

                </table>

            </div>

        </aside>

    <hr>
    <div>
        <table style="border: solid 1px #ddd;">
            <tr>
                <th class="bg-blue text-white" style="width:40%"><?= $spk['nama_perusahaan'] ?></th>
                <th class="bg-blue text-white">PT. BANK RAKYAT INDONESIA (PERSERO) TBK</th>
            </tr>
            
            <tr>
                <td>
                    <div class="box text-black" style="min-height:150px;text-align:center">
                    
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                        <b><u><?= $spk['pic_penerima_kerja'] ?></u> </b><br>
                        <?= $spk['jabatan_penerima_kerja'] ?>
                    </div>
                </td>
                <td>
                    <div class="box text-black" style="min-height:150px;text-align:center">
                    
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                        <b><u><?= $spk['pic_pemberi_kerja'] ?></u> </b><br>
                        <?= $spk['jabatan_pemberi_kerja'] ?>
                    </div>
                </td>
            </tr>
            
        </table>
        <div style="page-break-before: always;"></div>
    </div>

    <?php if ($datafile) { ?>

        <table class="">

            <tr>

                <td style="width:60%" class="box">

                <img src="<?= base_url('assets/logo-bri-polos.png') ?>" alt="" style="float:left;width: 35px; padding: 2px 5px;">

                 <b style="padding-top: 4px;"><u>PT. BANK RAKYAT INDONESIA (PERSERO) TBK</u><br>

                 UNIT KERJA : Corporate Secretary Division</b>

                </td>

                <td></td>

                <td style="width:25%; padding-top: 5px;">

                    <table class="boxs" style="text-align: center">

                        <tr>

                            <td rowspan="2" style="transform: rotate(270deg);transform-origin: 0 0;top: 43px;position: relative;width: 35px;">

                                FORM

                            </td>

                            <td>SPK</td>



                        </tr>

                        <tr>

                            <td style="font-size: 11pt;">PAGE 4/<?= $page;?></td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

        <hr>

        <div class="box text-black" style="padding : 10px;min-height:100px">

            <?php

                $path = str_replace('/', '_', $spk['nomor_spk']);

                foreach ($datafile as $key => &$val) {

            ?>

                <img style="width: 100%; height: 450px;" src="<?= base_url('webfile/spk/'.$path.'/'.$val) ?>"> <br>

            <?php } ?>

        </div>

    <?php }?>

</body>

</html>