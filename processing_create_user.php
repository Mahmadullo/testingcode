<?php
	session_start();
	//Подюключение файлов базы и функции
	require_once 'database.php';
	require_once 'functions.php';
	
	
	//Проверка за логин ли пользователь
	if (is_logged_in()) {
		$user_data = get_authenticatedUser();
		
		if ($user_data !== false) {
			// Пользователь вошел в систему, и $user_data содержит информацию о пользователе
			// Выполняем действия для вошедших в систему пользователей
			header('Location: users.php');
		} else {
			// Данные пользователя недоступны; что-то не так
			// Перенаправляем на страницу входа или обрабатываем ситуацию соответственно
		}
	} else {
		// Если пользователь не вошел в систему
		header('Location: page_login.php');
	}