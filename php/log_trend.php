<?php
function getLogTrend($nip){
	require 'connect.php';
	require 'getmonth.php';
	
	$year = date("Y");
	
	$query = "select count(waktu) from log_presensi ".
				"where nip = ".$nip." and status = 1 and ".
				"YEAR(waktu) = ".$year.
				" group by last_day(waktu)";
				
	$result = mysqli_query($conn,$query);
	$val = array(0,0,0,0,0,0,0,0,0,0,0,0);
	$count = 0;
	
	while($row = mysqli_fetch_row($result))
	{
		$count = $count + 1;
		$re[] = array(getAbbrMonth($count),$row[0]);
	}
	
	mysqli_close();
	return $re;
}
?>