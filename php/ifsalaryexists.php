<?php
require 'getfirstdate.php';
function ifsalaryexists($conn,$month,$year){
	$firstdate = getfirstdate($month,$year);
	$query = "select * from gaji ".
				"where "
}
?>