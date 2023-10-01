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
	
	function getUserDataByEmail($conn, $table, $email)
	{
		$stmt = $conn->prepare("SELECT * FROM $table WHERE email = :email");
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
		// File upload
		$uploaded_file = $_FILES['image']['tmp_name'];
		$destination_path = 'img/demo/avatars/' . $_FILES['image']['name'];
		if (uploadImage($uploaded_file, $destination_path)) {
			// Prepare the SQL statement
			$stmt = $conn->prepare("INSERT INTO $table (`username`, `job_title`, `status`, `phone`, `address`, `email`, `image`, `vk`, `telegram`, `instagram`)
            VALUES (:username, :job_title, :status, :phone, :address, :email, :image, :vk, :telegram, :instagram)");
			
			// Bind parameters
			$stmt->bindParam(':username', $user['username']);
			$stmt->bindParam(':job_title', $user['job_title']);
			$stmt->bindParam(':status', $user['status']);
			$stmt->bindParam(':phone', $user['phone']);
			$stmt->bindParam(':address', $user['address']);
			$stmt->bindParam(':email', $user['email']);
			$stmt->bindParam(':image', $destination_path); // Save the image path in the database
			$stmt->bindParam(':vk', $user['vk']);
			$stmt->bindParam(':telegram', $user['telegram']);
			$stmt->bindParam(':instagram', $user['instagram']);
			// Execute the SQL statement
			return $stmt->execute();
		} else {
			return false; // File upload failed
		}
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
	
	function get_authenticatedUser()
	{
		if (is_logged_in() && isset($_SESSION['user_data'])) {
			return $_SESSION['user_data'];
		}
		return false;
	}
	
	function compareUserIds($userId, $idfromSession)
	{
		// Проверка, что идентификатор из сессии и из базы данных существуют и совпадают
		if ($userId['id'] == $idfromSession['id']) {
			return true;
		}
		return false;
	}
	
	function uploadImage($uploaded_file, $destination_directory)
	{
		// Get the original filename from the uploaded file
		$original_filename = basename($uploaded_file); // Use basename() to get the filename
		
		// Generate a unique filename by adding a timestamp and a random string
		$unique_filename = time() . '_' . uniqid() . '_' . $original_filename;
		
		// Combine the destination directory and the unique filename
		$destination_path = $destination_directory . $unique_filename;
		
		if (move_uploaded_file($uploaded_file, $destination_path)) {
			return $unique_filename; // Return the unique filename
		} else {
			return false; // Error when uploading the file
		}
	}
	
	$destination_directory = 'img/demo/avatars/';

// Check if the 'image' file input exists in the form
	if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
		$uploaded_file = $_FILES['image']['tmp_name'];
		$unique_filename = uploadImage($uploaded_file, $destination_directory);
		
		if ($unique_filename) {
			echo "File uploaded successfully!";
		} else {
			// Handle the case where the file upload failed
			echo "Error uploading file.";
		}
	} else {
		// Handle the case where the file input is missing or there was an error
		echo "No file uploaded or an error occurred.";
	}
	
	
	function addSocialLinks()
	{
	
	}
	
	function setStatus()
	{
	
	}
	
	function addUserByEmail($email, $password)
	{
	
	}