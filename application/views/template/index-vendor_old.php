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
    						<h4><b>Kategori dan Jumlah konsultan </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="KategoriDanJumlahKonsultan"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4>Kategori dan Jumlah Vendor</h4>
    					</div>
    					<div class="box-body">
    						<div id="KategoriDanJumlahVendor"></div>

    					</div>
    				</div>
    			</div>
    		</div>
            <div class="row">
    			<div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Jumlah Konsultan <br> Acc / Cancel </b></h4>
    					</div>
    					<div class="box-body">
                            <div id="KategoriDanJumlahKonsultanCancel"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4>Kategori dan Jumlah Vendor <br> Acc / Cancel </h4>
    					</div>
    					<div class="box-body">
                            <div id="KategoriDanJumlahVendorCancel"></div>
    					</div>
    				</div>
    			</div>
    		</div>
            <div class="row">
    			<div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Penilaian Konsultan </b></h4>
    					</div>
    					<div class="box-body">
                            <div id="penilaianKonsultan"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4>Penilaian Vendor </h4>
    					</div>
    					<div class="box-body" >
                            <div id="penilaianVendor"></div>
    					</div>
    				</div>
    			</div>
    		</div>
            <div class="row">
    			<div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4><b>Kategori dan Nominal konsultan </b></h4>
    					</div>
    					<div class="box-body">
    						<div id="KategoriDanNominalKonsultan"></div>
    					</div>
    				</div>
    			</div>
                <div class="col-lg-6 col-xs-6">
    				<div class="box box-success">
    					<div class="box-header">
    						<h4>Kategori dan Nominal Vendor</h4>
    					</div>
    					<div class="box-body">
    						<div id="KategoriDanNominalVendor"></div>

    					</div>
    				</div>
    			</div>
    		</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>PIC Konsultan dan Vendor</b></h4>
                            
                            
    					</div>
    					<div class="box-body">
    						<div id="picKonsultandanVendor"></div>
    					</div>
    				</div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>Total PIC Sesuai Nama User</b></h4>
                            <select name="" class="form-control select-user" required="required">
                                
                                </select>
                                
                            
    					</div>
    					<div class="box-body">
    						<div id="pie-picKonsultandanVendorbyUser"></div>
    					</div>
    				</div>
                </div>

                <div class="col-md-12">
                    <div class="box box-success">
    					<div class="box-header">
    						<h4><b>Jumlah Vendor / Konsultan <br>per PIC</b></h4>
                          
    					</div>
    					<div class="box-body">
    						<div id="picKonsultandanVendorbyUserTotal"></div>
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

let bagian1 = httpGet("<?= base_url('home/vendor_json?status=bagian-1') ?>");
bagian1 = JSON.parse(bagian1)


/**
 * Row 1
 * 
 */


 /**
 * Chart 1
 * 
 */

let KategoriDanJumlahKonsultan = bagian1.kategoriDanJumlahKonsultanVendor.consultant
let key1 = Object.keys(KategoriDanJumlahKonsultan);
let data1 = Object.values(KategoriDanJumlahKonsultan);
let result1 = (data1).map(temp =>  parseInt(temp));

let data_KategoriDanJumlahKonsultan = []; 
for(let i in key1){
    let temp = {
        name : key1[i],
        y : result1[i]
    }
     data_KategoriDanJumlahKonsultan.push( temp );
}



Highcharts.chart('KategoriDanJumlahKonsultan', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: key1,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Jumlah Konsultan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Jumlah Konsultan</b></td></tr>',
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
        [{
            name : "Jumlah Konsultan Diberikan",
            data : data_KategoriDanJumlahKonsultan
        }]
});



let KategoriDanJumlahVendor = bagian1.kategoriDanJumlahKonsultanVendor.vendor
let key2 = Object.keys(KategoriDanJumlahVendor);
let data2 = Object.values(KategoriDanJumlahVendor);
let result2 = (data2).map(temp =>  parseInt(temp));

let data_KategoriDanJumlahVendor = []; 
for(let i in key2){
   
    let temp = {
        name : key2[i],
        y : result2[i]
    }
    data_KategoriDanJumlahVendor.push( temp );
}

Highcharts.chart('KategoriDanJumlahVendor', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: key2,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Jumlah Vendor'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Jumlah Vendor</b></td></tr>',
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
        [{
            name : "Jumlah Vendor Diberikan",
            data : data_KategoriDanJumlahVendor
        }]
});

/**
 * Row 1
 * 
 */



 /**
 * Row 2
 * 
 */


let KategoriDanJumlahKonsultanCancel = bagian1.kategoriDanJumlahKonsultanVendorCancel.consultant
let key3 = Object.keys(KategoriDanJumlahKonsultanCancel);
let data3 = Object.values(KategoriDanJumlahKonsultanCancel);
let result3 = (data3).map(temp =>  parseInt(temp));

