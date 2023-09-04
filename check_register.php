<?php
	session_start(); // Start the session
	
	if (isset($_POST['submit'])) {
		$email = $_POST['userEmail'];
		$password = $_POST['userEmail'];
		$emailToCheck = $email;
		
		$conn = new PDO('mysql:host=localhost; dbname=db_user;', 'root', '');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stm = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
		$stm->bindParam(':email', $emailToCheck, PDO::PARAM_STR);
		$stm->execute();
		$user = $stm->fetchAll(PDO::FETCH_ASSOC);
		
		if ($user) {
			$_SESSION['flash_message'] = "Email already exists. Please log in or use a different email.";
			$_SESSION['alert'] = 'alert-danger';
			
			// Redirect to registration page
		} else {
			// Email doesn't exist, proceed with registration
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("INSERT INTO `users` (email, password) VALUES (:email, :password)");
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
			$stmt->execute();
			$_SESSION['flash_message'] = "Registration is successful!";
			$_SESSION['alert'] = 'alert-success';
			// Redirect to registration page
			
		}
		header("Location: page_register.php");
	}