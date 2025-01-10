<?php
$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера
$page_name = 'add_tasks';

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
  <title>Новое задание</title>
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
       <div class="task_add" id="tab_content">
        <a id="tab_add1" class="active" href="javascript://">"Мне нравится"</a>
        <a id="tab_add2" href="javascript://">"Рассказать друзьям"</a>
        <a id="tab_add4" href="javascript://">Подписаться</a>
        <a id="tab_add5" href="javascript://">Вступить в группу</a>
       </div>
       <div id="tab_content_hr"></div>
       <div id="task_add_error"></div>
       <div id="task_add">
        <div class="tab_add1">
         <div class="legend">
          <div class="label">Ссылка:</div>
          <div class="field"><input placeholder="Запись или фото..." type="text" class="url url_likes"></div>
         </div>
         <div class="legend">
          <div class="label">Кол-во лайков:</div>
          <div class="field"><input type="text" class="count count_likes"></div>
         </div>
         <div class="legend">
          <div class="label">Цена за выполнение:</div>
          <div class="field"><input type="text" class="price price_likes"> не менее 5 и не более 60 <br /> <input type="checkbox" id="top_task1"> Вывести задание в топ(10.000 монет)</div>
         </div>
         <div onclick="tasks._add('likes', $('.url_likes').val(), $('.count_likes').val(), $('.price_likes').val(), 1)" class="box_button_first_wrap"><div class="box_buttons box_button_first"><span id="button_type1">Создать задание — <b id="auto_coins_likes">0 монет</b></span><span id="button_type_load1"></span></div></div>
        </div>
        <div class="tab_add2" style="display: none;">
         <div class="legend">
          <div class="label">Ссылка:</div>
          <div class="field"><input placeholder="Например: vk.com/durov?w=wall1_1" type="text" class="url url_reposts"></div>
         </div>
         <div class="legend">
          <div class="label">Кол-во репостов:</div>
          <div class="field"><input type="text" class="count count_reposts"></div>
         </div>
         <div class="legend">
          <div class="label">Цена за выполнение:</div>
          <div class="field"><input type="text" class="price price_reposts"> не менее 5 и не более 60  <br /> <input type="checkbox" id="top_task2"> Вывести задание в топ(10.000 монет)</div>
         </div>
         <div onclick="tasks._add('reposts', $('.url_reposts').val(), $('.count_reposts').val(), $('.price_reposts').val(), 2)" class="box_button_first_wrap"><div class="box_buttons box_button_first"><span id="button_type2">Создать задание — <b id="auto_coins_reposts">0 монет</b></span><span id="button_type_load2"></span></div></div>
        </div>
        <div class="tab_add4" style="display: none;">
         <div class="legend">
          <div class="label">Ссылка:</div>
          <div class="field"><input placeholder="Например: vk.com/durov или vk.com/id1" type="text" class="url url_friends"></div>
         </div>
         <div class="legend">
          <div class="label">Кол-во подписчиков:</div>
          <div class="field"><input type="text" class="count count_friends"></div>
         </div>
         <div class="legend">
          <div class="label">Цена за выполнение:</div>
          <div class="field"><input type="text" class="price price_friends"> не менее 5 и не более 60  <br /> <input type="checkbox" id="top_task4"> Вывести задание в топ(10.000 монет)</div>
         </div>
         <div onclick="tasks._add('friends', $('.url_friends').val(), $('.count_friends').val(), $('.price_friends').val(), 4)" class="box_button_first_wrap"><div class="box_buttons box_button_first"><span id="button_type4">Создать задание — <b id="auto_coins_friends">0 монет</b></span><span id="button_type_load4"></span></div></div>
        </div>
        <div class="tab_add5" style="display: none;">
         <div class="legend">
          <div class="label">Ссылка:</div>
          <div class="field"><input placeholder="Например: vk.com/team или vk.com/public123" type="text" class="url url_group"></div>
         </div>
         <div class="legend">
          <div class="label">Кол-во участников:</div>
          <div class="field"><input type="text" class="count count_group"></div>
         </div>
         <div class="legend">
          <div class="label">Цена за выполнение:</div>
          <div class="field"><input type="text" class="price price_group"> не менее 5 и не более 60  <br /> <input type="checkbox" id="top_task5"> Вывести задание в топ(10.000 монет)</div>
         </div>
         <div onclick="tasks._add('group', $('.url_group').val(), $('.count_group').val(), $('.price_group').val(), 5)" class="box_button_first_wrap"><div class="box_buttons box_button_first"><span id="button_type5">Создать задание — <b id="auto_coins_group">0 монет</b></span><span id="button_type_load5"></span></div></div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
   <? include($root.'/include/footer.php'); ?>
   
   <input type="hidden" id="ttop">
  </div>
 </body>
</html>