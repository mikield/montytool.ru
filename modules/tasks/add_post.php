<?php
$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера
$page_name = 'tasks_add';

if(!isset($_POST['type'])) {
 header('Location: /');
 exit;
}

header('Content-type: text/html; charset=utf8'); // назначаем кодировку текста
require($root.'/inc/classes/db.php'); // класс для работы с базой данных
require($root.'/inc/functions.php'); // функции
include($root.'/inc/variables.php'); // переменные
require($root.'/inc/classes/logs.php'); // класс для работы с логами
require($root.'/inc/classes/users.php'); // класс для работы с пользователями
require($root.'/inc/classes/vk.api.php'); // класс для работы с API ВК
require($root.'/inc/classes/tasks.php'); // класс для работы с заданиями
require($root.'/inc/classes/profile.php'); // класс для работы с профилем
include($root.'/inc/profile.php'); // информация о пользователе

$type = $db->escape($_POST['type']); // тип задания

echo $tasks->add(array(
 'type' => $_POST['type'],
 'url' => $_POST['url'],
 'count' => $_POST['count'],
 'price' => $_POST['price'],
 'top' => $_POST['top']
));
?>