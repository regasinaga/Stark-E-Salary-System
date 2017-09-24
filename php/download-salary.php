<?php
require 'connect.php';
require '../tools/excel/PHPExcel.php';
require 'calculatefromscore.php';
require 'calculatefromlog.php';

session_start();

$nip_penilai = $_SESSION['nip'];

//create new excel object
$sheet1 = new PHPExcel();
//this is active sheet
$activesheet = $sheet1->setActiveSheetIndex(0);

$month = $_POST['bulan'];//numerical,01-12
$year = $_POST['tahun'];//numerical,2014-2016

//filename string
$filename = "penggajian_".$month."_".$year;
//query to check whether selected month salary exists or not 
$query = "select * from gaji ".
			"where month(bulan) = $month and year(bulan) = $year and ".
			"gaji.nip in (select distinct nip_sub from feedback where nip_penilai = $nip_penilai)";
			
$result = mysqli_query($conn,$query);
$row = mysqli_num_rows($result);

//if selected month salary is not exist
if($row == 0){
	
	$jabatan = $_SESSION['jabatan'];
	$dep = $_SESSION['dep'];
	$sub = "";
	
	//if user is Kepala Staf
	if(strcmp($jabatan,"Kepala Staf")){
		$sub = "Staf";
	}
	//if user is Manajer
	else if(strcmp($jabatan,"Manajer")){
		$sub = "Kepala Staf";
	}
	//if user is Direktur
	else if(strcmp($jabatan,"Direktur")){
		$sub = "Manajer";
	}
	
	$query = "select nip,gaji_pokok from karyawan where id_dep = $dep and jabatan = '$sub'";
	
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_row($result)){
		
		//calculate salary based on feedback for each nip
		$query_2 = "SELECT avg(hasil_kerja),avg(produktivitas),avg(sikap) from feedback ".
					"where nip_sub = '$row[0]' and YEAR(tanggal) = $year and MONTH(tanggal) = $month";
					
		$resultcalc1 = mysqli_query($conn,$query_2);
		$rowcal1 = mysqli_fetch_row($resultcalc1);
		$salaryscorecalc = calculatefromscore($rowcal1[0],$rowcal1[1],$rowcal1[2]);
		
		//calculate salary based on presence log for each nip
		$query_3 = "select count(waktu) from log_presensi ".
					"where nip = $row[0] and status = 1 and YEAR(waktu) = $year and MONTH(waktu) = $month";
		$resultcalc2 = mysqli_query($conn,$query_3);
		$rowcal2 = mysqli_fetch_row($resultcalc2);
		$salarylogcalc = calculatefromlog($rowcal2[0],$month,$year);
		
		//get salary
		$salaryreal = (($salaryscorecalc + $salarylogcalc)/2)*$row[1];
		$queryins = "INSERT INTO gaji(bulan, nip, jumlah) VALUES ('$year-$month-01',$row[0],$salaryreal)";
		mysqli_query($conn,$queryins);
	}
}
$query = "select gaji.nip,karyawan.nama,jumlah from gaji,karyawan ".
			"where gaji.nip = karyawan.nip and month(bulan) = $month";


$header_arr = array('NIP','Nama','Gaji');
$result = mysqli_query($conn,$query);

$j = 0;
//set table header
for($i='A';$i<='C';$i++){
	$activesheet->setCellValue($i.'1',$header_arr[$j]);
	$j++;
}

$countr = 2;
while($row = mysqli_fetch_row($result)){
	$activesheet->setCellValue('A'.$countr,$row[0]);
	$activesheet->setCellValue('B'.$countr,$row[1]);
	$activesheet->setCellValue('C'.$countr,"Rp.".number_format($row[2]));
	$countr++;
}

for($i = 'A';$i <= 'C';$i++){
	$sheet1->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
}
$objWriter = PHPExcel_IOFactory::createWriter($sheet1, 'Excel2007');
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=Laporan_'.$filename.'.xlsx');
$objWriter->save('php://output');
?>