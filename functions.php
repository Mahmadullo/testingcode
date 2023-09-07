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
	
	function isUser($role): bool
	{
		return $role === 'user';
	}
	
	function isAdmin($user)
	{
		if (is_logged_in()) {
			if ($user['role'] === 'admin')
				return;
		}
		return false;
	}
	
	function is_logged_in()
	{
		if (isset($_SESSION['username'])) {
			return true;
		}
		return false;
	}
	
	function is_not_logged()
	{
		return !is_logged_in();
	}
	
	function get_authenticatedUser()
	{
		if (is_logged_in()) {
			return $_SESSION['username'];
		}
		return false;
	}