<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quotation Service | Add a Quote</title>
<link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<?php
session_start ();
?>

<h2>Add a Quote</h2>

<form id="quote-form" method="POST" action="controller.php">
<p>Quote</p><textarea form="quote-form" rows="5" cols="40" name="quotebox" required></textarea><br>
<p>Author</p><input type="text" name="author" pattern=".{1,}" required title="1 character minimum"><br>
<input type="submit" name="addQuote" value="Add Quote">
</form>
</body>
</html>