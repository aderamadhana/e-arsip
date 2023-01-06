<?php
$nama_file = 'excel_surat_masuk';
if(@$_GET['tipe']){
	$nama_file.= '/'.$_GET['tipe'];
}else{
	$nama_file.= '/'.$_GET['status'];
}

	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$nama_file.".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<table class="table-custom" border="1">
	<tr style="background: #ddd;">
		<td>
			Nomor Surat
		</td>
		<td>
			Tanggal Surat
		</td>
		<td>
			Tanggal Surat Diterima
		</td>
		<td>
			Tipe Surat
		</td>
		<td>
			Instansi Pengirim
		</td>
		<td>
			Sifat Surat
		</td>
		<td>
			Bentuk Dokumen
		</td>
		<td>
			Kategori Surat
		</td>
		<td>
			Perihal
		</td>
	</tr>
	<?php
		foreach($data_surat as $data):
			$this->db->select('GROUP_CONCAT(add_nama_departement) as departement');
			$this->db->where('add_id_arsip_dokumen',$data['ad_id']);
			$kategori_surat = $this->db->get('arsip_dokumen_departement')->row()->departement;
	?>
		<tr>	
			<td><?= $data['ad_nomorsurat'] ?></td>
			<td><?= $data['ad_tanggalsurat'] ?></td>
			<td><?= $data['ad_tanggalsuratditerima'] ?></td>
			<td><?= $data['ad_tipesurat'] ?></td>
			<td><?= $data['ad_instansipengirim'] ?></td>
			<td><?= $data['ad_sifatsurat'] ?></td>
			<td><?= $data['ad_bentukdokumen'] ?></td>
			<td><?= $kategori_surat ?></td>
			<td><?= $data['ad_perihal'] ?></td>
		</tr>	
	<?php 
		endforeach;
	?>
</table>