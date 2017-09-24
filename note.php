<!DOCTYPE HTML>
<html>
<title>Catatan</title>
<head>
<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
<script src="bootstrap/js/tests/vendor/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href=""> Salary System </a>
		</div>
		<div>
			<ul class="nav navbar-nav">
				<li><a href="dashboard.php">Pengawasan</a></li>
				<li class="active"><a href="feedback.php">Feedback</a></li>
				<li><a href="salary.php">Penggajian</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"><strong>
					<span class="glyphicon glyphicon-user"></span>
					<?php
						require 'php/connect.php';
						
						session_start();
						echo $_SESSION['user'];
					?></strong>
					<ul class="dropdown-menu">
					  <li><a href="#">Settings</a></li>
					  <li><a href="php/logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<br><br><br><br>
<?php
$query = "select karyawan.nip,karyawan.nama,departemen.nama_dep,karyawan.jabatan,karyawan.gaji_pokok from karyawan,departemen ".
			"where nip = ".$_GET['nip']." and departemen.id_dep = karyawan.id_dep";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_row($result);

?>
<div class="row" id="note">
<div class="col-md-4">
	<div class="panel panel-info">
		<div class="panel-heading"><?php echo $row[1];?></div>
		<div class="panel-body">
			<p><strong>NIP			</strong>:<?php echo $row[0];?></P>
			<p><strong>Departemen	</strong>:<?php echo $row[2];?></P>
			<p><strong>Jabatan		</strong>:<?php echo $row[3];?></P>
			<p><strong>Gaji pokok	</strong>:Rp. <?php echo number_format($row[4]);?></P>
		</div>
    </div>
</div>
<div class="col-md-8">
<?php
$query = "select karyawan.nama,feedback.catatan,feedback.tanggal from feedback,karyawan ".
			"where feedback.nip_sub = ".$_GET['nip']." and karyawan.nip = feedback.nip_penilai ".
			"order by feedback.tanggal desc";
			
$result = mysqli_query($conn,$query);
while($row = mysqli_fetch_row($result)){
	?>
	<p><strong><?php echo date('d-m-Y',strtotime($row[2]));?></strong>&nbsp &nbsp <?php echo $row[0];?></p>
	<div class="panel panel-info">
		<div class="panel-body"><?php echo $row[1];?></div>
	</div>
	<?php
}
mysqli_close($conn);
?>
</div>
</div>
</body>
</html>