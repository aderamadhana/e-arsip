<style>
	.text-white{
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
</style>
<script src="<?= base_url('assets/dist/js/chartjs-plugin-colorschemes.min.js') ?>"></script>
<div class="content-wrapper">
	<section class="content">
	
		<?php if (in_array($this->session->userdata('role_slug'),['super_admin','kepala_divisi','kepala_departemen','sekretaris_divisi'])){ ?>
    		<div class="row">
    			<div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Jumlah Sponsor </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="kategori-jumlah-sponsor"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Jumlah Sponsor <br> Cancel dan Diberikan </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="kategoriDanJumlahSponsorCancel"></div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="row">
                <div class="col-lg-12 col-xs-12">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kantor Wilayah + KCK :  <br> Kategori dan Nominal Sponsor </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="kantorDanNominalSponsor"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-12 col-xs-12">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Nominal Sponsor </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="kategoriDanNominalSponsor"></div>
    					</div>
    				</div>
    			</div>

                <div class="col-lg-4 col-xs-4">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Jumlah Sponsor </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="pie-kategoriDanJumlahSponsor"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-4 col-xs-4">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Nominal Sponsor </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="pie-kategoriDanNominalSponsor"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-4 col-xs-4">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kantor Wilayah + KCK </b><br>Kategori dan Nominal Sponsor </h4>
    					</div>
    					<div class="box-body">
    						<div id="pie-kantorDanNominalSponsor"></div>
    					</div>
    				</div>
    			</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xs-6">
                    <div class="box box-success">
                        <div class="box-header">
                            <h4><b>Pencantuman Logo dan Jumlah Sponsor Diberikan</b></h4>
                        </div>
                        <div class="box-body">
                            <div id="logoDannominalsponsor"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-6">
                    <div class="box box-success">
                        <div class="box-header">
                            <h4><b>Pencantuman Logo dan Jumlah</b></h4>
                        </div>
                        <div class="box-body">
                            <div id="pie-logoDannominalsponsor"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>Jenis Kegiatan dan Jumlah Sponsor</b></h4>
                            
                            <select name="" class="form-control select-kategorilingkupDanNominalSponsor" required="required">
                                
                            </select>
                            
    					</div>
    					<div class="box-body">
    						<div id="kategorilingkupDanNominalSponsor"></div>
    					</div>
    				</div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>Jenis Kegiatan dan Jumlah Sponsor</b></h4>
                            <br> <br>
                            <!-- <select name="" id="" class="form-control select-kategorilingkupDanNominalSponsor" required="required">
                                
                            </select> -->
                            
    					</div>
    					<div class="box-body">
    						<div id="pie-kategorilingkupDanNominalSponsor"></div>
    					</div>
    				</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>PIC Sponsorship</b></h4>
                            <select name="" class="form-control select-user-bar" required="required">    
                            </select>
    					</div>
    					<div class="box-body">
    						<div id="picSponsorship"></div>
    					</div>
    				</div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>Total Sponsor yang Diprakasai oleh Pekerja</b></h4>
                            <select name="" class="form-control select-user" required="required">    
                            </select>
    					</div>
    					<div class="box-body">
    						<div id="pie-totalpicSponsorship"></div>
    					</div>
    				</div>
                </div>

                <div class="col-md-12">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>Total Sponsor Masing Masing PIC</b></h4>
                          
    					</div>
    					<div class="box-body">
    						<div id="jumlahSponsorperPIC"></div>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover table-bordered">
                                    <thead>
                                        <tr id="table-head" style="background:#f3f3f3">
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
</div>

<script>    

function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}


function PieChart(id,data){

    Highcharts.chart(id, {
        //colors: ["#74b9ff", "#a29bfe", "#ff7675"],
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
            labelFormatter: function () {
                return this.name + ' ('+this.y+')';
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: data
        }],
        
    });
}


let bagian1 = httpGet("<?= base_url('home/sponsorship_json?status=bagian-1') ?>");
bagian1 = JSON.parse(bagian1)

let kategoriDanJumlahSponsor = bagian1.kategoriDanJumlahSponsor;
let categories_kategoriDanJumlahSponsor = Object.keys(kategoriDanJumlahSponsor);
let data_kategoriDanJumlahSponsor = Object.values(kategoriDanJumlahSponsor);
let result_kategoriDanJumlahSponsor = (data_kategoriDanJumlahSponsor).map(temp =>  parseInt(temp));


let kategoriDanJumlahSponsorCancel = bagian1.kategoriDanJumlahSponsorCancel;
let data_kategoriDanJumlahSponsorCancel = Object.values(kategoriDanJumlahSponsorCancel);
let result_kategoriDanJumlahSponsorCancel = (data_kategoriDanJumlahSponsorCancel).map(temp =>  parseInt(temp));




