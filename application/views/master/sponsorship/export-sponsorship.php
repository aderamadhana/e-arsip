<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data sponsorship.xls");
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
				<th>No</th>
				<th>Nama Kegiatan</th>
				<th>Tanggal Pelaksanaan</th>
				<th>Kategori Kegiatan</th>
				<th>Lingkup Kegiatan</th>
				<th>PIC</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$no=1;
				foreach ($sponsorship as $key => &$valsponsorship) {
					$datapic = json_decode($valsponsorship['pic']);
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
					<td><?= $valsponsorship['nama_kegiatan'];?></td>
					<td><?= $valsponsorship['tanggal'];?></td>
					<td><?= $valsponsorship['klasifikasi_nama'];?></td>
					<td><?= $valsponsorship['lingkup_nama'];?></td>
					<td><?= $text?></td>
					<td><?= ($valsponsorship['informasi_pembayaran']=="Sudah Bayar")?"Lengkap":"Belum Lengkap"?></td>
				</tr>
			<?php $no++; }?>
		</tbody>
	</table>
</body>
</html>