let data_KategoriDanJumlahKonsultanCancel = []; 
for(let i in key3){
    let temp = {
        name : key3[i],
        y : result3[i]
    }
     data_KategoriDanJumlahKonsultanCancel.push( temp );
}



Highcharts.chart('KategoriDanJumlahKonsultanCancel', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: key1,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Jumlah Konsultan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Jumlah Konsultan</b></td></tr>',
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
        [{
            name : "Jumlah Konsultan",
            data : data_KategoriDanJumlahKonsultan
        },{
            name : "Jumlah Konsultan Cancel",
            data : data_KategoriDanJumlahKonsultanCancel
        }]
});



let KategoriDanJumlahVendorCancel = bagian1.kategoriDanJumlahKonsultanVendorCancel.vendor
let key4 = Object.keys(KategoriDanJumlahVendorCancel);
let data4 = Object.values(KategoriDanJumlahVendorCancel);
let result4 = (data4).map(temp =>  parseInt(temp));

let data_KategoriDanJumlahVendorCancel = []; 
for(let i in key4){
   
    let temp = {
        name : key4[i],
        y : result4[i]
    }
    data_KategoriDanJumlahVendorCancel.push( temp );
}

Highcharts.chart('KategoriDanJumlahVendorCancel', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: key4,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Jumlah Vendor'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Jumlah Vendor</b></td></tr>',
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
        [{
            name : "Jumlah Vendor ",
            data : data_KategoriDanJumlahVendor
        },{
            name : "Jumlah Vendor Cancel",
            data : data_KategoriDanJumlahVendorCancel
        }]
});

 /**
 * Row 2
 * 
 */


  /**
 * Row 3
 * 
 */

let penilaianKonsultan = bagian1.kategoriDanJumlahKonsultanVendorStatus.consultant
let penilaianVendor = bagian1.kategoriDanJumlahKonsultanVendorStatus.vendor

let key7 = Object.keys(penilaianKonsultan);

let datapenilaianKonsultan = []; 
let iterasi = 0;
let category = []
for(let i of key7){
        let cat = Object.keys(penilaianKonsultan[i]);
        let val = Object.values(penilaianKonsultan[i]);
        if(iterasi==0) category = cat

        let valuesData = {
                name : i,
                data : (val).map(temp =>parseInt(temp))
        }
        datapenilaianKonsultan.push(valuesData)  
        iterasi++;
}


Highcharts.chart('penilaianKonsultan', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: category,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Penilaian'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Penilaian</b></td></tr>',
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
    series: datapenilaianKonsultan
});



let key8 = Object.keys(penilaianVendor);

let datapenilaianVendor = []; 
let iterasi1 = 0;
let category1 = []
for(let i of key8){
        let cat = Object.keys(penilaianVendor[i]);
        let val = Object.values(penilaianVendor[i]);
        if(iterasi1==0) category1 = cat

        let valuesData = {
                name : i,
                data : (val).map(temp =>parseInt(temp))
        }
        datapenilaianVendor.push(valuesData)  
        iterasi1++;
}


Highcharts.chart('penilaianVendor', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: category1,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Penilaian'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Penilaian</b></td></tr>',
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
    series: datapenilaianVendor
});




 /**
 * Row 3
 * 
 */

  /**
 * Row 4
 * 
 */


 /**
 * Chart 1
 * 
 */

let KategoriDanNominalKonsultan = bagian1.kategoriDanNominalKonsultanVendor.consultant
let key9 = Object.keys(KategoriDanNominalKonsultan);
let data9 = Object.values(KategoriDanNominalKonsultan);
let result9 = (data9).map(temp =>  parseInt(temp));

let data_KategoriDanNominalKonsultan = []; 
for(let i in key9){
    let temp = {
        name : key9[i],
        y : result9[i]
    }
     data_KategoriDanNominalKonsultan.push( temp );
}



Highcharts.chart('KategoriDanNominalKonsultan', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: key9,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Nominal Konsultan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}  Nominal Konsultan</b></td></tr>',
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
        [{
            name : "Nominal Konsultan",
            data : data_KategoriDanNominalKonsultan
        }]
});



let KategoriDanNominalVendor = bagian1.kategoriDanNominalKonsultanVendor.vendor
let key10 = Object.keys(KategoriDanNominalVendor);
let data10 = Object.values(KategoriDanNominalVendor);
let result10 = (data10).map(temp =>  parseInt(temp));

let data_KategoriDanNominalVendor = []; 
for(let i in key10){
   
    let temp = {
        name : key10[i],
        y : result10[i]
    }
    data_KategoriDanNominalVendor.push( temp );
}

