<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
<script src="bootstrap/js/tests/vendor/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<meta charset="UTF-8">
<title>Salary System</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	
	<div class="login-card" style="margin-top:10%;">
    <h1>Welcome to Salary System</h1><br>
		<form action="php/login.php" method="POST">
			<input type="text" name="username" placeholder="username">
			<input type="password" name="password" placeholder="password">
			<input type="submit" name="login" class="login login-submit" value="Login">
		</form>
		<div class="login-help">
			<a href="#">Register</a> | <a href="#">Forgot Password</a>
		</div>
		<br>
		<?php
		if (isset($_GET['login'])){
			echo "<div class=\"alert alert-danger\">";
			echo "<strong>Oops!</strong> Please check your username and password again.";
			echo "</div>";
		}
		?>
	</div> 
</body>
</html>
