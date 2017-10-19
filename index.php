<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php
//require_once './controller.php';
session_start();
?>

<h1>Quotes</h1>

	<!-- Show the horizontal menu -->
	<ul>
		<li><a href="register.php">Register</a></li>
		<li><a href="login.php">Login</a></li>
		<li><a href="add.php">Add Quote</a></li>
	</ul>
	<?php 
	if(isset($_SESSION['user'])) {
		$str = "";
		$str .= "<form action='controller.php' method='POST'>";
		$str .= "<input type='submit' name='unflag' value='Unflag All'>";
		$str .= "<input type='submit' name='logout' value='Logout'>";
		$str .= "</form>";
		echo $str;
	}
	?>
	
	<div id="quote-list"></div>
	
<script>
showQuotes();

function showQuotes() {
	var anObj = new XMLHttpRequest();
	var divToChange = document.getElementById("quote-list");
	anObj.open("GET", "controller.php?method=getQuotes", true);
	anObj.send();
	anObj.onreadystatechange = function() {
		if (anObj.readyState == 4 && anObj.status == 200) {
			var array = JSON.parse(anObj.responseText);
			var str = "<br>";
			
			for(var i = 0; i < array.length; i++) {
				str += "<div class='quote'>";
				str += "<q>" + array[i]['quote'] + '</q>';
				str += "<p>-- " + array[i]['author'] + "</p>";
				str += "<button onclick='plusButton(" + array[i]['id'] + ", " + array[i]['rating'] + ")'> + </button>";
				str += "<span class='rating'>" + array[i]['rating'] + "</span>";
				str += "<button onclick='minusButton(" + array[i]['id'] + ", " + array[i]['rating'] + ")'> - </button>";
				str += "<button id='flag' onclick='flagItem(" + array[i]['id'] + ")'> flag </button>";
				str += "</div>";
			}
			divToChange.innerHTML = str;
		}
	}
}

	function plusButton(id, currentRate) {
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?method=plus&id=" + id + "&cr=" + currentRate, true);
		anObj.send();
		anObj.onreadystatechange = function() {
			showQuotes();
		}

	}

	function minusButton(id, currentRate) {
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?method=minus&id=" + id + "&cr=" + currentRate, true);
		anObj.send();
		anObj.onreadystatechange = function() {
			showQuotes();
		}

	}

	function flagItem(id) {
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "controller.php?method=flag&id=" + id, true);
		anObj.send();
		anObj.onreadystatechange = function() {
			showQuotes();
		}
	}

</script>
</body>
</html>
