<?php
function getfirstdate($month,$year){
	if($month  == "Januari")
		return $year."-01-01";
	else if($month == "Februari")
		return $year."-02-01";
	else if($month == "Maret")
		return $year."-03-01";
	else if($month == "April")
		return $year."-04-01";
	else if($month == "Mei")
		return $year."-05-01";
	else if($month == "Juni")
		return $year."-06-01";
	else if($month == "Juli")
		return $year."-07-01";
	else if($month == "Agustus")
		return $year."-08-01";
	else if($month == "September")
		return $year."-09-01";
	else if($month == "Oktober")
		return $year."-10-01";
	else if($month == "November")
		return $year."-11-01";
	else if($month == "Desember")
		return $year."-12-01";
}
?>