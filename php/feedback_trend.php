<?php
function getFeedbackTrend($nip){
	require 'connect.php';
	require 'getmonth.php';
	$year = date("Y");
	
	$query = "SELECT avg(hasil_kerja),avg(produktivitas),avg(sikap) from feedback ".
				"where nip_sub = '$nip' and YEAR(tanggal) = '$year' group by nip_sub,MONTH(tanggal)";
	$result = mysqli_query($conn,$query);
	$count = 0;
	
	$hs = array();
	$pr = array();
	$sk = array();
	while($row = mysqli_fetch_row($result)){
		$count = $count + 1;
		array_push($hs,array(getAbbrMonth($count),round($row[0],2)));
		array_push($pr,array(getAbbrMonth($count),round($row[1],2)));
		array_push($sk,array(getAbbrMonth($count),round($row[2],4)));
	}
	$ret = array($hs,$pr,$sk);
	mysqli_close();
	return $ret;
	//return $hs;
}
?>