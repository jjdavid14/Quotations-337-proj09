<?php
class DatabaseAdaptor {

	private $DB;

	public function __construct() {
		$db = 'mysql:dbname=jamie_david_quotations;host=127.0.0.1; ; charset=utf8';
		$user = 'root';
		$password = '';
		try {
			$this->DB = new PDO ( $db, $user, $password );
			$this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch ( PDOException $e ) {
			echo ('Error establishing Connection');
			exit ();
		}
	}
	
	public function getQuotesAsArray() {
		$stmt = $this->DB->prepare ( "SELECT * FROM quotes ORDER BY rating DESC;" );
		$stmt->execute ();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	public function getUsers() {
		$stmt = $this->DB->prepare ( "SELECT * FROM users;" );
		$stmt->execute ();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	public function addUser($username, $password) {
		$stmt = $this->DB->prepare ( "INSERT INTO users(username, password) VALUES ('" . $username . "', '" . $password . "');" );
		$stmt->execute ();
	}
	
	public function increaseRating($id, $currentRate) {
		$stmt = $this->DB->prepare ( "UPDATE quotes SET rating = " . (int)($currentRate + 1) . " WHERE id = " . (int)$id . ";" );
		$stmt->execute ();
	}
	
	public function decreaseRating($id, $currentRate) {
		$stmt = $this->DB->prepare ( "UPDATE quotes SET rating = " . (int)($currentRate - 1) . " WHERE id = " . (int)$id . ";" );
		$stmt->execute ();
	}
	
	public function addQuote($quote, $author) {
		$stmt = $this->DB->prepare ( "INSERT INTO quotes(quote, author, rating) VALUES ('" . $quote . "', '" . $author . "',0);" );
		$stmt->execute ();
	}
}
?>