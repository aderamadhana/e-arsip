<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data vendor.xls");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Export data vendor</title>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Nama Kegiatan</th>
				<th colspan="3">Vendor</th>
				<th colspan="2">Tanggal Pelaksanaan</th>
				<th rowspan="2">Penjelasan Singkat</th>
				<th rowspan="2">Nilai Jasa Vendor/Konsultan</th>
				<th rowspan="2">PIC</th>
				<th rowspan="2">Status</th>
			</tr>
			<tr>
				<th>Nama Vendor</th>
				<th>PIC Vendor/Konsultan</th>
				<th>No HP PIC Vendor/Konsultan</th>
				<th>Tanggal Mulai</th>
				<th>Tanggal Selesai</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$no=1;
				foreach ($vendor as $key => &$valvendor) {
					$datapic = json_decode($valvendor['pic']);
					$text = "";
					foreach ($datapic as $key => &$valpic) {
						$user = $this->mymodel->selectDataone('user',['id'=>$valpic]);
						if (count($datapic)==$key+1) {
							$text .= $user['name'];
						}else{
							$text .= $user['name'].',<br>';
						}
					}
			?>
				<tr>
					<td><?= $no;?></td>
					<td><?= $valvendor['nama_kegiatan'] ?></td>
					<td><?= $valvendor['nama'] ?></td>
					<td><?= $valvendor['pic_vendor'] ?></td>
					<td><?= $valvendor['pic_nomor_vendor'] ?></td>
					<td><?= $valvendor['tanggal'] ?></td>
					<td><?= $valvendor['tanggal_selesai'] ?></td>
					<td><?= number_format($valvendor['nilai_jasa'] , 0, ',', '.'); ?></td>
					<td><?= $text?></td>
					<td><?= ($valvendor['is_kegiatan_terlaksana']==1)?"Terlaksana":"Tidak Terlaksana" ?></td>
				</tr>
			<?php $no++; }?>
		</tbody>
	</table>
</body>
</html>