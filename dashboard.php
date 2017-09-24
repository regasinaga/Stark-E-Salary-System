<!DOCTYPE HTML>
<html>
<title>Welcome</title>
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
				<li class="active"><a href="#">Pengawasan</a></li>
				<li><a href="feedback.php">Feedback</a></li>
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
<div style="width:200px;margin-left:auto;margin-right:130px;"">
    <form action="dashboard.php" class="search-form" method="get">
        <div class="form-group has-feedback">
      		<label for="cari" class="sr-only">Cari</label>
           		<input type="text" class="form-control" name="cari" id="search" placeholder="Cari berdasar nama">
           		<span class="glyphicon glyphicon-search form-control-feedback"></span>
       	</div>
    </form>
</div>
<div class="table-container">
	<table class="table table-striped">
    <thead>
      <tr class="success">
		<th width="10%">NIP</th>
        <th width="30%">Nama</th>
        <th width="30%">Jabatan</th>
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
					
				if($num > 0){
					while ($row = mysqli_fetch_row($result)){
						
						echo "<tr>";
						echo "<td>".$row[2]."</td>";
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[1]."</td>";
						echo "<td class=\"text-center\">"."<a href=\"tren.php?nama=$row[0]&nip=".$row[2]."&view=presence".
								"\" type=\"button\" style=\"width:100px;\" ".
								"class=\"btn btn-primary btn-sm\">
								<span class=\"glyphicon glyphicon-signal\"></span>
								Lihat tren</a></td>";
						echo "</tr>";
					}
				}
			
		?>
    </tbody>
  </table>
</div>

</body>
</html>