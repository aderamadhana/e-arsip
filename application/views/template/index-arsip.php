<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
<style>
    .text-white {
        color: #fff;
    }

    .round {
        border-radius: 20px;
        box-shadow: 0 0 40px 0 rgba(0, 0, 0, .1);
        background: #fff;
    }

    .card-body {
        padding: 15px;
        margin: 10px 0px;
    }

    .card .card-title {
        color: #010101;
        margin-bottom: 1.2rem;
        text-transform: capitalize;
        font-size: 1.5rem;
        font-weight: 60;
    }

    .card-title {
        margin-bottom: 0.75rem;
    }

    .grid-margin {
        margin-bottom: 2.5rem;
    }

    .stretch-card {
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: stretch;
        align-items: stretch;
        -webkit-justify-content: stretch;
        justify-content: stretch;
    }

    .stretch-card>.card {
        width: 100%;
        min-width: 100%;
    }

    /** ================================================== */

    .chartjs-legend ul {
        margin-bottom: 0;
        list-style: none;
        padding-left: 0;
    }

    .chartjs-legend ul li {
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: center;
        align-items: center;
    }

    .chartjs-legend ul li span {
        width: 1.562rem;
        height: 0.312rem;
        margin-right: .4rem;
        display: inline-block;
        font-size: 0.875rem;
        border-radius: 3px;
    }

    .rtl .chartjs-legend ul {
        padding-right: 0;
    }

    .rtl .chartjs-legend ul li {
        margin-right: 0;
        margin-left: 8%;
    }

    .rtl .chartjs-legend ul li span {
        margin-right: 0;
        margin-left: 1rem;
    }

    .chartjs-legend.analytics-legend ul {
        padding-left: 0;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .mr-4,
    .mx-4 {
        margin-right: 1.5rem !important;
    }

    .mr-xl-5,
    .mx-xl-5 {
        margin-right: 3rem !important;
    }

    .mt-3,
    .template-demo>.btn,
    .fc .template-demo>button,
    .ajax-upload-dragdrop .template-demo>.ajax-file-upload,
    .swal2-modal .swal2-buttonswrapper .template-demo>.swal2-styled,
    .wizard>.actions .template-demo>a,
    .template-demo>.btn-toolbar,
    .my-3 {
        margin-top: 1rem !important;
    }

    .align-items-center,
    .loader-demo-box,
    .list-wrapper ul li,
    .email-wrapper .message-body .attachments-sections ul li .thumb,
    .email-wrapper .message-body .attachments-sections ul li .details .buttons,
    .navbar .navbar-menu-wrapper .navbar-nav,
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-settings,
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile,
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown .dropdown-item,
    .navbar .navbar-menu-wrapper .navbar-nav.navbar-nav-right .nav-item {
        align-items: center !important;
    }

    .mr-3,
    .template-demo>.btn-toolbar,
    .mx-3 {
        margin-right: 1rem !important;
    }

    .mb-0,
    .my-0 {
        margin-bottom: 0 !important;
    }

    .judul-card {
        font-size: 22px;
        font-family: 'Overpass', sans-serif;
        color: black
    }

    .judul-card:hover {
        color: #0b7ee6 !important;
    }
</style>
<section class="content" style="background-color: #F5F7FF;">
    <div class="row">
        <?php
        $this->db->select('COUNT(*) as total');
        if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'kepala_divisi' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
            $this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
            $this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
        }
        if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'kepala_divisi' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
            $this->db->where('status', 'diajukan');
        } else {
            $this->db->where('status', 'diajukan');
        }
        $this->db->where('ad_tipesurat', 'Surat Masuk');
        $suratmasuk = $this->mymodel->selectDataone('arsip_dokumen', []);
        ?>
        <div class="<?= $this->session->userdata('role_slug') != 'super_admin' ? 'col-md-4' : 'col-md-3' ?> grid-margin">
            <div class="card mb-4 box-shadow" style="background: #caa7d35c;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>
                                <a href="<?= base_url('arsip_dokumen') ?>">
                                    <span class="judul-card"><b><u>SURAT MASUK</u></b></span>
                                </a>
                            </h4>
                            <h1 class="card-title pricing-card-title">
                                <span style="font-size: 50px;"><?= number_format($suratmasuk['total'], 0, ',', '.') ?></span>
                                <img src="<?= base_url('assets/images/new-icons/surat_masuk.png') ?>" style="width: 50px;float: right;margin-top: 0px;margin-bottom: 0px;">
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $this->db->select('COUNT(*) as total');
        if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'kepala_divisi' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
            $this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
            $this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
        }
        $this->db->where('status !=', 'dihapus');
        $this->db->where('ad_is_booking', '0');
        $this->db->where('ad_tipesurat', 'Surat Keluar');
        $suratkeluar = $this->mymodel->selectDataone('arsip_dokumen', []);
        ?>
        <div class="<?= $this->session->userdata('role_slug') != 'super_admin' ? 'col-md-4' : 'col-md-3' ?> grid-margin">
            <div class="card mb-4 box-shadow" style="background: #c6e2e9;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>
                                <a href="<?= base_url('arsip_dokumen/surat_keluar') ?>">
                                    <span class="judul-card"><b><u>SURAT KELUAR</u></b></span>
                                </a>
                            </h4>
                            <h1 class="card-title pricing-card-title">
                                <span style="font-size: 50px;"><?= number_format($suratkeluar['total'], 0, ',', '.') ?></span>
                                <img src="<?= base_url('assets/images/new-icons/surat_keluar.png') ?>" style="width: 50px;float: right;margin-top: 0px;margin-bottom: 0px;">
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $departemen = $this->mymodel->selectDataone('user', ['id' => $this->session->userdata('id')])['departemen'];
        $this->db->select('COUNT(*) as total');
        if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'kepala_departemen' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
            $this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
            $this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_pengirim = "' . $this->session->userdata('id') . '"');
        }
        if ($this->session->userdata('role_slug') == 'kepala_departemen') {
            $this->db->join('arsip_dokumen_departement', 'add_id_arsip_dokumen = ad_id');
            $this->db->where('add_id_departement', $departemen);
        }
        $this->db->where('status', 'didisposisikan');
        $this->db->where('ad_tipesurat', 'Surat Masuk');
        $telahdisposisi = $this->mymodel->selectDataone('arsip_dokumen', []);
        ?>
        <div class="<?= $this->session->userdata('role_slug') != 'super_admin' ? 'col-md-4' : 'col-md-3' ?> grid-margin">
            <div class="card mb-4 box-shadow" style="background: #f1ffc4;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>
                                <a href="<?= base_url('arsip_dokumen?status=didisposisikan') ?>">
                                    <span class="judul-card"><b><u><?= ($this->session->userdata('role_slug') == 'officer') ? 'TINDAK LANJUT' : 'TELAH DISPOSISI' ?></u></b></span>
                                </a>
                            </h4>
                            <h1 class="card-title pricing-card-title">
                                <span style="font-size: 50px;"><?= number_format($telahdisposisi['total'], 0, ',', '.') ?></span>
                                <img src="<?= base_url('assets/images/new-icons/Sudah Disposisi.png') ?>" style="width: 50px;float: right;margin-top: 0px;margin-bottom: 0px;">
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($this->session->userdata('role_slug') == 'super_admin') {
            $this->db->select('COUNT(*) as total');
            $notulenradisi = $this->mymodel->selectDataone('notulensi_radisi', []); ?>
            <div class="col-md-3 grid-margin">
                <div class="card mb-4 box-shadow" style="background: #ffcaaf;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>
                                    <a href="<?= base_url('notulen_radisi/index') ?>">
                                        <span class="judul-card"><b><u>NOTULEN RADISI</u></b></span>
                                    </a>
                                </h4>
                                <h1 class="card-title pricing-card-title">
                                    <span style="font-size: 50px;"><?= number_format($notulenradisi['total'], 0, ',', '.') ?></span>
                                    <img src="<?= base_url('assets/images/new-icons/notule_radisi.png') ?>" style="width: 50px;float: right;margin-top: 0px;margin-bottom: 0px;">
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_divisi', 'kepala_departemen', 'sekretaris_divisi'])) { ?>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Jumlah Surat Masuk</p>
                        </div>
                        <canvas id="jumlahsuratmasuk-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Jumlah Surat Keluar</p>
                        </div>
                        <canvas id="jumlahsuratkeluar-chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Jumlah Surat Berdasarkan Sifat kerahasiaan</p>
                        </div>
                        <canvas id="sifat-chart"></canvas>
                        <div id="sifat-legend"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Jumlah Surat Berdasarkan Bentuk Dokumen</p>
                        </div>
                        <canvas id="bentuk-chart"></canvas>
                        <div id="bentuk-legend"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<?php
$user = $this->mymodel->selectDataone('user', array('id' => $this->session->userdata('id')));
if ($user['role_name'] != 'Super Admin' and $user['role_name'] != 'Kepala Divisi' and $user['role_name'] != 'Sekretaris Divisi') {
    $this->db->where('id', $user['departemen']);
}
$departemen = $this->mymodel->selectWhere('m_departemen', array('status' => 'ENABLE'));
// print_r($departemen);
$namadepartemen = [];
$jumlahdepartemen = [];
$id_departemen = [];
foreach ($departemen as $key => $value) {
    $namadepartemen[] = $value['code'];
    $id_departemen[] = $value['id'];
    for ($i = 1; $i <= 12; $i++) {
        $this->db->select('COUNT(ad_id) as total');
        $this->db->join('arsip_dokumen_departement', 'add_id_arsip_dokumen = ad_id');
        $this->db->where('status !=', 'void');
        $this->db->where('status !=', 'dihapus');
        $this->db->where('ad_tipesurat', 'Surat Masuk');
        $getarsip = $this->mymodel->selectDataone('arsip_dokumen', array('MONTH(ad_tanggalsurat)' => $i, 'YEAR(ad_tanggalsurat)' => date('Y'), 'add_id_departement' => $value['id']));
        $jumlahdepartemen[$value['code']][$i] = (int)$getarsip['total'];

        $this->db->select('COUNT(ad_id) as total');
        // $this->db->where('status !=', 'void');
        $this->db->where('ad_tipesurat', 'Surat Keluar');
        $getarsip_keluar = $this->mymodel->selectDataone('arsip_dokumen', array('MONTH(ad_tanggalsurat)' => $i, 'YEAR(ad_tanggalsurat)' => date('Y'), 'ad_departemen' => $value['id']));
        $jumlahdepartemen_keluar[$value['code']][$i] = (int)$getarsip_keluar['total'];
    }
}


$sifat = array('biasa' => 'Biasa', 'rahasia' => 'Rahasia', 'sangat_rahasia' => 'Sangat Rahasia');
$jumlahsifat = [];
foreach ($sifat as $key => $value) {
    $this->db->select('COUNT(ad_id) as total');
    $this->db->where('status !=', 'void');
    $this->db->where('status !=', 'dihapus');
    $this->db->where('MONTH(ad_tanggalsurat)', date('m'));
    $this->db->where('YEAR(ad_tanggalsurat)', date('Y'));
    if ($user['role_name'] != 'Super Admin' and $user['role_name'] != 'Kepala Divisi' and $user['role_name'] != 'Sekretaris Divisi') {
        $this->db->join('arsip_dokumen_departement', 'add_id_arsip_dokumen = ad_id');
        $this->db->where_in('add_id_departement', $id_departemen);
    }
    $getarsip = $this->mymodel->selectDataone('arsip_dokumen', array('ad_sifatsurat' => $key));
    $jumlahsifat[$key] = $getarsip['total'];
}

$bentuk = array('surat' => 'Surat', 'surat_dan_proposal' => 'Surat Dan Proposal', 'surat_dan_dokumen_pendukung_lainnya' => 'Surat Dan Dokumen Pendukung');
$jumlahbentuk = [];
foreach ($bentuk as $key => $value) {
    $this->db->select('COUNT(ad_id) as total');
    $this->db->join('arsip_dokumen_departement', 'add_id_arsip_dokumen = ad_id');
    $this->db->where('status !=', 'void');
    $this->db->where('MONTH(ad_tanggalsurat)', date('m'));
    $this->db->where('YEAR(ad_tanggalsurat)', date('Y'));
    if ($user['role_name'] != 'Super Admin' and $user['role_name'] != 'Kepala Divisi' and $user['role_name'] != 'Sekretaris Divisi') {
        $this->db->where_in('add_id_departement', $id_departemen);
    }
    $getarsip = $this->mymodel->selectDataone('arsip_dokumen', array('ad_bentukdokumen' => $key));
    $jumlahbentuk[$key] = $getarsip['total'];
}
?>

<script src="<?= base_url('assets/') ?>vendor2/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor2/js/Chart.roundedBarCharts.js"></script>
<script src="<?= base_url('assets/') ?>vendor2/js/off-canvas.js"></script>

<script>
    var jumlahsuratmasukChartCanvas = $("#jumlahsuratmasuk-chart").get(0).getContext("2d");
    var jumlahsuratmasukChart = new Chart(jumlahsuratmasukChartCanvas, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                <?php
                $icolor = 0;
                foreach ($namadepartemen as $key => $value) { ?> {
                        label: '<?= $value ?>',
                        data: [
                            <?php
                            foreach ($jumlahdepartemen[$value] as $key => $value) {
                                echo $value . ', ';
                            }
                            ?>
                        ],
                        backgroundColor: '#<?php
                                            if ($icolor == 0) {
                                                echo '55efc4';
                                            }
                                            if ($icolor == 1) {
                                                echo 'f7a35c';
                                            }
                                            if ($icolor == 2) {
                                                echo '74b9ff';
                                            }
                                            if ($icolor == 3) {
                                                echo 'a29bfe';
                                            }
                                            if ($icolor == 4) {
                                                echo 'ff7675';
                                            }
                                            ?>',
                    },
                <?php
                    $icolor++;
                }
                ?>
            ]
        },
        options: {
            cornerRadius: 5,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 0
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        color: "#F2F2F2"
                    },
                    ticks: {
                        tickInterval: 1,
                        display: true,
                        min: 0,
                        autoSkip: true,
                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#6C7383"
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1
                }]
            },
            legend: {
                position: 'bottom'
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });

    // =====================================================================================
    var jumlahsuratkeluarChartCanvas = $("#jumlahsuratkeluar-chart").get(0).getContext("2d");
    var jumlahsuratkeluarChart = new Chart(jumlahsuratkeluarChartCanvas, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                <?php
                $icolor = 0;
                foreach ($namadepartemen as $key => $value) { ?> {
                        label: '<?= $value ?>',
                        data: [
                            <?php
                            foreach ($jumlahdepartemen_keluar[$value] as $key => $value) {
                                echo $value . ', ';
                            }
                            ?>
                        ],
                        backgroundColor: '#<?php
                                            if ($icolor == 0) {
                                                echo '55efc4';
                                            }
                                            if ($icolor == 1) {
                                                echo 'f7a35c';
                                            }
                                            if ($icolor == 2) {
                                                echo '74b9ff';
                                            }
                                            if ($icolor == 3) {
                                                echo 'a29bfe';
                                            }
                                            if ($icolor == 4) {
                                                echo 'ff7675';
                                            }
                                            ?>',
                    },
                <?php
                    $icolor++;
                }
                ?>
            ]
        },
        options: {
            cornerRadius: 5,
            responsive: true,
            maintainAspectRatio: true,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 0
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        color: "#F2F2F2"
                    },
                    ticks: {
                        tickInterval: 1,
                        display: true,
                        min: 0,
                        autoSkip: true,
                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#6C7383"
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1
                }]
            },
            legend: {
                position: 'bottom'
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });
</script>

