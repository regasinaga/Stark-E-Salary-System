<?php
function calculatefromscore($ahs,$apr,$ask){
	if($ahs >= 4.0 && $apr >= 4.1 && $ask >= 4.1){
		return 1;
	}
	return (($ahs+$apr+$ask)/3)/5;
}
?>