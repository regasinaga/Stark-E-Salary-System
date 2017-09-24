<?php
require 'connect.php';
require '../tools/excel/PHPExcel.php';
session_start();

$sheet1 = new PHPExcel();
$actives = $sheet1->setActiveSheetIndex(0);
$id_dep = $_SESSION['dep'];
$month = $_POST['bulan'];
$year = $_POST['tahun'];
$filename = "feedback_".$month."_".$year;
$query = "SELECT tanggal,karyawan.nip, karyawan.nama, hasil_kerja,produktivitas, sikap, catatan,". 
			"(select nama from karyawan where karyawan.nip = feedback.nip_penilai) as penilai ". 
			"from feedback,karyawan where karyawan.nip = feedback.nip_sub and ".
			"month(tanggal)=$month and year(tanggal)=$year and ".
			"karyawan.id_dep = $id_dep order by tanggal desc";
$header_arr = array('NIP','Nama','Penilai','Tanggal penilaian','Hasil kerja','Produktivitas','Sikap','Catatan');
			
$result = mysqli_query($conn,$query);
echo $query;

$j = 0;
//set table header
for($i='A';$i<='H';$i++){
	$actives->setCellValue($i.'1',$header_arr[$j]);
	$j++;
}

$countr = 2;
while($row = mysqli_fetch_row($result)){
	$actives->setCellValue('A'.$countr,$row[1]);
	$actives->setCellValue('B'.$countr,$row[2]);
	$actives->setCellValue('C'.$countr,$row[7]);
	$actives->setCellValue('D'.$countr,$row[0]);
	$actives->setCellValue('E'.$countr,$row[3]);
	$actives->setCellValue('F'.$countr,$row[4]);
	$actives->setCellValue('G'.$countr,$row[5]);
	$actives->setCellValue('H'.$countr,$row[6]);
	$countr++;
}

for($i = 'A';$i <= 'H';$i++){
	$sheet1->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
}
$objWriter = PHPExcel_IOFactory::createWriter($sheet1, 'Excel2007');
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=Laporan_'.$filename.'.xlsx');
$objWriter->save('php://output'); 
?>