<?php
$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера
$task_id = (int) $_GET['id']; // id задания
$page_name = 'tasks_go';

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

// получаем ссылку на задание
$q = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tcount`, `tdone_users`, `tdel`, `tdel_admin`, `trepost` FROM `tasks` WHERE `tid` = $task_id");
$d = $db->fetch($q);

// информация о задании
$task_id = $d['tid'];
$task_cat = $d['tcategory'];
$task_url = $d['turl'];
$task_name = $d['tname'];
$task_repost = $d['trepost'];
$task_count = $d['tcount'];
$task_done = $d['tdone_users'];
$task_del = $d['tdel'];
$task_delAdmin = $d['tdel_admin']; 

// проверка
if(!$task_id) {
 $error = 'Неизвестная ошибка. Попробуйте позже.';
} elseif($task_del == 1 || $task_delAdmin == 1) {
 $error = 'Это задание было удалено.';
} elseif($task_count == $task_done) {
 $error = 'Это задание достигло определенного кол-ва участников.';
} elseif($task_cat == 4) {
 $task_group = json_decode($links->get_group_id('http://vk.com/public'.$task_url), true);
 if($task_group['error_code'] == 301) {
  $error = 'Не удалось соединиться с сервером ВКонтакте. Попробуйте позже.';
 } elseif($task_group['closed'] == 1) {
  $error = 'Это задание не подлежит выполнению, так как группа является закрытой. <br /> <br /> <b>Жалоба отправлена</b> модератору на рассмотрение.';
 } else {
  header('Location: http://vk.com/public'.$task_url);
 }
} elseif($task_cat == 3) {
 header('Location: http://vk.com/id'.$task_url);
} elseif($task_cat == 2) {
 if($task_name == 'wall') {
  if($task_repost) {
  
  } else {
   header('Location: http://vk.com/'.$task_url);
  }
 } elseif($task_name == 'photo') {
  header('Location: http://vk.com/'.$task_url);
 }
} elseif($task_cat == 1) {
 if($task_name == 'wall') {
  header('Location: http://vk.com/'.$task_url);
 } elseif($task_name == 'photo') {
  header('Location: http://vk.com/'.$task_url);
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Проверка задания...</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <style type="text/css">
   * {padding: 0; margin: 0}
   body {font-size: 20px; font-family: tahoma; color: gray; line-height: 18px; text-align: center;}
  </style>
 </head>
 <body>
  <div id="content">
   <? echo $error; ?>
  </div>
  <script type="text/javascript">
   $('body').css('marginTop', $(document).height() / 2 - $('#content').height());
  </script>
 </body>
</html>