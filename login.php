<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quotation Service | Login</title>
<link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<?php
session_start ();
?>

<h2>Login</h2>

<form class="forms" method="POST" action="controller.php?type=l">
<p>Username</p><input type="text" name="username" pattern=".{4,}" required title="4 characters minimum">
<p>Password</p><input type="password" name="password" pattern=".{6,}" required title="6 characters minimum">
<input type="submit" name="login" value="Login">
<div>
<?php
  if( isset(  $_SESSION['error']))
    echo   "<p id='error-message'>" . $_SESSION['error'] . "</p>";
unset($_SESSION['error']);
	?>
	</div>
</form>
</body>
</html>