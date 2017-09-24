<?php
function getamountday($month,$year){
	if($month  == "Januari" || $month = 01)
		return 27;
	else if($month == "Februari" || $month = 02){
		if($year % 4 == 0)
			return 25;
		return 24;
	}		
	else if($month == "Maret" || $month = 03)
		return 27;
	else if($month == "April" || $month = 04)
		return 26;
	else if($month == "Mei" || $month = 05)
		return 27;
	else if($month == "Juni" || $month = 06)
		return 26;
	else if($month == "Juli" || $month = 07)
		return 31;
	else if($month == "Agustus" || $month = 08)
		return 31;
	else if($month == "September" || $month = 09)
		return 30;
	else if($month == "Oktober" || $month = 10)
		return 31;
	else if($month == "November" || $month = 11)
		return 30;
	else if($month == "Desember" || $month = 12)
		return 31;
}
?>