Highcharts.chart('KategoriDanNominalVendor', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: key10,
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Nominal Vendor'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}  Nominal Vendor "</b></td></tr>',
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
        [{
            name : "Nominal Vendor",
            data : data_KategoriDanNominalVendor
        }]
});

 /**
 * Row 4
 * 
 */


  /**
 * Row 5
 * 
 */


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



// let picKonsultandanVendor = bagian1.picKonsultandanVendor;
// let categories_picKonsultandanVendor = Object.keys(picKonsultandanVendor);

let picKonsultandanVendorbyUser = bagian1.picKonsultandanVendorbyUser;
let categories_picKonsultandanVendorbyUser = Object.keys(picKonsultandanVendorbyUser);

// let picKonsultandanVendorbyUserTotal = bagian1.picKonsultandanVendorbyUserTotal;
// let categories_picKonsultandanVendorbyUserTotal = Object.keys(picKonsultandanVendorbyUserTotal);



for(let user of categories_picKonsultandanVendorbyUser){
    $(".select-user").append(new Option(user, user))
}

$(".select-user").on("change",function(){

    generateChart_picTotalSponsor(this.value)

});

generateChart_picTotalSponsor(categories_picKonsultandanVendorbyUser[0])
function generateChart_picTotalSponsor(user){
    let categories_picKonsultandanVendorbyUser = Object.keys(picKonsultandanVendorbyUser[user]);
    let data_picKonsultandanVendorbyUser = Object.values(picKonsultandanVendorbyUser[user]);
    let result_picKonsultandanVendorbyUser = (data_picKonsultandanVendorbyUser).map(temp => parseInt(temp));
    
    let datapicKonsultandanVendorbyUser = []; 
    for(let i in categories_picKonsultandanVendorbyUser){
    
        let temp = {
            name : categories_picKonsultandanVendorbyUser[i],
            y : result_picKonsultandanVendorbyUser[i]
        }
       datapicKonsultandanVendorbyUser.push( temp );

    }

    PieChart('pie-picKonsultandanVendorbyUser',datapicKonsultandanVendorbyUser)

}





// let datapicKonsultandanVendor = []; 
// for(let i of categories_picKonsultandanVendor){

//         let cat = Object.keys(picKonsultandanVendor[i]);
//         let val = Object.values(picKonsultandanVendor[i]);
//         for(let j of cat){
//             let valsSponsor = [];
//             for(let k of categories_picKonsultandanVendor){
//                 valsSponsor.push(parseInt(picKonsultandanVendorbyUser[j][k]))
//             }
//             let valuesData = {
//                 name : j,
//                 data : valsSponsor
//             }
//             datapicKonsultandanVendor.push(valuesData)   
//         }
    
// }


Highcharts.chart('picKonsultandanVendor', {
	// colors: ["#55efc4", "#f7a35c", "#74b9ff", "#a29bfe", "#ff7675"],
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    
    xAxis: {
        categories: Object.values(bagian1.user),
        crosshair: true
    },
    yAxis: {
        min: 0,
        // tickInterval: 1,
        title: {
            text: 'Jumlah Surat'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Sponsorship</b></td></tr>',
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
    series: bagian1.JsonpicKonsultandanVendor
    
});






// let datapicKonsultandanVendorbyUserTotal = []; 
// for(let i of categories_picKonsultandanVendorbyUserTotal){

//         let cat = Object.keys(picKonsultandanVendorbyUserTotal[i]);
//         let val = Object.values(picKonsultandanVendorbyUserTotal[i]);
        
//         let valsSponsor = [];
      
//         for(let j of cat){
//             valsSponsor.push(parseInt(picKonsultandanVendorbyUserTotal[i][j]))
             
//         }

//         let valuesData = {
//                 name : i,
//                 data : valsSponsor
//         }
//         datapicKonsultandanVendorbyUserTotal.push(valuesData)  
    
// }



Highcharts.chart('picKonsultandanVendorbyUserTotal', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: Object.values(bagian1.kategori)
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
                        <td style="padding:0"><b> {point.y}  </b></td></tr>`,
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
    series: bagian1.JsonpicKonsultandanVendorbyUserTotal
});



  /**
 * Row 5
 * 
 */




function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}

function installtable(){

    for(user of Object.values(bagian1.user)){
        $("#table-head").append(`<th>${user}</th>`)
    }

    let i = 0;
    for(kategori of Object.values(bagian1.kategori)){
        let html = `<tr>
                        <td>${kategori}</td>`;
        let j = 0;
        for(user of Object.values(bagian1.user)){
            html += `<td>${convertToRupiah(bagian1.JsonpicKonsultandanVendorbyUserTotal[j].data[i])}</td>`
            j++
        }

        html += `</tr>`
        $("#table-body").append(html)
        i++
            
    }
}
installtable()



</script>