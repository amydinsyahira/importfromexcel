<?php
error_reporting(0);
ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
// koneksi ke mysql
mysql_connect("localhost", "root", "prayan17");
mysql_select_db("excelie");
if($_GET['id'] == 'download') {
	$no = $_GET['no'];
	$start = $_GET['start'];
	$total = $_GET['total'];
	// nama file
	$namaFile = gmdate("YmdHis", time()+60*60*7). "_" . $no . "_" . $start . "_" . $total . "_number.xls";

	// Function penanda awal file (Begin Of File) Excel
	function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	return;
	}

	// Function penanda akhir file (End Of File) Excel
	function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
	return;
	}

	// Function untuk menulis data (angka) ke cell excel
	function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
	return;
	}

	// Function untuk menulis data (text) ke cell excel
	function xlsWriteLabel($Row, $Col, $Value ) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
	return;
	}

	// header file excel
	header("Content-type: Application/x-msdownload");
	header("Content-type: Application/exe");
	header("Content-Transfer-Encoding: binary");
	// header untuk nama file
	header("Content-Disposition: attachment; filename=".$namaFile."");
	header("Pragma: no-cache");
	header("Expires: 0");

	// memanggil function penanda awal file excel
	xlsBOF();

	// ------ membuat kolom pada excel --- //
	// mengisi pada cell A1 (baris ke-0, kolom ke-0)
	//xlsWriteLabel(0,0,"No");

	// -------- menampilkan data --------- //
	$query = "SELECT * FROM telpnumber ORDER BY idtelpnumber ASC LIMIT ".$start.", ".$total."";
	$hasil = mysql_query($query) or die('MySql Error' . mysql_error());

	// nilai awal untuk baris cell
	$noBarisCell = 0;
	while ($data = mysql_fetch_array($hasil))
	{
	   // menampilkan data nim
	   xlsWriteNumber($noBarisCell,0,$data['idtelpnumber']);
	   // menampilkan data nim
	   xlsWriteLabel($noBarisCell,1,$data['telpnumber']);
	   $noBarisCell++;
	}

	// memanggil function penanda akhir file excel
	xlsEOF();
	exit();
}
?>
<h1>Import</h1>

<form method="post" enctype="multipart/form-data" action="proses.php" onsubmit="document.getElementById('upload').disabled = true;">
Silakan Pilih File Excel: <input name="userfile" id="userfile" type="file">
<input name="upload" id="upload" type="submit" value="Import">
<button type="button" onclick="location.href='index.php';">Segarkan</button>
</form><br />
<h1>Export</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
Silakan Masukkan Jumlah Nomer HP Tiap File: <input name="jmlhhp" type="text">
<input name="submit" type="submit" value="Filter">
</form>
<?php
if($_POST['submit']) {
	echo '<div style="width: 400px; height: 385px; border: 1px solid black;overflow: auto;">';
	$ttl = mysql_num_rows(mysql_query("SELECT idtelpnumber FROM telpnumber ORDER BY idtelpnumber ASC"));
	$rslt = $ttl / $_POST['jmlhhp'];
	$num = 0; $contain = 0;
	echo '<table width="100%" border="1"><tr align="center"><th width="15%">No</th><th>Range</th><th>Aksi</th></tr>';
	for ($i=0; $i < $rslt; $i++) { 
		$num++;
		echo '
		<tr align="center">
			<td>'.$num.'</td>
			<td>'.$contain.' - '.$_POST['jmlhhp'].'</td>
			<td><a href="index.php?id=download&no='.$num.'&start='.$contain.'&total='.$_POST['jmlhhp'].'" target="_blank">Export</a></td>
		</tr>';
		$contain = $contain + $_POST['jmlhhp'];
	}
	echo '</table>';
	echo '</div>';
}
die();
exit();
break;
?>