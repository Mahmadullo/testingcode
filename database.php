<?php
	
	function connectToDatabase()
	{
		$host = 'localhost';
		$dbname = 'check.loc';
		$username = 'root';
		$password = '';
		
		try {
			$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}