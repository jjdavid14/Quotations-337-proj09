<?php
include 'model.php';

session_start ();

$theDBA = new DatabaseAdaptor ();

if(!isset($_SESSION['flags'])) {
	$_SESSION['flags'] = [];
}

if (isset ( $_GET ['method'] )) {
	if ($_GET ['method'] === 'plus') {
		$theDBA->increaseRating ( $_GET ['id'], $_GET ['cr'] );
	} else if ($_GET ['method'] === 'minus') {
		$theDBA->decreaseRating ( $_GET ['id'], $_GET ['cr'] );
	} else if($_GET ['method'] === 'flag') {
		array_push($_SESSION['flags'], $_GET['id']);
	} else if ($_GET ['method'] === 'getQuotes') {
	
		$arr = $theDBA->getQuotesAsArray ();
		$flagArr = [];
		for($i = 0; $i < count($arr); $i++) {
			if(!in_array($arr[$i]['id'], $_SESSION['flags'])){
				array_push($flagArr, $arr[$i]);
			}
		}
		echo json_encode ( $flagArr );
	}
}

// Form Validations
if (isset ( $_POST ['username'] )) {
	if ( $_GET ['type'] === "r") {
		$arr = $theDBA->getUsers ();
		for($i = 0; $i < count ( $arr ); $i ++) {
			if ($_POST ['username'] === $arr [$i] ['username']) {
				$_SESSION ['error'] = 'User already exist.';
				header ( 'Location: register.php' );
			}
		}
		if (! isset ( $_SESSION ['error'] )) {
			$theDBA->addUser (  $_POST ['username'], password_hash($_POST ['password'], PASSWORD_DEFAULT) );
			header ( 'Location: index.php' );
		}
	} else if ($_GET['type'] === "l") {
		$arr = $theDBA->getUsers ();
		$found = false;
		for($i = 0; $i < count ( $arr ); $i ++) {
			if ( $_POST ['username'] === $arr [$i] ['username']) {
				$found = true;
				if (!password_verify($_POST['password'], $arr [$i] ['password'])) {
					$_SESSION ['error'] = 'Incorrect password.';
					header ( 'Location: login.php' );
				}
				break;
			}
		}
		
		if(!$found) {
			$_SESSION ['error'] = 'User is not registered.';
			header ( 'Location: login.php' );
		}
		if (! isset ( $_SESSION ['error'] )) {
			$_SESSION['user'] = $_POST ['username'];
			header ( 'Location: index.php' );
		}
	}
}

//Add quote
if(isset($_POST['quotebox'])) {
	$theDBA->addQuote( $_POST ['quotebox'], $_POST ['author'] );
	header ( 'Location: index.php' );
}

//Unflag
if (isset ( $_POST ['unflag'] ) && $_POST ['unflag'] === 'Unflag All') {
	unset ( $_SESSION ['flags'] );
	header ( 'Location: index.php' );
}


//Logout
if (isset ( $_POST ['logout'] ) && $_POST ['logout'] === 'Logout') {
	unset ( $_SESSION ['user'] );
	header ( 'Location: index.php' );
}

?>