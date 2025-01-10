<?php
$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера
$task_id = $_POST['id'];
$page_name = 'tasks_edit';

if(!isset($task_id)) {
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

echo $tasks->edit($task_id, $_POST['_count'], $_POST['_price']);
?>