let datakategoriDanJumlahSponsor = []; 
for(let i in categories_kategoriDanJumlahSponsor){
   
    let temp = {
        name : categories_kategoriDanJumlahSponsor[i],
        y : result_kategoriDanJumlahSponsor[i]
    }
    if(result_kategoriDanJumlahSponsor[i] != 0) datakategoriDanJumlahSponsor.push( temp );
}



let kategoriDanNominalSponsor = bagian1.kategoriDanNominalSponsor;
let categories_kategoriDanNominalSponsor = Object.keys(kategoriDanNominalSponsor);
let data_kategoriDanNominalSponsor = Object.values(kategoriDanNominalSponsor);
let result_kategoriDanNominalSponsor = (data_kategoriDanNominalSponsor).map(temp => parseInt(temp));

let datakategoriDanNominalSponsor = []; 
for(let i in categories_kategoriDanNominalSponsor){
   
    let temp = {
        name : categories_kategoriDanNominalSponsor[i],
        y : result_kategoriDanNominalSponsor[i]
    }
    if(result_kategoriDanNominalSponsor[i] != 0) datakategoriDanNominalSponsor.push( temp );
    // alert(categories_kategoriDanNominalSponsor[i]);
}


let kategorilingkupDanNominalSponsor = bagian1.kategorilingkupDanNominalSponsor;
let categories_kategorilingkupDanNominalSponsor = Object.keys(kategorilingkupDanNominalSponsor);

for(let cat of categories_kategorilingkupDanNominalSponsor){
    $(".select-kategorilingkupDanNominalSponsor").append(new Option(cat, cat))
}

generateChart_kategorilingkupDanNominalSponsor(categories_kategorilingkupDanNominalSponsor[0])