<script type="text/javascript">
    // Build the chart
    var areaData = {
        labels: [
            <?php foreach ($sifat as $key => $value) { ?> '<?= $value ?>',
            <?php } ?>
        ],
        datasets: [{
            data: [
                <?php foreach ($sifat as $key => $value) { ?> '<?= $jumlahsifat[$key] ?>',
                <?php } ?>
            ],
            backgroundColor: [
                "#74b9ff", "#a29bfe", "#ff7675",
            ],
            borderColor: "rgba(0,0,0,0)"
        }]
    };
    var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
            arc: {
                borderWidth: 4
            }
        },
        legend: {
            display: false
        },
        tooltips: {
            enabled: true
        },
        legendCallback: function(chart) {
            var text = [];
            for (var i = 0; i < chart.data.labels.length; i++) {
                text.push('<div class="row">');
                text.push('<div class="col-md-4">');
                text.push('<div style="display: table;">');
                text.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[i] + '"></div></div>');
                text.push('<div style="display: table-cell;"><span style="color:#737F8B">' + chart.data.labels[i] + '</span></div>');
                text.push('</div>');
                text.push('</div>');
                text.push('<div class="col-md-2">');
                text.push('<span style="font-family:Nunito,sans-serif;font-weight:700 !important;font-size:16px">' + chart.data.datasets[0].data[i] + '</span>');
                text.push('</div>');
                text.push('</div>');
            }
            return text.join("");
        },
    }

    var sifatChartPlugins = {
        beforeDraw: function(chart) {
            var totalSifat = 0;
            for (var z = 0; z < chart.data.datasets[0].data.length; z++) {
                totalSifat = totalSifat + parseInt(chart.data.datasets[0].data[z]);
            }

            var width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx;

            ctx.restore();
            var fontSize = 3.125;
            ctx.font = "500 " + fontSize + "em sans-serif";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#13381B";

            var text = totalSifat.toString(),
                textX = Math.round((width - ctx.measureText(text).width) / 2),
                textY = height / 2;

            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    }
    var sifatChartCanvas = $("#sifat-chart").get(0).getContext("2d");
    var sifatChart = new Chart(sifatChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: sifatChartPlugins
    });
    document.getElementById('sifat-legend').innerHTML = sifatChart.generateLegend();
    // Build the chart
    var areaDatabentuk = {
        labels: [
            <?php foreach ($bentuk as $key => $value) { ?> '<?= $value ?>',
            <?php } ?>
        ],
        datasets: [{
            data: [
                <?php foreach ($bentuk as $key => $value) { ?> '<?= $jumlahbentuk[$key] ?>',
                <?php } ?>
            ],
            backgroundColor: [
                "#74b9ff", "#a29bfe", "#ff7675",
            ],
            borderColor: "rgba(0,0,0,0)"
        }]
    };
    var areaOptionsbentuk = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
            arc: {
                borderWidth: 4
            }
        },
        legend: {
            display: false
        },
        tooltips: {
            enabled: true
        },
        legendCallback: function(chart) {
            var text = [];
            for (var i = 0; i < chart.data.labels.length; i++) {
                text.push('<div class="row">');
                text.push('<div class="col-md-7">');
                text.push('<div style="display: table;">');
                text.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[i] + '"></div></div>');
                text.push('<div style="display: table-cell;"><span style="color:#737F8B">' + chart.data.labels[i] + '</span></div>');
                text.push('</div>');
                text.push('</div>');
                text.push('<div class="col-md-2">');
                text.push('<span style="font-family:Nunito,sans-serif;font-weight:700 !important;font-size:16px">' + chart.data.datasets[0].data[i] + '</span>');
                text.push('</div>');
                text.push('</div>');
            }
            return text.join("");
        },
    }

    var bentukChartPlugins = {
        beforeDraw: function(chart) {
            var totalbentuk = 0;
            for (var z = 0; z < chart.data.datasets[0].data.length; z++) {
                totalbentuk = totalbentuk + parseInt(chart.data.datasets[0].data[z]);
            }

            var width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx;

            ctx.restore();
            var fontSize = 3.125;
            ctx.font = "500 " + fontSize + "em sans-serif";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#13381B";

            var text = totalbentuk.toString(),
                textX = Math.round((width - ctx.measureText(text).width) / 2),
                textY = height / 2;

            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    }
    var bentukChartCanvas = $("#bentuk-chart").get(0).getContext("2d");
    var bentukChart = new Chart(bentukChartCanvas, {
        type: 'doughnut',
        data: areaDatabentuk,
        options: areaOptionsbentuk,
        plugins: bentukChartPlugins
    });
    document.getElementById('bentuk-legend').innerHTML = bentukChart.generateLegend();
</script>