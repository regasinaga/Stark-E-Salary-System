<!DOCTYPE HTML>
<?php
require 'php/connect.php';
require 'php/log_trend.php';
require 'php/feedback_trend.php';
include 'tools/chart/lib/inc/chartphp_dist.php';

session_start();

$nip = $_GET['nip'];
$nama = $_GET['nama'];

$chart = new chartphp();
$view = $_GET['view'];

if($view == 'presence'){
	$data = getLogTrend($nip);
	$dropd = "Presensi";
	$chart->data = array($data);
}
else{
	$data = getFeedbackTrend($nip);
	$dropd = "Feedback";
	$chart->data = $data;
	$chart->color = "#ff5c33,#3399ff,#4dff4d";
}


$chart->chart_type = "bar";

$chart->title = $dropd." ".$nama." ".date("Y");
$chart->ylabel = "Per bulan";

$output = $chart->render('c1');
?>
<html>
<title>Welcome</title>
<head>
<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
<script src="bootstrap/js/tests/vendor/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<script src="tools/chart/lib/js/chartphp.js"></script>
<link rel="stylesheet" href="tools/chart/lib/js/chartphp.css">
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
				<li class="active"><a href="dashboard.php">Pengawasan</a></li>
				<li><a href="feedback.php">Feedback</a></li>
				<li><a href="salary.php">Penggajian</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"><strong>
					<span class="glyphicon glyphicon-user"></span>
					<?php
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
<div class="row">
<div class="col-md-8">
</div>
<div class="dropdown col-md-4">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $dropd; ?>
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
		<li><a href="tren.php?nama=<?php echo $nama;?>&nip=<?php echo $nip;?>&view=presence">Presensi</a></li>
		<li><a href="tren.php?nama=<?php echo $nama;?>&nip=<?php echo $nip;?>&view=feedback">Feedback</a></li>
    </ul>
</div>
</div>

<br><br>
<div id="presensi">
<?php
echo $output;
?>
</div>
<br><br><br>
<?php
if($dropd=='Feedback'){
	?>
	<div id="feedback-legend">
	<div class="row">
		<p><span style="background-color:#ff5c33;width:30px;">&nbsp &nbsp &nbsp </span> &nbsp &nbsp Hasil kerja</p>
		<p><span style="background-color:#3399ff;width:30px;">&nbsp &nbsp &nbsp </span> &nbsp &nbsp Produktivitas</p>
		<p><span style="background-color:#4dff4d;width:30px;">&nbsp &nbsp &nbsp </span> &nbsp &nbsp Sikap</p>
	</div>
	</div>
	<?php
}
?>
</body>
</html>