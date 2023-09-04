<?php
	session_start(); // Начинаем сессию
	
	if (isset($_POST['submit'])) {
		$email = $_POST['userEmail'];
		$password = $_POST['userPassword']; // Исправлено на 'userPassword'
		
		// Создаем соединение с базой данных (замените на ваши реальные данные)
		$conn = new PDO('mysql:host=localhost; dbname=db_user;', 'root', '');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// Подготавливаем запрос для выборки пользователя по email
		$stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($user) {
			// Пользователь с указанным email найден
			if (password_verify($password, $user['password'])) {
				// Пароли совпадают, выполните действия аутентификации
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['flash_message'] = 'Аутентификация успешна.';
				$_SESSION['alert'] = 'alert-success';
				// Перенаправление на защищенную страницу после аутентификации
				header("Location: secure_page.php");
			} else {
				// Неверный пароль
				$_SESSION['flash_message'] = 'Неверный пароль';
				$_SESSION['alert'] = 'alert-danger';
				// Перенаправление на страницу входа с сообщением об ошибке
				header("Location: page_login.php");
			}
		} else {
			// Пользователь с указанным email не найден
			$_SESSION['flash_message'] = 'Пользователь с указанным email не найден';
			$_SESSION['alert'] = 'alert-danger';
			// Перенаправление на страницу входа с сообщением об ошибке
			header("Location: page_login.php");
		}
		exit();
	}
