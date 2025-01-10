<?php
if(!isset($_POST['_login'])) {
 header('Location: /');
 exit;
}

$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера

header('Content-type: text/html; charset=utf8'); // назначаем кодировку текста
require($root.'/inc/classes/db.php'); // класс для работы с базой данных
require($root.'/inc/functions.php'); // функции
include($root.'/inc/variables.php'); // класс переменных
require($root.'/inc/classes/logs.php'); // класс для работы с логами
require($root.'/inc/classes/users.php'); // класс для работы с пользователями

// авторизация
echo $users->login(array(
 'login' => $_POST['_login'],
 'password' => $_POST['_password']
));
?>