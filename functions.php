<?php
	
	session_start(); // Start the session
	
	function registerUser($conn, $email, $password)
	{
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $conn->prepare("INSERT INTO `users` (email, password) VALUES (:email, :password)");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	function getUserDataByEmail($conn, $email)
	{
		$stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	function getUsers($conn, $table)
	{
		$stmt = $conn->prepare("SELECT * FROM $table");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function addUser($conn, $table, $user)
	{
		$stmt = $conn->prepare("INSERT INTO `users`(`email`) VALUES ('ss')");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}