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
		// Prepare the SQL statement
		$stmt = $conn->prepare("INSERT INTO `$table`(`username`, `job_title`, `status`, `image`, `phone`, `address`, `email`, `vk`, `telegram`, `instagram`) VALUES (:username, :job_title, :status, :image, :phone, :address, :email, :vk, :telegram, :instagram)");
		
		// Bind parameters
		$stmt->bindParam(':username', $user['username']);
		$stmt->bindParam(':job_title', $user['job_title']);
		$stmt->bindParam(':status', $user['status']);
		$stmt->bindParam(':image', $user['image']);
		$stmt->bindParam(':phone', $user['phone']);
		$stmt->bindParam(':address', $user['address']);
		$stmt->bindParam(':email', $user['email']);
		$stmt->bindParam(':vk', $user['vk']);
		$stmt->bindParam(':telegram', $user['telegram']);
		$stmt->bindParam(':instagram', $user['instagram']);
		
		// Execute the SQL statement
		return $stmt->execute();
	}
	
	function isUser($role): bool
	{
		return $role === 'user';
	}
	
	function isAdmin($user)
	{
		if (is_logged_in() && isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}
		return false;
	}
	
	function is_logged_in()
	{
		if (isset($_SESSION['user_id'])) {
			return true;
		}
		return false;
	}
	
	function is_not_logged()
	{
		return !is_logged_in();
	}
	
	function get_authenticatedUserFromData()
	{
		if (is_logged_in() && isset($_SESSION['user_data'])) {
			return $_SESSION['user_data'];
		}
		return false;
	}
	
	function compareUserIds($userId, $idfromSession)
	{
		// Проверка, что идентификатор из сессии и из базы данных совпадают ли они
		if ($userId['id'] == $idfromSession['user_id']) {
			return true;
		}
		return false;
	}
	
	//После много попытки начал по видео решение кода но без результатно
	function login($email, $password)
	{
		$user =
			[
				'id' => '1',
				'email' => 'mahmadullo.1111@gmail.com',
			];
		$_SESSION['user'] = $user;
	}