<?php
require 'connect.php';
session_start();
if(isset($_POST['tanggal']) && isset($_POST['hkerja']) && isset($_POST['prdk']) && isset($_POST['sikap']) && $_POST['catatan'])
{
	$date = $_POST['tanggal'];
	$hkerja = $_POST['hkerja'];
	$prvitas = $_POST['prdk'];
	$sikap = $_POST['sikap'];
	$catatan = $_POST['catatan'];

	$nip = $_GET['nipscoring'];
	$penilai = $_SESSION['nip'];

	$query = "INSERT INTO feedback(tanggal, nip_penilai, nip_sub, hasil_kerja, produktivitas, sikap, catatan) ". 
				"VALUES ('$date',$penilai,$nip,$hkerja,$prvitas,$sikap,'$catatan')";
				
	$result = mysqli_query($conn,$query);
	mysqli_close($conn);
	header("Location: http://localhost/stark/feedback.php");
}
else{
	header("Location: http://localhost/stark/feedback.php");
}

?>