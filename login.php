<?php
	session_start(); // Start the session
	
	include_once 'functions.php'; // Include the functions file
	include_once 'database.php';
	
	
	if (!empty($_POST['emailUser']) && !empty($_POST['passwordUser'])) {
		// Получаем введенные пользователем значения
		$inputEmailUser = $_POST['emailUser'];
		$inputPasswordUser = $_POST['passwordUser'];
		
		// Устанавливаем соединение с базой данных
		$dbConnection = connectToDatabase();
		
		// Получаем данные пользователя
		$userData = getUserDataByEmail($dbConnection, $inputEmailUser);

//
//		if ($userData && password_verify($inputPasswordUser, $userData['password'])) {
//			// Успешная аутентификация, перенаправляем на страницу пользователей
//			header('Location: users.php');
//		} else {
//			// Неверные учетные данные, устанавливаем сообщение об ошибке и перенаправляем на страницу входа
//			$_SESSION['flash_message'] = 'Неверный email или пароль';
//			$_SESSION['alert'] = 'danger';
//			header('Location: page_login.php');
//		}
//	}
//

//		if ($userData) {
//			// Проверяем хэшированный пароль
//			if (password_verify($inputPasswordUser, $userData['password'])) {
//				// Успешная аутентификация, перенаправляем на страницу пользователей
//				header('Location: users.php');
//			} else {
//				// Неверный пароль
//				echo "Неверный пароль";
//			}
//		} else {
//			// Пользователь с указанным email не найден
//			echo "Пользователь с указанным email не найден";
//		}
//
//		exit();
//	}
		
		if ($userData) {
			// Отладочная информация
			var_dump($inputPasswordUser);
			var_dump($userData['password']);
			
			// Проверяем хэшированный пароль
			if (password_verify($inputPasswordUser, $userData['password'])) {
				// Успешная аутентификация, перенаправляем на страницу пользователей
				header('Location: users.php');
			} else {
				// Неверный пароль
				echo "Неверный пароль";
			}
		} else {
			// Пользователь с указанным email не найден
			echo "Пользователь с указанным email не найден";
		}
		
		exit();
		var_dump($userData);
	}