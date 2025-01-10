<?php
if($page_name == 'main') {
 // если страница главная(логин и пароль)
 $user_info = $db->query("SELECT `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_next') { 
 // если страница подгрузки задания
 $user_info = $db->query("SELECT `tasks_done`, `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'all_tasks' || $page_name == 'my_tasks') { 
 // если страница со списком заданий
 $user_info = $db->query("SELECT `first_name`, `last_name`, `avatar`, `points`, `hash`, `complaints`, `tasks_done` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_go') {
 // если страница перехода на задание
 $user_info = $db->query("SELECT `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_add') {
 // если страница добавления задания
 $user_info = $db->query("SELECT `points`, `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_check') {
 // если страница проверки
 $user_info = $db->query("SELECT `points`, `tasks_done`, `tasks_summ_done`, `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_ignored') {
 // если страница игнорирования задания
 $user_info = $db->query("SELECT `tasks_done`, `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_edit') {
 // если страница редактирования задания
 $user_info = $db->query("SELECT `points`, `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_search') {
 $user_info = $db->query("SELECT `hash` FROM `users` WHERE `vk_id` = $vkid");
} elseif($page_name == 'tasks_complaints') {
 $user_info = $db->query("SELECT `hash`, `group` FROM `users` WHERE `vk_id` = $vkid");
} else {
 // если другая страница
 $user_info = $db->query("SELECT `first_name`, `last_name`, `avatar`, `points`, `complaints`, `hash` FROM `users` WHERE `vk_id` = $vkid");
}

$user_info_data = $db->fetch($user_info);

// значения из БД
$user_hash = $user_info_data['hash']; // хэш
$user_name = $user_info_data['first_name']; // имя
$user_surname = $user_info_data['last_name']; // фамилия
$user_avatar = $user_info_data['avatar']; // аватар
$user_points = $user_info_data['points']; // монеты
$user_group = $user_info_data['group']; // группа
$tasks_done = $user_info_data['tasks_done'] ? $user_info_data['tasks_done'] : 0; // список выполненных заданий
$tasks_summ_done = $user_info_data['tasks_summ_done']; // кол-во выполненных заданий
$complaints = $user_info_data['complaints']; // кол-во выполненных заданий

// в случае, если авторизация пропала
if($hash) {
 $profile->user_change_hash($hash, $user_hash, $vkid, $page_name);
} else {
 if($page_name != 'main') {
  header('Location: /');
  exit;
 }
}
?>