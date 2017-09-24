<?php
$host = "localhost";
$db = "manpro";
$user = "root";
$password = "root";

$conn = mysqli_connect($host,$user,$password,$db);
setlocale(LC_ALL,'IND');

if(!$conn){
	die("Error connect to mysql");
}

?>