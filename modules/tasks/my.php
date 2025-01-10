<?php
$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера
$category = (int) $_GET['cat']; // id категории
$repost = $_GET['act']; // метка репоста
$page_name = 'my_tasks';

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

// если параметр категории неверен
if(!preg_match('/([0-9]+)/i', $_GET['cat']) && $category) {
 header('Location: /tasks');
 exit;
}

// активные вкладки
if($category == 1 && $_GET['act'] == 'reposts') $tab_active = 6; // рассказать друзьям
elseif($category == 1) $tab_active = 1; // мне нравится
elseif($category == 2) $tab_active = 2; // комментарий
elseif($category == 3) $tab_active = 3; // подписаться
elseif($category == 4) $tab_active = 4; // вступить
elseif($category == 5) $tab_active = 5; // опрос
else $tab_active = 0; // все
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Мои задания</title>
  <? include($root.'/include/head.php'); ?>
  
 </head>
 <body>
  <div id="page">
   <? include($root.'/include/header.php'); ?>
   
   <div id="content_wrap">
    <div id="content">
     <? include($root.'/include/menu_left.php'); ?>
     
     <div id="right_wrap">
      <div id="right">
       <div id="tab_content">
        <a<? if($tab_active == 0) echo ' class="active"'; ?> href="/tasks/my" onclick="nav.go(this); return false;">
         Весь список 
        </a>
        <a<? if($tab_active == 1) echo ' class="active"'; ?> href="/tasks/my?cat=1" onclick="nav.go(this); return false;">
         "Мне нравится"
        </a>
         <a<? if($tab_active == 6) echo ' class="active"'; ?> href="/tasks/my?cat=1&act=reposts" onclick="nav.go(this); return false;">
         "Рассказать друзьям"
        </a>
        <a<? if($tab_active == 2) echo ' class="active"'; ?> href="/tasks/my?cat=2" onclick="nav.go(this); return false;">
         Комментарии
        </a>
        <a<? if($tab_active == 3) echo ' class="active"'; ?> href="/tasks/my?cat=3" onclick="nav.go(this); return false;">
         Подписки
        </a>
        <a<? if($tab_active == 4) echo ' class="active"'; ?> href="/tasks/my?cat=4" onclick="nav.go(this); return false;">
         Сообщества
        </a>
        <a<? if($tab_active == 5) echo ' class="active"'; ?> href="/tasks/my?cat=5" onclick="nav.go(this); return false;">
         Опросы
        </a>
        <div id="tasks_search">
         <div id="search_icon_tasks"></div>
         <input placeholder="Введите ссылку и нажмите Enter..." type="text" id="_tasks_search">
        </div>
       </div>
       <div id="tab_content_hr"></div>
       
       <div id="tasks_list">
        <div id="tasks_all_list">
        <? echo $tasks->my(array(
         'vk_id' => $vkid,
         'category' => $category,
         'repost' => $repost
        )); ?>
        
        </div>
        <div id="tasks_search_list"></div>
       </div>
      </div>
     </div>
    </div>
   </div>
   <? include($root.'/include/footer.php'); ?>
   
  </div>
 </body>
</html>