<?php
	session_start(); // Начинаем сессию
	include_once 'database.php';
	include_once 'functions.php';
	
	if (isset($_POST['submit'])) {
		$email = $_POST['userEmail']; //Данные из поля Input Email из Страниц page_register.php
		$password = $_POST['userPassword']; // Данные из поля Input Password из Страниц page_register.php
		
		// Создаем соединение с базой данных
		$conn = connectToDatabase();
		// Проверка в базе данный
		$user = getUserDataByEmail($conn, $email);
		
		if ($user) {
//			echo 'Email already exits';
			$_SESSION['flash_message'] = 'Email already exits';
			$_SESSION['alert'] = 'alert-danger';
		} else {
			registerUser($conn, $email, $password);
			$_SESSION['flash_message'] = 'Registration, Successfully';
			$_SESSION['alert'] = 'alert-success';
		}
		header('Location: page_register.php');
		exit();
	}