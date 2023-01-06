<style>
    .text-white {
        color: #fff;
    }

    .round {
        border-radius: 20px;
        box-shadow: 0 0 40px 0 rgba(0, 0, 0, .1);
        background: #fff;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #e3e3e3;
        border-radius: 20px;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
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

    .justify-content-between {
        justify-content: space-between !important;
    }

    .card-title {
        margin-bottom: 0.75rem;
    }

    .card .card-title {
        color: #010101;
        margin-bottom: 1.2rem;
        text-transform: capitalize;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .mb-3,
    .template-demo .circle-progress-block,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .mb-md-0,
    .my-md-0 {
        margin-bottom: 0 !important;
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

    .table-borderless th,
    .table-borderless td,
    .table-borderless thead th,
    .table-borderless tbody+tbody {
        border: 0;
    }

    .text-muted,
    .preview-list .preview-item .preview-item-content p .content-category,
    .email-wrapper .mail-sidebar .menu-bar .profile-list-item a .user .u-designation,
    .email-wrapper .mail-list-container .mail-list .content .message_text,
    .email-wrapper .mail-list-container .mail-list .details .date {
        color: #737F8B !important;
    }

    .w-100 {
        width: 50% !important;
    }

    .pr-0,
    .px-0 {
        padding-right: 0 !important;
    }

    .pl-0,
    .px-0 {
        padding-left: 0 !important;
    }

    .progress {
        display: flex;
        height: 1rem;
        overflow: hidden;
        line-height: 0;
        font-size: 0.75rem;
        background-color: #e9ecef;
        border-radius: 0.25rem;
    }

    .progress {
        border-radius: 7px;
        height: 8px;
    }

    .progress .progress-bar {
        border-radius: 7px;
    }

    .progress.progress-sm {
        height: 0.375rem;
    }

    .progress.progress-md {
        height: 11px;
    }

    .progress.progress-lg {
        height: 15px;
    }

    .progress.progress-xl {
        height: 18px;
    }

    .mx-4 {
        margin-right: 1.5rem !important;
    }

    .ml-4,
    .mx-4 {
        margin-left: 1.5rem !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #F5F7FF;
    }

    .table-dark.table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-borderless th,
    .table-borderless td,
    .table-borderless thead th,
    .table-borderless tbody+tbody {
        border: 0;
    }
</style>
<script src="<?= base_url('assets/dist/js/chartjs-plugin-colorschemes.min.js') ?>"></script>

<section class="content" style="background-color: #F5F7FF;">
    <?php if (in_array($this->session->userdata('role_slug'), ['super_admin', 'kepala_divisi', 'kepala_departemen', 'sekretaris_divisi'])) { ?>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah Sponsor </p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="kategori-jumlah-sponsor"></table>
                        </div>
                        <div style="display: table;">
                            <div style="display: table-cell;">
                                <div class="mr-3 bg-primary" style="background-color: #7cb5ec; width:10px; height:10px; border-radius: 50%;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah sponsor diberikan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah Sponsor Cancel dan Diberikan</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="kategoriDanJumlahSponsorCancel"></table>
                        </div>
                        <div style="display: table;">
                            <div style="display: table-cell;">
                                <div class="mr-3 bg-primary" style="background-color: #7cb5ec; width:10px; height:10px; border-radius: 50%;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah sponsor
                            </div>
                            &emsp;&emsp;&emsp;
                            <div style="display: table-cell;">
                                <div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: black;"></div>
                            </div>
                            <div style="display: table-cell;">
                                &emsp;Jumlah cancel
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kantor Wilayah + KCK : Kategori dan Nominal Sponsor</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3" style="margin-top: 30px;">
                            <table class="table table-borderless report-table" id="kantorDanNominalSponsor"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Nominal Sponsor</p>
                        </div>
                        <canvas id="kategoriDanNominalSponsor-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Jumlah Sponsor<br><span style="visibility: hidden">DD</span></p>
                        </div>
                        <canvas id="pie-kategoriDanJumlahSponsor" style="margin-top:45px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kategori dan Nominal Sponsor<br><span style="visibility: hidden">DD</span></p>
                        </div>
                        <canvas id="pie-kategoriDanNominalSponsor" style="margin-top:45px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Kantor Wilayah + KCK<br>Kategori dan Nominal Sponsor</p>
                        </div>
                        <canvas id="pie-kantorDanNominalSponsor" style="margin-top:45px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-flex">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Pencantuman Logo dan Jumlah Sponsor Diberikan</p>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                            <table class="table table-borderless report-table" id="logoDannominalsponsor" style="margin-top:30px"></table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Pencantuman Logo dan Jumlah</p>
                        </div>
                        <canvas id="logoDannominalsponsor-chart-pie" style="margin-top:30px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-flex">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between" style="margin-bottom: 10px;">
                            <p class="card-title">Jenis Kegiatan dan Jumlah Sponsor</p>
                            <select name="" class="form-control select-kategorilingkupDanNominalSponsor" required="required"></select>
                        </div>
                        <canvas id="kategorilingkupDanNominalSponsor-chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between" style="margin-bottom: 50px;">
                            <p class="card-title">Jenis Kegiatan dan Jumlah Sponsor</p>
                        </div>
                        <canvas id="kategorilingkupDanNominalSponsor-chart-pie"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">PIC Sponsorship</p>
                            <select name="" class="form-control select-user-bar" required="required">
                            </select>
                        </div>
                        <div class="table-responsive mb-3 mb-md-0 mt-3" style="margin-top: 30px;">
                            <table class="table table-borderless report-table" id="picSponsorship"></table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Total Sponsor yang Diprakasai oleh Pekerja</p>
                            <select name="" class="form-control select-user" required="required">
                            </select>
                        </div>
                        <div style="width: 700px;padding: 0;margin: auto;display: block;"><canvas id="totalpicSponsorship-chart-pie" style="margin-top:45px"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Total Sponsor Masing Masing PIC</p>
                        </div>
                        <div style="width: 600px;"><canvas id="jumlahSponsorperPIC"></canvas></div>
                        <div id="jumlahSponsorperPIC-legend"></div>
                        <div class="table-responsive" style="margin-top: 20px;">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr id="table-head">
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>

<script>
    function httpGet(theUrl) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", theUrl, false); // false for synchronous request
        xmlHttp.send(null);
        return xmlHttp.responseText;
    }

    var colorArray = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
    ];

    function PieChart(id, data) {
        var label = [];
        var jml = [];
        data.forEach(function(item) {
            label.push(item['name']);
            jml.push(item['y']);
        });
        // var areaData = {
        //     labels: label,
        //     datasets: [{
        //         data: jml,
        //         backgroundColor: colorArray,
        //         borderColor: "rgba(0,0,0,0)"
        //     }]
        // };
        // var areaOptions = {
        //     responsive: true,
        // maintainAspectRatio: true,
        // segmentShowStroke: false,
        // cutoutPercentage: 78,
        // elements: {
        //     arc: {
        //         borderWidth: 4
        //     }
        // },
        //     legend: {
        //         display: false
        //     },
        // tooltips: {
        //     enabled: true
        // },
        //     legendCallback: function(chart) {
        //         var text = [];
        //         for (var i = 0; i < chart.data.labels.length; i++) {
        //             text.push('<div style="display: table;">');
        //             text.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[i] + '"></div></div>');
        //             text.push('<div style="display: table-cell;">&emsp;' + chart.data.labels[i] + '</div>');
        //             text.push('<div style="display: table-cell;">&emsp;' + chart.data.datasets[0].data[i] + '</div>');
        //             text.push('</div>');
        //         }
        //         return text.join("");
        //     },
        // }

        var pieChartPlugins = {
            beforeDraw: function(chart) {
                var totalPie = 0;
                for (var z = 0; z < chart.data.datasets[0].data.length; z++) {
                    totalPie = totalPie + parseInt(chart.data.datasets[0].data[z]);
                }

                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = 3.125;
                ctx.font = "500 " + fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#13381B";

                var text = totalPie.toString(),
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
        var pieChartCanvas = $("#" + id + "-chart-pie").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: {
                labels: label,
                datasets: [{
                    data: jml,
                    backgroundColor: colorArray,
                    borderColor: "rgba(0,0,0,0)"
                }]
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                maintainAspectRatio: true,
                segmentShowStroke: false,
                // cutoutPercentage: 78,
                elements: {
                    arc: {
                        borderWidth: 4
                    }
                },
                tooltips: {
                    enabled: true
                },
                legend: {
                    position: 'bottom',
                },
            },
            // plugins: pieChartPlugins
        });
        // document.getElementById(id + '-legend-pie').innerHTML = pieChart.generateLegend();
    }

    var bagian1 = httpGet("<?= base_url('home/sponsorship_json?status=bagian-1') ?>");
    bagian1 = JSON.parse(bagian1);
    var kategoriDanJumlahSponsor = bagian1.kategoriDanJumlahSponsor;
    var categories_kategoriDanJumlahSponsor = Object.keys(kategoriDanJumlahSponsor);
    var data_kategoriDanJumlahSponsor = Object.values(kategoriDanJumlahSponsor);
    var result_kategoriDanJumlahSponsor = (data_kategoriDanJumlahSponsor).map(temp => parseInt(temp));

    var kategoriDanJumlahSponsorCancel = bagian1.kategoriDanJumlahSponsorCancel;
    var data_kategoriDanJumlahSponsorCancel = Object.values(kategoriDanJumlahSponsorCancel);
    var result_kategoriDanJumlahSponsorCancel = (data_kategoriDanJumlahSponsorCancel).map(temp => parseInt(temp));

    var datakategoriDanJumlahSponsor = [];
    for (var i in categories_kategoriDanJumlahSponsor) {

        var temp = {
            name: categories_kategoriDanJumlahSponsor[i],
            y: result_kategoriDanJumlahSponsor[i]
        }
        if (result_kategoriDanJumlahSponsor[i] != 0) datakategoriDanJumlahSponsor.push(temp);
    }

    var kategoriDanNominalSponsor = bagian1.kategoriDanNominalSponsor;
    var categories_kategoriDanNominalSponsor = Object.keys(kategoriDanNominalSponsor);
    var data_kategoriDanNominalSponsor = Object.values(kategoriDanNominalSponsor);
    var result_kategoriDanNominalSponsor = (data_kategoriDanNominalSponsor).map(temp => parseInt(temp));

    var datakategoriDanNominalSponsor = [];
    for (var i in categories_kategoriDanNominalSponsor) {

        var temp = {
            name: categories_kategoriDanNominalSponsor[i],
            y: result_kategoriDanNominalSponsor[i]
        }
        if (result_kategoriDanNominalSponsor[i] != 0) datakategoriDanNominalSponsor.push(temp);
    }


    var kategorilingkupDanNominalSponsor = bagian1.kategorilingkupDanNominalSponsor;
    var categories_kategorilingkupDanNominalSponsor = Object.keys(kategorilingkupDanNominalSponsor);

    for (var cat of categories_kategorilingkupDanNominalSponsor) {
        $(".select-kategorilingkupDanNominalSponsor").append(new Option(cat, cat))
    }

    generateChart_kategorilingkupDanNominalSponsor(categories_kategorilingkupDanNominalSponsor[0]);

    function generateChart_kategorilingkupDanNominalSponsor(vals) {

        var categories_kategorilingkupDanNominalSponsor = Object.keys(kategorilingkupDanNominalSponsor[vals]);
        var data_kategorilingkupDanNominalSponsor = Object.values(kategorilingkupDanNominalSponsor[vals]);
        var result_kategorilingkupDanNominalSponsor = (data_kategorilingkupDanNominalSponsor).map(temp => parseInt(temp));

        var datakategorilingkupDanNominalSponsor = [];
        for (var i in categories_kategorilingkupDanNominalSponsor) {
            var temp = {
                name: categories_kategorilingkupDanNominalSponsor[i],
                y: result_kategorilingkupDanNominalSponsor[i]
            }
            datakategorilingkupDanNominalSponsor.push(temp);
        }

        PieChart('kategorilingkupDanNominalSponsor', datakategorilingkupDanNominalSponsor);

        var labels = [];
        var totals = [];
        datakategorilingkupDanNominalSponsor.forEach(function(item) {
            labels.push(item['name']);
            totals.push(item['y']);
        });

        var kategorilingkupDanNominalSponsorChartCanvas = $("#kategorilingkupDanNominalSponsor-chart").get(0).getContext("2d");
        var kategorilingkupDanNominalSponsorChart = new Chart(kategorilingkupDanNominalSponsorChartCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: totals,
                    backgroundColor: colorArray,
                }]
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
                            max: totals.length,
                            autoSkip: true,
                            maxTicksLimit: 10,
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
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            },
        });

    }

    $(".select-kategorilingkupDanNominalSponsor").on("change", function() {
        generateChart_kategorilingkupDanNominalSponsor(this.value)
    });

    // ==============================================================================

    for (var i = 0; i < Object.keys(categories_kategoriDanJumlahSponsor).length; i++) {
        var count = Object.values(result_kategoriDanJumlahSponsor)[i] / Object.keys(categories_kategoriDanJumlahSponsor).length * 100
        $('#kategori-jumlah-sponsor').append(
            '<tr>' +
            '<td class="text-muted">' + Object.values(categories_kategoriDanJumlahSponsor)[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="background-color:#7cb5ec;width: ' + count + '%">' +
            '</div>' +
            '</div>' +

            '<div class="progress progress-md mx-4" style="visibility:hidden">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="background-color:#7cb5ec;width: ' + count + '%">' +
            '</div>' +
            '</div>' +

            '</td>' +
            '<td>' +
            Object.values(result_kategoriDanJumlahSponsor)[i] +
            '<br><span style="visibility:hidden">' +
            Object.values(result_kategoriDanJumlahSponsor)[i] +
            '</span></td>' +
            '</tr>'
        );
    }

    for (var i = 0; i < Object.keys(categories_kategoriDanJumlahSponsor).length; i++) {
        var countSponsor = Object.values(result_kategoriDanJumlahSponsor)[i] / Object.keys(categories_kategoriDanJumlahSponsor).length * 100
        var countCancel = Object.values(result_kategoriDanJumlahSponsorCancel)[i] / Object.keys(categories_kategoriDanJumlahSponsor).length * 100
        $('#kategoriDanJumlahSponsorCancel').append(
            '<tr>' +
            '<td class="text-muted">' + Object.values(categories_kategoriDanJumlahSponsor)[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="width: ' + countSponsor + '%;background-color:#7cb5ec">' +
            '</div>' +
            '</div>' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-dark" role="progressbar" style="width: ' + countCancel + '%;background-color:black">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            Object.values(result_kategoriDanJumlahSponsor)[i] +
            '<br>' +
            Object.values(result_kategoriDanJumlahSponsorCancel)[i] +
            '</td>' +
            '</tr>'
        );
    }

    // =====================================================================

    function PieChart2(id, data) {
        var label = [];
        var jml = [];
        data.forEach(function(item) {
            label.push(item['name']);
            jml.push(item['y']);
        });
        var pieChartCanvas = $("#" + id + "-chart-pie").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: {
                datasets: [{
                    data: jml,
                    backgroundColor: colorArray,
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: label
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    var bagianlogo = httpGet("<?= base_url('home/sponsorship_json?status=bagian_logo') ?>");
    bagianlogo = JSON.parse(bagianlogo)
    var logoDannominalsponsor = bagianlogo.logoDannominalsponsor;
    var categories_logoDannominalsponsor = Object.keys(logoDannominalsponsor);
    var data_logoDannominalsponsor = Object.values(logoDannominalsponsor);
    var result_logoDannominalsponsor = (data_logoDannominalsponsor).map(temp => parseInt(temp));

    var pie_data_logoDannominalsponsor = [];
    for (var i in categories_logoDannominalsponsor) {
        var temp = {
            name: categories_logoDannominalsponsor[i],
            y: result_logoDannominalsponsor[i]
        }
        pie_data_logoDannominalsponsor.push(temp);
    }

    PieChart2('logoDannominalsponsor', pie_data_logoDannominalsponsor);

    for (var i = 0; i < categories_logoDannominalsponsor.length; i++) {
        var count = result_logoDannominalsponsor[i] / categories_logoDannominalsponsor.length * 100
        $('#logoDannominalsponsor').append(
            '<tr>' +
            '<td class="text-muted">' + categories_logoDannominalsponsor[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar" role="progressbar" style="width: ' + count + '%;background-color:' + colorArray[i] + '">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            result_logoDannominalsponsor[i] +
            '</td>' +
            '</tr>'
        );
    }

    // =====================================================================

    function PieChart3(id, data) {
        var label = [];
        var jml = [];
        data.forEach(function(item) {
            label.push(item['name']);
            jml.push(item['y']);
        });
        var pieChartCanvas = $("#" + id + "-chart-pie").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: {
                datasets: [{
                    data: jml,
                    backgroundColor: colorArray,
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: label
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    var bagian2 = httpGet("<?= base_url('home/sponsorship_json?status=bagian-2') ?>");
    bagian2 = JSON.parse(bagian2)
    var kantorDanNominalSponsor = bagian2.kantorDanNominalSponsor;
    var categories_kantorDanNominalSponsor = Object.keys(kantorDanNominalSponsor);
    var data_kantorDanNominalSponsor = Object.values(kantorDanNominalSponsor);
    var result_kantorDanNominalSponsor = (data_kantorDanNominalSponsor).map(temp => parseInt(temp));
    var datakantorDanNominalSponsor = [];
    for (var i in categories_kantorDanNominalSponsor) {

        var temp = {
            name: categories_kantorDanNominalSponsor[i],
            y: result_kantorDanNominalSponsor[i]
        }
        if (result_kantorDanNominalSponsor[i] != 0) datakantorDanNominalSponsor.push(temp);
    }

    var bagian3 = httpGet("<?= base_url('home/sponsorship_json?status=bagian-3') ?>");
    bagian3 = JSON.parse(bagian3)
    var picDanJumlahSponsor = bagian3.picDanJumlahSponsor;
    var picDanJumlahSponsorall = bagian3.picDanJumlahSponsorall;
    var categories_picDanJumlahSponsor = Object.keys(picDanJumlahSponsor);
    var categories_picDanJumlahSponsorall = Object.keys(picDanJumlahSponsorall);
    for (var user of categories_picDanJumlahSponsor) {
        $(".select-user").append(new Option(user, user))
    }

    for (var userall of categories_picDanJumlahSponsorall) {
        $(".select-user-bar").append(new Option(userall, userall))
    }

    $(".select-user").on("change", function() {
        generateChart_picTotalSponsor(this.value)
    });

    $(".select-user-bar").on("change", function() {
        generatebarchart_picsponsorship(this.value)
    });

    function generateChart_picTotalSponsor(user) {
        var categories_picDanJumlahSponsor = Object.keys(picDanJumlahSponsor[user]);
        var data_picDanJumlahSponsor = Object.values(picDanJumlahSponsor[user]);
        var result_picDanJumlahSponsor = (data_picDanJumlahSponsor).map(temp => parseInt(temp));

        var datapicDanJumlahSponsor = [];
        for (var i in categories_picDanJumlahSponsor) {

            var temp = {
                name: categories_picDanJumlahSponsor[i],
                y: result_picDanJumlahSponsor[i]
            }
            datapicDanJumlahSponsor.push(temp);

        }

        PieChart3('totalpicSponsorship', datapicDanJumlahSponsor);
    }
    generateChart_picTotalSponsor(categories_picDanJumlahSponsor[0]);

    function generatebarchart_picsponsorship(user) {
        let categories_picDanJumlahSponsor = Object.keys(picDanJumlahSponsorall[user]);
        let data_picDanJumlahSponsor = Object.values(picDanJumlahSponsorall[user]);
        let result_picDanJumlahSponsor = (data_picDanJumlahSponsor).map(temp => parseInt(temp));
        $('#picSponsorship').empty();
        for (var i = 0; i < categories_picDanJumlahSponsor.length; i++) {
            var count = result_picDanJumlahSponsor[i] / categories_picDanJumlahSponsor.length * 100
            $('#picSponsorship').append(
                '<tr>' +
                '<td class="text-muted">' + categories_picDanJumlahSponsor[i] +
                '</td>' +
                '<td class="w-100 px-0">' +
                '<div class="progress progress-md mx-4">' +
                '<div class="progress-bar" role="progressbar" style="width: ' + count + '%;background-color:' + colorArray[i] + '">' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                result_picDanJumlahSponsor[i] +
                '</td>' +
                '</tr>'
            );
        }
    }

    generatebarchart_picsponsorship(categories_picDanJumlahSponsorall[0]);

    for (var i = 0; i < categories_kantorDanNominalSponsor.length; i++) {
        var count = result_kantorDanNominalSponsor[i] / categories_kantorDanNominalSponsor.length * 100
        $('#kantorDanNominalSponsor').append(
            '<tr>' +
            '<td class="text-muted">' + categories_kantorDanNominalSponsor[i] +
            '</td>' +
            '<td class="w-100 px-0">' +
            '<div class="progress progress-md mx-4">' +
            '<div class="progress-bar bg-primary" role="progressbar" style="width: ' + count + '%;">' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            result_kantorDanNominalSponsor[i] +
            '</td>' +
            '</tr>'
        );
    }

    var labelskategoriDanNominalSponsor = [];
    var totalskategoriDanNominalSponsor = [];
    var totals = 0;
    for (var i = 0; i < categories_kategoriDanNominalSponsor.length; i++) {
        labelskategoriDanNominalSponsor.push(categories_kategoriDanNominalSponsor[i]);
        totalskategoriDanNominalSponsor.push(result_kategoriDanNominalSponsor[i]);
        totals += result_kategoriDanNominalSponsor[i];
    }

    var kategoriDanNominalSponsorChartCanvas = $("#kategoriDanNominalSponsor-chart").get(0).getContext("2d");
    var kategoriDanNominalSponsorChart = new Chart(kategoriDanNominalSponsorChartCanvas, {
        type: 'horizontalBar',
        data: {
            labels: labelskategoriDanNominalSponsor,
            datasets: [{
                data: totalskategoriDanNominalSponsor,
                backgroundColor: "#7cb5ec",
            }]
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

                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: totals,
                        autoSkip: true,
                        fontColor: "#6C7383",
                        callback: function(value, index, ticks) {
                            return convertToInternationalCurrencySystem(value);
                        }
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });

    PieChartlabel('pie-kategoriDanJumlahSponsor', datakategoriDanJumlahSponsor);
    PieChartlabel('pie-kategoriDanNominalSponsor', datakategoriDanNominalSponsor);
    PieChartlabel('pie-kantorDanNominalSponsor', datakantorDanNominalSponsor);

    function PieChartlabel(id, data) {
        var label = [];
        var jml = [];
        data.forEach(function(item) {
            label.push(item['name']);
            jml.push(item['y']);
        });
        var pieChartCanvas = $("#" + id).get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: {
                datasets: [{
                    data: jml,
                    backgroundColor: colorArray,
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: label
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    var jumlahSponsorperPicName = [];
    var jumlahSponsorperPicDatasets = [];
    for (var x = 0; x < bagian3.jsonPicSponsorTotal.length; x++) {
        jumlahSponsorperPicName.push(bagian3.jsonPicSponsorTotal[x]['name']);
        jumlahSponsorperPicDatasets.push({
            data: bagian3.jsonPicSponsorTotal[x]['data'],
            backgroundColor: colorArray[x]
        });
    }

    var jumlahSponsorperPICChartCanvas = $("#jumlahSponsorperPIC").get(0).getContext("2d");
    var jumlahSponsorperPICChart = new Chart(jumlahSponsorperPICChartCanvas, {
        type: 'horizontalBar',
        data: {
            labels: Object.values(bagian3.kategori),
            datasets: jumlahSponsorperPicDatasets
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
                        fontColor: "#6C7383",
                    },

                }],
                xAxes: [{
                    stacked: false,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: totals,
                        autoSkip: true,
                        fontColor: "#6C7383",
                        callback: function(value, index, ticks) {
                            return convertToInternationalCurrencySystem(value);
                        }
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                        display: false
                    },
                    barPercentage: 1,
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        },
    });

    var jumlahSponsorperPIClegend = [];
    for (var i = 0; i < jumlahSponsorperPicName.length; i++) {
        jumlahSponsorperPIClegend.push('<div style="display: table;margin: 10px auto">');
        jumlahSponsorperPIClegend.push('<div style="display: table-cell;"><div class="mr-3" style="width:10px; height:10px; border-radius: 50%; background-color: ' + colorArray[i] + '"></div></div>');
        jumlahSponsorperPIClegend.push('<div style="display: table-cell;">&emsp;' + jumlahSponsorperPicName[i] + '</div>');
        jumlahSponsorperPIClegend.push('</div>');
    }
    document.getElementById('jumlahSponsorperPIC-legend').innerHTML = jumlahSponsorperPIClegend.join("");

    function installtable() {

        for (user of Object.values(bagian3.user)) {
            $("#table-head").append(`<th>${user}</th>`)
        }

        var i = 0;
        for (kategori of Object.values(bagian3.kategori)) {
            var html = `<tr>
                    <td>${kategori}</td>`;
            var j = 0;
            for (user of Object.values(bagian3.user)) {
                html += `<td>${convertToRupiah(bagian3.jsonPicSponsorTotal[j].data[i])}</td>`
                j++
            }

            html += `</tr>`
            $("#table-body").append(html)
            i++

        }
    }
    installtable();

    function convertToInternationalCurrencySystem(num) {

        if (num > 999 && num < 1000000) {
            return (num / 1000).toFixed(0) + 'K'; // convert to K for number from > 1000 < 1 million 
        } else if (num > 1000000) {
            return (num / 1000000).toFixed(0) + 'M'; // convert to M for number from > 1 million 
        } else if (num < 900) {
            return num; // if value < 1000, nothing to do
        }

    }

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }
</script>