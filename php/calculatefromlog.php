<?php
include 'getday.php';
function calculatefromlog($log,$month,$year){
	if($log/getamountday($month,$year) > 0.9)
		return 1;
	return $log/getamountday($month,$year);
}
?>