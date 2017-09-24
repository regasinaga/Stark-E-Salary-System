<!DOCTYPE HTML>
<html>
<title>Welcome</title>
<head>
<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
<script src="bootstrap/js/tests/vendor/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/date/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script>
$(document).ready(function(){
	var today = new Date();
	var m = ((today.getMonth()+1)<10)?"0":"";
	var d = ((today.getDate()+1)<10)?"0":"";
	var formatted = (today.getYear()+2000-100)+"-"+m+(today.getMonth()+1)+"-"+d+today.getDate();

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight:true
	});
	$('.datepicker').val(formatted);
});
</script>
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
				<li class="active"><a href="#">Feedback</a></li>
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
<div class="row">
<div class="col-md-6">
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#download" style="margin-left:21%">Unduh laporan</button>

<!-- Modal -->
<div id="download" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form action="php/download-feedback.php" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Unduh Laporan Feedback</h4>
      </div>
      <div class="modal-body">
		<div class="col-md-6">
			<label for="hs">Bulan:</label>
				<select class="form-control" id="month" name="bulan">
					<option value="01">Januari</option>
					<option value="02">Februari</option><option value="02">Maret</option>
					<option value="04">April</option>
					<option value="05">Mei</option><option value="06">Juni</option>
					<option value="07">Juli</option><option value="08">Agustus</option>
					<option value="09">September</option><option value="10">Oktober</option>
					<option value="11">November</option><option value="12">Desember</option>
				</select>
		</div>
		<div class="col-md-6">
			<label for="hs">Tahun:</label>
				<select class="form-control" id="year" name="tahun">
					<option value="2014">2014</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
				</select>
		</div>
      </div>
	  <br><br><br>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Unduh</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
	  </form>
    </div>

  </div>
</div>
</div>
<div class="col-md-6">
<div style="width:200px;margin-left:auto;margin-right:130px;">
    <form action="feedback.php" class="search-form" method="get">
        <div class="form-group has-feedback">
      		<label for="cari" class="sr-only">Cari</label>
           		<input type="text" class="form-control" name="cari" id="search" placeholder="Cari berdasar nama">
           		<span class="glyphicon glyphicon-search form-control-feedback"></span>
       	</div>
    </form>
</div>
</div>
</div>
<div class="table-container">
	<table class="table table-striped">
    <thead>
      <tr class="success">
		<th width="10%">NIP</th>
        <th width="30%">Nama</th>
        <th width="15%"></th>
        <th>       </th>
      </tr>
    </thead>
    <tbody>
		<?php
			$dep = $_SESSION['dep'];
			$jabatan = $_SESSION['jabatan'];
			
			$sub_jab = "";
			
			if(strpos($jabatan,'Kepala Staf') >= 0){
				$sub_jab = "Staf";
			}	
			else if(strpos($jabatan,'Manajer') >= 0){
				$sub_jab = "Kepala Staf";
			}
			else if(strpos($jabatan,'Direktur') >= 0){
				$sub_jab = "Manajer";
			}
			
				if(!isset($_GET['cari'])){
					$query = "select nama, jabatan, nip from karyawan ".
					"where jabatan like '$sub_jab%' and id_dep = $dep order by nama";
				}
				else{
					$name = $_GET['cari'];
					$query = "select nama, jabatan, nip from karyawan ".
					"where jabatan like '$sub_jab%' and nama like '%"."$name"."%' and ".
					"id_dep = $dep order by nama";
				}
				$result = mysqli_query($conn,$query);
				$num = mysqli_num_rows($result);
				$count = 0;	
				if($num > 0){
					while ($row = mysqli_fetch_row($result)){
						$name = $row[0];
						
						echo "<tr>";
						echo "<td>".$row[2]."</td>";
						echo "<td>".$row[0]."</td>";
						echo "<td>";
						?>
						<button type="button" class="btn btn-info btn-sm" id="addscore" data-toggle="modal" 
								<?php
								echo "data-target=\"#modal$count\">";
								?>
								<span class="glyphicon glyphicon-pencil"></span>  Beri nilai</button>
								
								<div class="modal fade" 
								<?php
								echo " id=\"modal$count\" ";
								?>
								role="dialog">
									<div class="modal-dialog modal-md">
									<div class="modal-content">
									
										<form action="php/insert-score.php?nipscoring=<?php echo $row[2];?>" method="post">
											<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">
										<?php
										echo $name;
										?></h4>
										</div>
										<div class="modal-body">
										
										<br>
										<p style="margin-left:15px;">
										<?php
										echo "<strong>   NIP:</strong>".$row[2];
										?>
										</p>
										<div class="row" style="margin-left:0px;">
										<div class="col-md-6">
										<label for="dt">Tanggal penilaian:</label>
										<div class="input-group date">
											<input type="text" class="form-control datepicker" name="tanggal">
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</div>
										</div>
										</div>
										</div>
										<br>
										<div class="col-md-4">
											<label for="hs">Hasil kerja:</label>
											<select class="form-control" id="hs" name="hkerja">
												<option value="0">0</option>
												<option value="1">1</option><option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option><option value="5">5</option>
											</select>
										</div>
										<div class="col-md-4">
											<label for="pr">Produktivitas:</label>
											<select class="form-control" id="pr" name="prdk">
												<option value="0">0</option>
												<option value="1">1</option><option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option><option value="5">5</option>
											</select>
										</div>
										<div class="col-md-4">
											<label for="sk">Sikap:</label>
											<select class="form-control" id="sk" name="sikap">
												<option value="0">0</option>
												<option value="1">1</option><option value="2">2</option><option value="3">3</option>
												<option value="4">4</option><option value="5">5</option>
											</select>
										</div>
										
										<br><br><br>

										<div style="margin-right:15px;margin-top:10px;margin-left:15px" class="row">
										<div class="form-group">
											<br>
											<label for="note">Catatan:</label>
											<textarea class="form-control" rows="4" id="note" style="margin-left:0px;" name="catatan"></textarea>
										</div>
										</div>								
										</div>
										<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Simpan</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
										</div>
										</form>
									</div>
								</div>
						</div>
						<?php	
						echo "</td>";
						echo "<td>";
						?>
						<a href="note.php?nip=<?php echo $row[2];?>" type="button" class="btn btn-warning btn-sm">
						<span class="glyphicon glyphicon-book"> </span> Lihat Catatan</a> 
						<?php
						echo "</td>";
						echo "</tr>";
						$count++;
					}
				}
			
		?>
    </tbody>
  </table>
</div>

</body>
</html>