function generateChart_kategorilingkupDanNominalSponsor(vals){
    
    let categories_kategorilingkupDanNominalSponsor = Object.keys(kategorilingkupDanNominalSponsor[vals]);
    let data_kategorilingkupDanNominalSponsor = Object.values(kategorilingkupDanNominalSponsor[vals]);
    let result_kategorilingkupDanNominalSponsor = (data_kategorilingkupDanNominalSponsor).map(temp => parseInt(temp));
    
    let datakategorilingkupDanNominalSponsor = []; 
    for(let i in categories_kategorilingkupDanNominalSponsor){
    
        let temp = {
            name : categories_kategorilingkupDanNominalSponsor[i],
            y : result_kategorilingkupDanNominalSponsor[i]
        }
       datakategorilingkupDanNominalSponsor.push( temp );

    }

    PieChart('pie-kategorilingkupDanNominalSponsor',datakategorilingkupDanNominalSponsor)
    
    Highcharts.chart('kategorilingkupDanNominalSponsor', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        
        xAxis: {
            categories: categories_kategorilingkupDanNominalSponsor,
            crosshair: true
        },
        yAxis: {
            min: 0,
            tickInterval: 1,
            title: {
                text: 'Nominal Sponsor'
            }
        },
        tooltip: {
            headerFormat: `<span style="font-size:10px">{point.key}</span><table>`,
            pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                            <td style="padding:0"><b> {point.y} </b></td></tr>`,
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: 
            [
                {
                    name : "Nominal Sponsor Diberikan",
                    data : datakategorilingkupDanNominalSponsor
                }
            
            ]
        
    });
    
}

$(".select-kategorilingkupDanNominalSponsor").on("change",function(){
    generateChart_kategorilingkupDanNominalSponsor(this.value)
});



// ========================================================================== logo dan jumlah sponsor
let bagianlogo = httpGet("<?= base_url('home/sponsorship_json?status=bagian_logo') ?>");
bagianlogo = JSON.parse(bagianlogo)
let logoDannominalsponsor = bagianlogo.logoDannominalsponsor;
let categories_logoDannominalsponsor = Object.keys(logoDannominalsponsor);
let data_logoDannominalsponsor = Object.values(logoDannominalsponsor);
let result_logoDannominalsponsor = (data_logoDannominalsponsor).map(temp => parseInt(temp));
Highcharts.chart('logoDannominalsponsor', {
    // colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: categories_logoDannominalsponsor,
        // crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Nominal Sponsor'
        }
    },
    tooltip: {
        headerFormat: `<span style="font-size:10px">{point.key}</span><table>`,
        pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                        <td style="padding:0"><b> {point.y} </b></td></tr>`,
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: 
        [
            {
                name : "Nominal Sponsor Diberikan",
                data : result_logoDannominalsponsor
            }
           
        ]
    
});

let pie_data_logoDannominalsponsor = []; 
for(let i in categories_logoDannominalsponsor){

    let temp = {
        name : categories_logoDannominalsponsor[i],
        y : result_logoDannominalsponsor[i]
    }
   pie_data_logoDannominalsponsor.push( temp );

}
PieChart('pie-logoDannominalsponsor',pie_data_logoDannominalsponsor)


// ==========================================================================

let bagian2 = httpGet("<?= base_url('home/sponsorship_json?status=bagian-2') ?>");
bagian2 = JSON.parse(bagian2)
let kantorDanNominalSponsor = bagian2.kantorDanNominalSponsor;
let categories_kantorDanNominalSponsor = Object.keys(kantorDanNominalSponsor);
let data_kantorDanNominalSponsor = Object.values(kantorDanNominalSponsor);

let result_kantorDanNominalSponsor = (data_kantorDanNominalSponsor).map(temp =>  parseInt(temp));


let datakantorDanNominalSponsor = []; 
for(let i in categories_kantorDanNominalSponsor){
   
    let temp = {
        name : categories_kantorDanNominalSponsor[i],
        y : result_kantorDanNominalSponsor[i]
    }
    if(result_kantorDanNominalSponsor[i] != 0) datakantorDanNominalSponsor.push( temp );
}



// ==========================================================================
let bagian3 = httpGet("<?= base_url('home/sponsorship_json?status=bagian-3') ?>");
bagian3 = JSON.parse(bagian3)


let picDanJumlahSponsor = bagian3.picDanJumlahSponsor;
let picDanJumlahSponsorall = bagian3.picDanJumlahSponsorall;
let categories_picDanJumlahSponsor = Object.keys(picDanJumlahSponsor);
let categories_picDanJumlahSponsorall = Object.keys(picDanJumlahSponsorall);

// let picSponsorTotalPic = bagian3.picSponsorTotalPic;
// let categories_picSponsorTotalPic = Object.keys(picSponsorTotalPic);


for(let user of categories_picDanJumlahSponsor){
    $(".select-user").append(new Option(user, user))
    // $(".select-user-bar").append(new Option(user, user))
}

for(let userall of categories_picDanJumlahSponsorall){
    $(".select-user-bar").append(new Option(userall, userall))
}

$(".select-user").on("change",function(){

    generateChart_picTotalSponsor(this.value)

});

$(".select-user-bar").on("change",function(){

    generatebarchart_picsponsorship(this.value)

});

function generateChart_picTotalSponsor(user){
    let categories_picDanJumlahSponsor = Object.keys(picDanJumlahSponsor[user]);
    let data_picDanJumlahSponsor = Object.values(picDanJumlahSponsor[user]);
    let result_picDanJumlahSponsor = (data_picDanJumlahSponsor).map(temp => parseInt(temp));
    
    let datapicDanJumlahSponsor = []; 
    for(let i in categories_picDanJumlahSponsor){
    
        let temp = {
            name : categories_picDanJumlahSponsor[i],
            y : result_picDanJumlahSponsor[i]
        }
       datapicDanJumlahSponsor.push( temp );

    }

    PieChart('pie-totalpicSponsorship',datapicDanJumlahSponsor)

}

generateChart_picTotalSponsor(categories_picDanJumlahSponsor[0])

function generatebarchart_picsponsorship(user) {
    let categories_picDanJumlahSponsor = Object.keys(picDanJumlahSponsorall[user]);
    let data_picDanJumlahSponsor = Object.values(picDanJumlahSponsorall[user]);
    let result_picDanJumlahSponsor = (data_picDanJumlahSponsor).map(temp => parseInt(temp));
    const colors = ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675","#55efc4", "#f7a35c",];
    let datapicDanJumlahSponsor = []; 
    for(let i in categories_picDanJumlahSponsor){

        let temp = {
            name : categories_picDanJumlahSponsor[i],
            y : result_picDanJumlahSponsor[i],
            color: colors[i]
        }
       datapicDanJumlahSponsor.push( temp );

    }
    Highcharts.chart('picSponsorship', {
        // colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        
        xAxis: {
            categories: categories_picDanJumlahSponsor,
            crosshair: true
        },
        yAxis: {
            min: 0,
            tickInterval: 1,
            title: {
                text: 'Jumlah Surat'
            }
        },
        tooltip: {
            headerFormat: `<span style="font-size:10px">{point.key}</span><table>`,
            pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                            <td style="padding:0"><b> {point.y} </b></td></tr>`,
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: 
            [
                {
                    name : "Jumlah",
                    data : datapicDanJumlahSponsor
                }
               
            ]
        
    });
    // Highcharts.chart('picSponsorship', {
    //     colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    //     chart: {
    //         type: 'bar'
    //     },
    //     title: {
    //         text: ''
    //     },
        
    //     xAxis: {
    //         categories: Object.values(bagian3.user),
    //         crosshair: true
    //     },
    //     yAxis: {
    //         min: 0,
    //         tickInterval: 1,
    //         title: {
    //             text: 'Jumlah Surat'
    //         }
    //     },
    //     tooltip: {
    //         headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    //         pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
    //             '<td style="padding:0"><b>{point.y} Sponsorship</b></td></tr>',
    //         footerFormat: '</table>',
    //         shared: true,
    //         useHTML: true
    //     },
    //     plotOptions: {
    //         column: {
    //             pointPadding: 0.2,
    //             borderWidth: 0
    //         }
    //     },
    //     series: bagian3.jsonPicSponsor
        
    // });
}

generatebarchart_picsponsorship(categories_picDanJumlahSponsorall[0])




Highcharts.chart('kategori-jumlah-sponsor', {
	// colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: categories_kategoriDanJumlahSponsor,
        crosshair: true
    },
    yAxis: {
        min: 0,
        tickInterval: 1,
        title: {
            text: 'Jumlah Sponsor'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Jumlah Sponsor</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: 
        [
            {
                name : "Jumlah Sponsor Diberikan",
                data : result_kategoriDanJumlahSponsor
            }
           
        ]
    
});


Highcharts.chart('kategoriDanJumlahSponsorCancel', {
	// colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: categories_kategoriDanJumlahSponsor,
        crosshair: true
    },
    yAxis: {
        min: 0,
        tickInterval: 1,
        title: {
            text: 'Jumlah Sponsor'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Jumlah Sponsor</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: 
        [
            {
                name : "Jumlah Sponsor",
                data : result_kategoriDanJumlahSponsor
            },{
                name : "Jumlah Cancel",
                data : result_kategoriDanJumlahSponsorCancel

            }
           
        ]
    
});

Highcharts.chart('kantorDanNominalSponsor', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: categories_kantorDanNominalSponsor,
        // crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Nominal Sponsor'
        }
    },
    tooltip: {
        headerFormat: `<span style="font-size:10px">{point.key}</span><table>`,
        pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                        <td style="padding:0"><b> {point.y} </b></td></tr>`,
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: 
        [
            {
                name : "Jumlah Sponsor Diberikan",
                data : result_kantorDanNominalSponsor
            }
           
        ]
    
});


Highcharts.chart('kategoriDanNominalSponsor', {
	// colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: categories_kategoriDanNominalSponsor,
        // crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Nominal Sponsor'
        }
    },
    tooltip: {
        headerFormat: `<span style="font-size:10px">{point.key}</span><table>`,
        pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                        <td style="padding:0"><b> {point.y} </b></td></tr>`,
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: 
        [
            {
                name : "Nominal Sponsor Diberikan",
                data : result_kategoriDanNominalSponsor
            }
           
        ]
    
});


Highcharts.chart('jumlahSponsorperPIC', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: Object.values(bagian3.kategori)
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nominal Sponsor'
        }
    },
    tooltip: {
        headerFormat: `<span style="font-size:10px">{point.key}</span><table>`,
        pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                        <td style="padding:0"><b> {point.y} </b></td></tr>`,
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: bagian3.jsonPicSponsorTotal
});



PieChart('pie-kategoriDanJumlahSponsor',datakategoriDanJumlahSponsor)
PieChartlabel('pie-kategoriDanNominalSponsor',datakategoriDanNominalSponsor)
PieChartlabel('pie-kantorDanNominalSponsor',datakantorDanNominalSponsor)


function PieChartlabel(id,data){

    Highcharts.chart(id, {
        //colors: ["#74b9ff", "#a29bfe", "#ff7675"],
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
            labelFormatter: function () {
                return this.name + ' ('+convertToRupiah(this.y)+')';
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: data
        }],
        
    });
}


function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}

function installtable(){

    for(user of Object.values(bagian3.user)){
        $("#table-head").append(`<th>${user}</th>`)
    }

    let i = 0;
    for(kategori of Object.values(bagian3.kategori)){
        let html = `<tr>
                        <td>${kategori}</td>`;
        let j = 0;
        for(user of Object.values(bagian3.user)){
            html += `<td>${convertToRupiah(bagian3.jsonPicSponsorTotal[j].data[i])}</td>`
            j++
        }

        html += `</tr>`
        $("#table-body").append(html)
        i++
            
    }
}
installtable();

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}


</script>