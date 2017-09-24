<?php
require 'connect.php';	
require '../tools/pdf/fpdf.php';

$nipprint = $_GET['nip'];
$month = $_POST['bulan'];
$year = $_POST['tahun'];
$query = "select karyawan.nama,jumlah from karyawan,gaji ".
			"where karyawan.nip = gaji.nip and ".
			"month(gaji.bulan) = $month and ".
			"year(gaji.bulan) = $year and ".
			"gaji.nip = $nipprint";
			
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_row($result);

$objpdf = new FPDF('L','mm','A5');
$objpdf->addPage();
$objpdf->SetFont("Arial","B","12");
$objpdf->Image('C:\wamp\www\stark\tools\pdf\logo.png',10,6,75);
$objpdf->Cell(80,10,'',0,1,"L");
$objpdf->Cell(80,10,'',0,1,"L");
$objpdf->Cell(40,10,'NIP  :'.$nipprint,0,1,"L");
$objpdf->Cell(40,10,'Nama :'.$row[0],0,1,"L");
$objpdf->Cell(40,10,'Bulan:'.$month,0,1,"L");
$objpdf->Cell(40,10,'Tahun:'.$year,0,1,"L");
$objpdf->Cell(40,10,'Gaji :Rp.'.number_format($row[1]),0,1,"L");


$objpdf->Output("Slip_".$nipprint."_".$month."_".$year.".pdf","D");
?>