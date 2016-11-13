<?php
// menggunakan class phpExcelReader
error_reporting(0);
ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
mysql_connect("localhost", "root", "");
mysql_select_db("excelie");
//include the following 2 files
require 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';
$userfile = $_FILES['userfile']['tmp_name'];
$namefile = $_FILES["userfile"]["name"];
$typefile = strtolower(pathinfo($namefile,PATHINFO_EXTENSION));
if ($typefile == "xlsx") $objReader = new PHPExcel_Reader_Excel2007();
else if ($typefile == "xls") $objReader = new PHPExcel_Reader_Excel5();
else die('Error: Yang Anda Upload bukan extensi `.xls` atau `.xlsx`<br /><br /><button type="button" onclick="location.href=\'index.php\';">Kembali halaman awal</button>');
$objReader->setReadDataOnly(true);
$objReader->setLoadSheetsOnly( array("Sheet1") );
$objPHPExcel = $objReader->load($userfile);
$objSheet = $objPHPExcel->getActiveSheet();
$highestRow=$objSheet->getHighestRow();
$highestColumn  = $objSheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
for ($row = 0; $row <= $highestRow-2; ++ $row) {
	$val=array();
	 
	for ($col = 0; $col < $highestColumnIndex; ++ $col) {
	   $cell = $objSheet->getCellByColumnAndRow($col, $row);
	   $val[] = $cell->getValue();
	}

	// membaca data (kolom ke-1)
	if(!empty($val[0])) {
		$telp = '0' . $val[0];
		$found = mysql_num_rows(mysql_query("SELECT idtelpnumber FROM telpnumber WHERE telpnumber = '".$telp."'"));
		if ($found == 0) {
			$hasil = mysql_query("
				INSERT INTO telpnumber(telpnumber) VALUES('".$telp."')
			") or die('Error Insert Data TN: ' . mysql_error());
		}
		if($hasil) {
			$sukses++;
		} else {
			$gagal++;
			$notegagal = $notegagal . ', ' . $telp;
		}
	}
}
// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."<br>";
echo "Data yg gagal No.Akun: ".$notegagal."</p>";
?><br />
<button type="button" onclick="location.href='index.php';">Kembali halaman awal</button>