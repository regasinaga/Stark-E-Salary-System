<?php
require 'connect.php';
$user = '';
$pass = '';

if(isset($_POST['login'])){
	$user = $_POST['username'];
	$pass = $_POST['password'];
	
	$query = "select nip,username,password from user ".
					"where username='$user' and password='$pass'";
	$result = mysqli_query($conn,$query);
	$num = mysqli_num_rows($result);
	
	if ($num == 1){
		$row = mysqli_fetch_row($result);
		$nip = $row[0];
		$query2 = "select id_dep,jabatan from karyawan where nip = '$nip'";
		
		$res2 = mysqli_query($conn,$query2);
		$rowr = mysqli_fetch_row($res2);
		
		header("Location: "."http://localhost/stark/dashboard.php");
		session_start();
		
		$_SESSION['nip'] = $nip;
		$_SESSION['user'] = $user;
		$_SESSION['dep'] = $rowr[0];
		$_SESSION['jabatan'] = $rowr[1];
	}
	else{
		header("Location: "."http://localhost/stark/index.php?login=fail");
	}
	mysqli_close();
}


?>