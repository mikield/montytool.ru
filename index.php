<?php
$root = $_SERVER['DOCUMENT_ROOT']; // путь сервера
$page_name = 'main';

require($root.'/inc/classes/db.php'); // класс для работы с базой данных
require($root.'/inc/functions.php'); // функции
include($root.'/inc/variables.php'); // переменные
require($root.'/inc/classes/users.php'); // класс для работы с пользователями
require($root.'/inc/classes/profile.php'); // класс для работы с профилем
require($root.'/inc/profile.php'); // информация о пользователе
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
<? include($root.'/include/header_no_login.php'); ?>

       <div id="main_text">
        <b>MontyTool</b> - сервис, с помощью которого Вы сможете продвинуть свой товар или услугу в соц.сети ВК, а именно <span style="padding-left: 1px;">накрутить</span> мне нравится, рассказать друзьям, комментарии, подписчиков и опросы.
        <div id="speed_reg">
         <div id="title">Моментальная регистрация</div>
         <div id="reg_error"></div>
         <div id="body">
          <input type="text" placeholder="Ссылка на страницу ВК" id="reg_vk">
          <input type="text" placeholder="Придумайте логин" id="reg_login">
          <input type="password" placeholder="Придумайте пароль" id="reg_password">
          <div onclick="_users._reg();" id="reg_button" class="box_button_first_wrap"><div class="box_buttons box_button_first">Зарегистрироваться</div></div>
         </div>
        </div>
        <div id="help_main_title">В чём поможет MontyTool?</div>
        <div class="mini_full">
         <div class="list">
          <div class="li"></div>
          <div class="text">Накрутить мне нравится, рассказать друзьям, комментарии, подписчиков, опросы.</div>
         </div>
         <div class="list">
          <div class="li"></div>
          <div class="text">Получить навыки тыканья по кнопкам.</div>
         </div>
         <div class="list">
          <div class="li"></div>
          <div class="text">Похвастаться результатом перед друзьями.</div>
         </div>
        </div>
        <div style="display: none;" id="main_screens">
         <img src="http://vk.com/images/join/dial_1.png?3">
         <img src="http://vk.com/images/join/dial_1.png?3">
         <img src="http://vk.com/images/join/dial_1.png?3">
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
	<? include($root.'/include/footer.php'); ?>
 </body>
</html>