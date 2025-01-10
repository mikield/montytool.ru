<?php
class Tasks {
 public function trim($string = '') {
  return preg_replace('/ {2,}/', '', $string);
 }
 
 public function all_new($param = null) { // отображаем весь список заданий
  global $db, $links, $vkid, $tasks_done;
  $category = (int) $param['category']; // категория задания из адресной строки
  $vk_id = (int) $param['vk_id']; // id пользователя, у которого получаем задания
  $_repost = $db->escape($param['repost']); // id пользователя, у которого получаем задания
  $search = $db->escape($param['search']);
  $page = (int) $param['page'];
  $start_ent = $page * 150;
  
  // запрос на получение списка задания
  if($search) {
   $search_user = json_decode($links->get_user_id($search), true);
   $search_group = json_decode($links->get_group_id($search), true);
   $search_other = json_decode($links->get_all_info($search), true);
   
   $search_user_id = $db->escape($search_user['url']);
   $search_group_id = $db->escape($search_group['url']);
   $search_other_id = $db->escape($search_other['url']);
   
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost` FROM `tasks` WHERE `tvk_id` != $vk_id AND `turl` = '$search_user_id' OR `turl` = '$search_group_id' OR `turl` = '$search_other_id' AND `tdel` != 1 AND `tsuccess` = 0 ORDER BY `tprice` DESC");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `turl` = '$search_user_id' OR `turl` = '$search_group_id' OR `turl` = '$search_other_id' AND `tdel` != 1 AND `tsuccess` = 0 AND `tvk_id` != $vk_id"));
  } elseif($param['top'] == 1) {
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tsuccess` = 0 AND `tdel` != 1 AND `top` = 1 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT 15");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tdel` != 1 AND `tsuccess` = 0 AND `top` = 1 LIMIT 15"));
  } elseif($category == 1 && $_repost == 'reposts') {
   // категория рассказать друзьям
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 1 AND `trepost` = 1 AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT $start_ent, 150");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 1 AND `trepost` = 1 AND `tdel` != 1 AND `tsuccess` = 0"));
  } elseif($category == 1) {
   // категория мне нравится
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 1 AND `trepost` != 1 AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT $start_ent, 150"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 1 AND `trepost` != 1 AND `tdel` != 1 AND `tsuccess` = 0"));
  } elseif($category == 2) {
   // категория комментарий
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `tcomments` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 2 AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT $start_ent, 150"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 2 AND `tdel` != 1 AND `tsuccess` = 0"));
  } elseif($category == 3) {
   // категория подписаться
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 3 AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT $start_ent, 150"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 3 AND `tdel` != 1 AND `tsuccess` = 0"));
  } elseif($category == 4) {
   // категория вступить
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 4 AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT $start_ent, 150"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 4 AND `tdel` != 1 AND `tsuccess` = 0"));
  } elseif($category == 5) {
   // категория опрос
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 5 AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) ORDER BY `tprice` DESC LIMIT $start_ent, 150");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tcategory` = 5 AND `tdel` != 1 AND `tsuccess` = 0"));
  } else {
   // если нет категории
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost`, `tcomments` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tdel` != 1 AND `tsuccess` = 0 AND `tid` NOT IN($tasks_done) AND `top` != 1 ORDER BY `tprice` DESC LIMIT $start_ent, 150");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` != $vk_id AND `tdel` != 1 AND `tsuccess` = 0 AND `top` != 1"));
  }
  
  for($i = 0; $i <= $num; $i++) {
   $data = $db->fetch($query);
   $active_task = $i%2 ? ' active' : '';
   $id = $data['tid']; // id материала
   $cat = $data['tcategory']; // категория материала(лайки, комментарии и т.д.)
   $name = $data['tname']; // тип объекта(запись, фото и т.д.)
   $url = $data['turl']; // url
   $text = htmlspecialchars($data['tfile_text']); // текст записи или чего-то другого
   $text_min = mb_strlen($text, 'UTF-8') > 11 ? mb_substr($text, 0, 11, 'UTF-8').'...' : $text;  // текст записи или чего-то другого
   $text_explode = explode('|', $text); // разделение для имени и фамилии
   $count = $data['tcount']; // кол-во человек, которые должны выполнить задания
   $done = $data['tdone_users']; // кол-во человек, которые выполнили задание
   $price = $data['tprice']; // цена за задание
   $repost = $data['trepost']; // метка репоста
   $comments = $data['tcomments']; // комментарии
   $comments_explode = explode('|', $comments); // комментарии
   array_pop($comments_explode);
   $comment_rand = Tasks::trim(trim(htmlspecialchars($comments_explode[rand(0, count($comments_explode) - 1)])));
   
   // переключатель
   if(!$page && $num > 50) {
    $page_sel = '<div id="body_next_tasks"></div><div id="tasks_all_next_wrap"><div onclick="tasks._next(\''.$category.'\', \''.$repost.'\')" id="tasks_all_next">Показать ещё задания</div></div>';
   } else $page_sel = '';
   
   // шаблон материалов
   if($cat == 1 && $repost == 1) {
    // рассказать друзьям
    if($name == 'wall') { 
     // записи на стене
     $description = $text ? 'Рассказать друзьям о записи «<a href="http://vk.com/'.$url.'" target="_blank">'.$text_min.'</a>»' : 'Рассказать друзьям о <a href="http://vk.com/'.$url.'" target="_blank">записи</a>';
    }
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon repost"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
           Нажмите <a href="#">сюда</a>, если хотите пожаловаться.
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="check'.$id.'" href="javascript://" onclick="task_check._repost('.$id.');"><b>Выполнить задание</b></a>
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._ignored('.$id.');"><b>Не показывать</b></a>           
          </div>
         </div>
         ';
   } else if($cat == 1) {
    // мне нравится
    if($name == 'wall') { 
     // записи на стене
     $description = $text ? 'Нажать мне нравится на записи «<a href="http://vk.com/'.$url.'" target="_blank">'.$text_min.'</a>»' : 'Нажать мне нравится на <a href="http://vk.com/'.$url.'" target="_blank">записи</a>';
    } elseif($name == 'photo') {
     // фотография
     $description = 'Нажать мне нравится на <a href="http://vk.com/'.$url.'" target="_blank">фотографии</a>';
    } elseif($name == 'comment') {
     $description = 'Нажать мне нравится на <a href="http://vk.com/'.$url.'" target="_blank">комментарии</a>';
    }
    
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon like"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
           Нажмите <a href="#">сюда</a>, если хотите пожаловаться.
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="check'.$id.'" href="javascript://" onclick="task_check._like('.$id.');"><b>Выполнить задание</b></a>
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._ignored('.$id.');"><b>Не показывать</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 2) {
    // комментарии
    if($name == 'wall') { 
     // запись на стене
     $description = $text ? 'Оставить комментарий к записи «<a href="http://vk.com/'.$url.'" target="_blank">'.$text_min.'</a>»' : 'Оставить комментарий к <a href="http://vk.com/'.$url.'" target="_blank">записи</a>';
    } elseif($name == 'photo') {
     // фотография
     $description = 'Оставить комментарий к <a href="http://vk.com/'.$url.'" target="_blank">фотографии</a>';
    }
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div id="comment_hide'.$id.'" style="display: none">
           '.$comment_rand.'
          </div>
          <div class="_icon">
           <div class="icon comment"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
           Нажмите <a href="#">сюда</a>, если хотите пожаловаться.
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="check'.$id.'" href="javascript://" onclick="task_check._new_comment('.$id.', $(\'#comment_hide'.$id.'\').text(), \''.$url.'\');"><b>Выполнить задание</b></a>
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._ignored('.$id.');"><b>Не показывать</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 3) {
    // добавить в друзья
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon friend"></div>
          </div>
          <div class="_title">
           Подписаться на <a href="http://vk.com/id'.$url.'" target="_blank">'.$text_explode[0].'</a>
           <br />
           <div class="_support">
           Нажмите <a href="#">сюда</a>, если хотите пожаловаться.
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="check'.$id.'" href="javascript://" onclick="task_check._friend('.$id.');"><b>Выполнить задание</b></a>
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._ignored('.$id.');"><b>Не показывать</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 4) {
    // сообщества и группы
    if($id == 42712 || $id == 42966) {
     $bot = '<div style="color: red">Не вступайте в эту группу если Вы не бот!!!</div>';
     $points = '<span style="color: red">'.$price.'</span>';
    }
    else {
     $bot = '';
     $points = '+'.$price;
    }
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon group"></div>
          </div>
          <div class="_title">
           Вступить в группу <a href="http://vk.com/public'.$url.'" target="_blank">'.$text_min.'</a>
           <br />
           <div class="_support">
           Нажмите <a href="#">сюда</a>, если хотите пожаловаться.
           '.$bot.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           '.$points.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="check'.$id.'" href="javascript://" onclick="task_check._group('.$id.');"><b>Выполнить задание</b></a>
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._ignored('.$id.');"><b>Не показывать</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 5) {
    // опросы
    $description = $text ? 'Проголосовать <b>за '.$text.'-й вариант</b> в <a href="http://vk.com/wall'.$url.'" target="_blank">опросе</a>' : 'Проголосовать за любой вариант в <a href="http://vk.com/wall'.$url.'" target="_blank">опросе</a>';
    $template .= '<div class="task'.$active_task.'">
          <div class="_icon">
           <div class="icon poll"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
           Нажмите <a href="#">сюда</a>, если хотите пожаловаться.
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="check'.$id.'" href="javascript://" onclick="alert(\'Эта функция временно недоступна\')"><b>Выполнить задание</b></a>
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._ignored('.$id.');"><b>Не показывать</b></a>           
          </div>
         </div>
         ';
   }
  }
  if($template) {
   return $template.''.$page_sel; // выводим задания
  } else {
   return '<div style="color: gray; font-size: 12px; padding: 20px; text-align: center;">Не найдено заданий для выполнения...</div>';
  }
 }
 
 public function my($param = null) { // отображаем весь список заданий
  global $db, $links, $vkid, $tasks_done;
  $category = (int) $param['category']; // категория задания из адресной строки
  $vk_id = (int) $param['vk_id']; // id пользователя, у которого получаем задания
  $_repost = $db->escape($param['repost']); // id пользователя, у которого получаем задания
  $search = $db->escape($param['search']);
  $page = (int) $param['page'];
  $start_ent = $page * 50;
  
  // запрос на получение списка задания
  if($search) {
   $search_user = json_decode($links->get_user_id($search), true);
   $search_group = json_decode($links->get_group_id($search), true);
   $search_other = json_decode($links->get_all_info($search), true);
   
   $search_user_id = $db->escape($search_user['url']);
   $search_group_id = $db->escape($search_group['url']);
   $search_other_id = $db->escape($search_other['url']);
   
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost`, `tsuccess` FROM `tasks` WHERE `turl` = '$search_user_id' OR `turl` = '$search_group_id' OR `turl` = '$search_other_id' AND `tvk_id` = $vkid AND `tdel` != 1 ORDER BY `ttime` DESC");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `turl` = '$search_user_id' OR `turl` = '$search_group_id' OR `turl` = '$search_other_id' AND `tvk_id` = $vkid AND `tdel` != 1"));
  } elseif($category == 1 && $_repost == 'reposts') {
   // категория рассказать друзьям
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 1 AND `trepost` = 1 AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 50");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 1 AND `trepost` = 1 AND `tdel` != 1 AND `tsuccess` = 0"));
  } elseif($category == 1) {
   // категория мне нравится
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 1 AND `trepost` != 1 AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 50"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 1 AND `trepost` != 1 AND `tdel` != 1"));
  } elseif($category == 2) {
   // категория комментарий
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `tcomments`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 2 AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 30"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 2 AND `tdel` != 1"));
  } elseif($category == 3) {
   // категория подписаться
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 3 AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 50"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 3 AND `tdel` != 1"));
  } elseif($category == 4) {
   // категория вступить
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 4 AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 50"); 
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 4 AND `tdel` != 1"));
  } elseif($category == 5) {
   // категория опрос
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 5 AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 50");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tcategory` = 5 AND `tdel` != 1"));
  } else {
   // если нет категории
   $query = $db->query("SELECT `tid`, `tcategory`, `turl`, `tname`, `tfile_text`, `tcount`, `tprice`, `tdone_users`, `trepost`, `tcomments`, `tsuccess` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tdel` != 1 ORDER BY `ttime` DESC LIMIT $start_ent, 50");
   $num = mysql_num_rows(mysql_query("SELECT `tid` FROM `tasks` WHERE `tvk_id` = $vk_id AND `tdel` != 1"));
  }
  
  for($i = 0; $i <= $num; $i++) {
   $data = $db->fetch($query);
   $active_task = $i%2 ? ' active' : '';
   $id = $data['tid']; // id материала
   $cat = $data['tcategory']; // категория материала(лайки, комментарии и т.д.)
   $name = $data['tname']; // тип объекта(запись, фото и т.д.)
   $url = $data['turl']; // url
   $text = htmlspecialchars($data['tfile_text']); // текст записи или чего-то другого
   $text_min = mb_strlen($text, 'UTF-8') > 11 ? mb_substr($text, 0, 11, 'UTF-8').'...' : $text;  // текст записи или чего-то другого
   $text_explode = explode('|', $text); // разделение для имени и фамилии
   $count = $data['tcount']; // кол-во человек, которые должны выполнить задания
   $done = $data['tdone_users']; // кол-во человек, которые выполнили задание
   $price = $data['tprice']; // цена за задание
   $repost = $data['trepost']; // метка репоста
   $success = $data['tsuccess']; // метка о выполнении
   $comments = $data['tcomments']; // комментарии
   $comments_explode = explode('|', $comments); // комментарии
   array_pop($comments_explode);
   $comment_rand = Tasks::trim(trim(htmlspecialchars($comments_explode[rand(0, count($comments_explode) - 1)])));
   
   if($success == 1) {
    $status = 'Это задание <b class="success_task_f">выполнено</b>.';
   } else {
    $status = 'Это задание <b class="proccess_task_f">выполняется...</b>.';
   }
   
   // переключатель
   if(!$page && $num > 50) {
    $page_sel = '<div id="body_next_tasks"></div><div id="tasks_all_next_wrap"><div onclick="tasks._next(\''.$category.'\', \''.$repost.'\')" id="tasks_all_next">Показать ещё задания</div></div>';
   } else $page_sel = '';
   
   // шаблон материалов
   if($cat == 1 && $repost == 1) {
    // рассказать друзьям
    if($name == 'wall') { 
     // записи на стене
     $description = $text ? 'Рассказать друзьям о записи «<a href="http://vk.com/'.$url.'" target="_blank">'.$text_min.'</a>»' : 'Рассказать друзьям о <a href="http://vk.com/'.$url.'" target="_blank">записи</a>';
    }
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon repost"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
           '.$status.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._edit('.$id.', '.$count.', '.$price.')"><b>Редактировать</b></a>
           <a id="check'.$id.'" href="javascript://" onclick="tasks._del('.$id.')"><b>Удалить задание</b></a>           
          </div>
         </div>
         ';
   } else if($cat == 1) {
    // мне нравится
    if($name == 'wall') { 
     // записи на стене
     $description = $text ? 'Нажать мне нравится на записи «<a href="http://vk.com/'.$url.'" target="_blank">'.$text_min.'</a>»' : 'Нажать мне нравится на <a href="http://vk.com/'.$url.'" target="_blank">записи</a>';
    } elseif($name == 'photo') {
     // фотография
     $description = 'Нажать мне нравится на <a href="http://vk.com/'.$url.'" target="_blank">фотографии</a>';
    } elseif($name == 'comment') {
     $description = 'Нажать мне нравится на <a href="http://vk.com/'.$url.'" target="_blank">комментарии</a>';
    }
    
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon like"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
            '.$status.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._edit('.$id.', '.$count.', '.$price.')"><b>Редактировать</b></a>
           <a id="check'.$id.'" href="javascript://" onclick="tasks._del('.$id.')"><b>Удалить задание</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 2) {
    // комментарии
    if($name == 'wall') { 
     // запись на стене
     $description = $text ? 'Оставить комментарий к записи «<a href="http://vk.com/'.$url.'" target="_blank">'.$text_min.'</a>»' : 'Оставить комментарий к <a href="http://vk.com/'.$url.'" target="_blank">записи</a>';
    } elseif($name == 'photo') {
     // фотография
     $description = 'Оставить комментарий к <a href="http://vk.com/'.$url.'" target="_blank">фотографии</a>';
    }
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div id="comment_hide'.$id.'" style="display: none">
           '.$comment_rand.'
          </div>
          <div class="_icon">
           <div class="icon comment"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
            '.$status.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._edit('.$id.', '.$count.', '.$price.')"><b>Редактировать</b></a>
           <a id="check'.$id.'" href="javascript://" onclick="tasks._del('.$id.')"><b>Удалить задание</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 3) {
    // добавить в друзья
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon friend"></div>
          </div>
          <div class="_title">
           Подписаться на <a href="http://vk.com/id'.$url.'" target="_blank">'.$text_explode[0].'</a>
           <br />
           <div class="_support">
            '.$status.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._edit('.$id.', '.$count.', '.$price.')"><b>Редактировать</b></a>
           <a id="check'.$id.'" href="javascript://" onclick="tasks._del('.$id.')"><b>Удалить задание</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 4) {
    // сообщества и группы
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon group"></div>
          </div>
          <div class="_title">
           Вступить в группу <a href="http://vk.com/public'.$url.'" target="_blank">'.$text_min.'</a>
           <br />
           <div class="_support">
            '.$status.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._edit('.$id.', '.$count.', '.$price.')"><b>Редактировать</b></a>
           <a id="check'.$id.'" href="javascript://" onclick="tasks._del('.$id.')"><b>Удалить задание</b></a>           
          </div>
         </div>
         ';
   } elseif($cat == 5) {
    // опросы
    $description = $text ? 'Проголосовать <b>за '.$text.'-й вариант</b> в <a href="http://vk.com/wall'.$url.'" target="_blank">опросе</a>' : 'Проголосовать за любой вариант в <a href="http://vk.com/wall'.$url.'" target="_blank">опросе</a>';
    $template .= '<div id="task'.$id.'" class="task'.$active_task.'">
          <div id="error_task'.$id.'"></div>
          <div class="_icon">
           <div class="icon poll"></div>
          </div>
          <div class="_title">
           '.$description.'
           <br />
           <div class="_support">
            '.$status.'
           </div>
          </div>
          <div class="_count">
           '.$done.' из '.$count.'
          </div>
          <div class="_price">
           +'.$price.' '.declOfNum($price, array('монета', 'монеты', 'монет')).'
          </div>
          <div class="_run">
           <a id="ignored'.$id.'" href="javascript://" onclick="tasks._edit('.$id.', '.$count.', '.$price.')"><b>Редактировать</b></a>
           <a id="check'.$id.'" href="javascript://" onclick="tasks._del('.$id.')"><b>Удалить задание</b></a>           
          </div>
         </div>
         ';
   }
  }
  if($template) {
   return $template.''.$page_sel; // выводим задания
  } else {
   return '<div style="color: gray; font-size: 12px; padding: 20px; text-align: center;">Вы ещё не добавили ни одного задания...</div>';
  }
 }
 
 function info_task_add($url, $_cat, $repost) {
  global $db, $vkid;
  $q = $db->query("SELECT `tid` FROM `tasks` WHERE `tcategory` = $_cat AND `turl` = '$url' AND `tvk_id` = $vkid ORDER BY `ttime` DESC");
  $d = $db->fetch($q);
  
  return $db->num($q) ? $d['tid'] : 0;
 }
 
 function add($param = '') {
  global $db, $links, $vkid, $user_points, $ip, $browser, $time;
  $dbName = $db->dbName();
  $type = $db->escape($param['type']);
  $url = $db->escape($param['url']);
  $count = (int) abs($param['count']);
  $repost = '';
  $result_type = '';
  $price = (int) abs($param['price']);
  $_cat = '';
  $top = $param['top'] ? 1 : 0;
  
  if($type == 'likes') { // лайки
   $_cat = 1;
   $obj_get = json_decode($links->get_all_info($url), true);
   if($obj_get['error_code'] == 301) $json = array('error_code' => 301);
   elseif($obj_get['error_code'] == 300) $json = array('error_code' => 300);
   else {
    if($obj_get['type'] == 'wall') {
     $result_url = 'wall'.$obj_get['owner_id'].'_'.$obj_get['other_id'];
     $result_text = $obj_get['text'];
     $result_type = 'wall';
    } elseif($obj_get['type'] == 'comment') {
     $result_url = 'wall'.$obj_get['owner_id'].'_'.$obj_get['other_id'].'?reply='.$obj_get['reply'];
     $result_text = '';
     $result_type = 'comment';
    } elseif($obj_get['type'] == 'photo') {
     $result_url = 'photo'.$obj_get['owner_id'].'_'.$obj_get['other_id'];
     $result_text = '';
     $result_type = 'photo';
    }
   }
  } elseif($type == 'reposts') {
   $repost = 1;
   $_cat = 1;
   $obj_get = json_decode($links->get_all_info($url), true);
   if($obj_get['error_code'] == 301) $json = array('error_code' => 301);
   elseif($obj_get['error_code'] == 300) $json = array('error_code' => 300);
   if($obj_get['type'] == 'wall') {
    $result_url = 'wall'.$obj_get['owner_id'].'_'.$obj_get['other_id'];
    $result_text = '';
    $result_type = 'wall';
   } else $json = array('error_code' => 300);
  } elseif($type == 'friends') {
   $_cat = 3;
   $obj_get = json_decode($links->get_user_id($url), true);
   if($obj_get['error_code'] == 301) $json = array('error_code' => 301);
   elseif($obj_get['error_code'] == 300) $json = array('error_code' => 300);
   if($obj_get['type'] == 'user') {
    $result_url = $obj_get['url'];
    $result_text = $obj_get['user_fullname_acc'].'|'.$obj_get['user_fullname_dat'];
    $result_type = 'user';
   } else $json = array('error_code' => 300);
  } elseif($type == 'group') {
   $_cat = 4;
   $obj_get = json_decode($links->get_group_id($url), true);
   if($obj_get['error_code'] == 301) $json = array('error_code' => 301);
   elseif($obj_get['error_code'] == 300) $json = array('error_code' => 300);
   if($obj_get['type'] == 'group') {
    $result_url = $obj_get['url'];
    $result_text = $obj_get['title'];
    $result_type = 'group';
   } else $json = array('error_code' => 300);
  }
  
  $out_points = $top ? ($count * $price) + 10000 : $count * $price;
  if($result_type) {
   $task_last_info = Tasks::info_task_add($result_url, $_cat, $repost);
   if($user_points < $out_points) $json = array('error_code' => 333);
   elseif($count < 1) $json = array('error_code' => 320);
   elseif($count > 1000) $json = array('error_code' => 351);
   elseif($price < 5) $json = array('error_code' => 352);
   elseif($price > 60) $json = array('error_code' => 353);
   else {
    if($task_last_info) {
     if($db->query("UPDATE `$dbName`.`tasks` SET `tcount` = '$count', `tdone_users` = '0', `tprice` = '$price', `tsuccess` = 0, `tdel` = 0, `trepost` = '$repost', `tedit` = '$time', `top` = $top WHERE `tasks`.`tid` = $task_last_info;")) {
      $db->query("UPDATE `$dbName`.`users` SET `points` = $user_points - $out_points WHERE `users`.`vk_id` = $vkid;");
      $json = array('error_code' => 1, 'points' => $out_points);
     } else {
      $json = array('error_code' => 302);
     }
    } else {
     if($db->query("INSERT INTO `$dbName`.`tasks` (`tid`, `tvk_id`, `tip_address`, `tdate`, `ttime`, `tcategory`, `tname`, `tfile_text`, `turl`, `tcomments`, `tcount`, `tprice`, `tdone_users`, `tsuccess`, `tdel`, `tedit`, `tdel_admin`, `trepost`, `top`) VALUES (NULL, '$vkid', '$ip', '', '$time', '$_cat', '$result_type', '$result_text', '$result_url', '', '$count', '$price', '', '', '', '', '', '$repost', '$top');")) {
      $db->query("UPDATE `$dbName`.`users` SET `points` = $user_points - $out_points WHERE `users`.`vk_id` = $vkid;");
      $json = array('error_code' => 1, 'points' => $out_points);
     } else {
      $json = array('error_code' => 302);
     }
    }
   }
  } else $json = array('error_code' => 300);
  
  return json_encode($json);
 }
 
 function check($id) {
  global $db, $vkid, $user_points, $tasks_done, $tasks_summ_done, $links, $logs, $vk_codes_error, $token, $time;
  $task_id = (int) $id;
  $comment = $db->escape(trim($_GET['comment']));
  $q = $db->query("SELECT `tid`, `turl`, `tcategory`, `tname`, `tvk_id`, `tprice`, `tcount`, `tdone_users`, `trepost`, `tsuccess`, `tcomments` FROM `tasks` WHERE `tid` = $task_id");
  $d = $db->fetch($q);
  $dbName = $db->dbName();
  
  $id = $d['tid'];
  $url = $d['turl'];
  $cat = $d['tcategory'];
  $name = $d['tname'];
  $price = $d['tprice'];
  $repost = $d['trepost'];
  $count = $d['tcount'];
  $done = $d['tdone_users'];
  $to = $d['tvk_id'];
  $success = $d['tsuccess'];
  $_comments_explode = explode('|', Tasks::trim($d['tcomments']));
  array_pop($_comments_explode);
  
  $_tasks_done = $tasks_done ? $tasks_done : 0;
  $_tasks_done_explode = explode(',', $_tasks_done);
  $_tasks_done_plus = $_tasks_done.','.$id;
  $_points_plus = $user_points + $price;
  
  preg_match('/(.*?)\-?([0-9]+)_([0-9]+)/', $url, $matches);
  $url_full = $matches[0];
  $url_full_explode = explode('_', $url_full);
  $url_full_array = array('wall', 'photo');
  $url_full_result = str_replace($url_full_array, '', $url_full_explode[0]);
  $url_name = $matches[1];
  $owner_id = $url_full_result;
  $other_id = $matches[3];
  $type_like = str_replace('wall', 'post', $url_name);
    
  if(!$id) {
   $json = array('error_code' => 2, 'text' => 'task is not found');
  } else {
   if($cat == 1) {
    $other_api = json_decode($links->get_all_info('http://vk.com/'.$url_full), true);
    if($repost) {
     $api = json_decode(file_get_contents('https://api.vk.com/method/likes.getList?type='.$type_like.'&owner_id='.$other_api['owner_id'].'&item_id='.$other_api['other_id'].'&filter=copies&count=1000&access_token='.$token));
     if(@in_array($vkid, $api->response->users)) {
      $error = 1;
     } else {
      $error = 2;
     }
    } else {
     $api = json_decode(file_get_contents('https://api.vk.com/method/likes.getList?type='.$type_like.'&owner_id='.$other_api['owner_id'].'&item_id='.$other_api['other_id'].'&count=1000&access_token='.$token));
     if(@in_array($vkid, $api->response->users)) {
      $error = 1;
     } else {
      $error = 2;
     }
    }
   } elseif($cat == 3) {
    $api = json_decode(file_get_contents('https://api.vk.com/method/subscriptions.getFollowers?uid='.$url.'&count=1000&access_token='.$token));
    $other_api = json_decode(file_get_contents('https://api.vk.com/method/friends.get?uid='.$url.'&count=1000&timestamp='.$time.'&random='.rand().'&access_token='.$token));
    if(@in_array($vkid, $api->response->users) || @in_array($vkid, $other_api->response)) {
     $error = 1;
    } else {
     $error = 2;
    }
   } elseif($cat == 4) {
    $api = json_decode(file_get_contents('https://api.vk.com/method/groups.getMembers?gid='.$url.'&sort=time_desk&access_token='.$token));
    if(@in_array($vkid, $api->response->users)) {
     $error = 1;
    } else {
     $error = 2;
    }
   } elseif($cat == 2) {
    if($name == 'wall') {
     $api = json_decode(file_get_contents('https://api.vk.com/method/wall.getComments?post_id='.$other_id.'&owner_id='.$owner_id.'&count=100&sort=desc&access_token='.$token), true);
    } elseif($name == 'photo') {
     $api = json_decode(file_get_contents('https://api.vk.com/method/photos.getComments?pid='.$other_id.'&owner_id='.$owner_id.'&count=100&sort=desc&access_token='.$token), true);
    }
    if($name == 'wall') {
     $error = '';
     for($i = 0; $i <= $api['response'][0]; $i++) {
      if($api['response'][$i]['uid'] == $vkid) {
       if($api['response'][$i]['text'] == $comment) $error = 1;
       else $error = 2;
       break;
      } else $error = 2;
     }
    } elseif($name == 'photo') {
     $error = '';
     for($i = 0; $i <= $api['response'][0]; $i++) {
      if($api['response'][$i]['from_id'] == $vkid) {
       if($api['response'][$i]['message'] == $comment) $error = 1;
       else $error = 2;
       break;
      } else $error = 2;
     }
    }
   }
   if(!$vkid) {
    $json = array('error_code' => 4);
   } elseif($to == $vkid) {
    $json = array('error_code' => 24);
   } elseif(@!in_array($comment, $_comments_explode) && $cat == 2) {
    $json = array('error_code' => 21);
   } elseif($success) {
    $json = array('error_code' => 9);
   } elseif(@in_array($id, $_tasks_done_explode)) {
    $json = array('error_code' => 3);
   } elseif(@in_array($api->error->error_code, $vk_codes_error)) {
    $json = array('error_code' => 301);
   } elseif($error == 1) {
    if($db->query("UPDATE `$dbName`.`users` SET `tasks_done` = '$_tasks_done_plus', `points` = $_points_plus, `tasks_summ_done` = $tasks_summ_done + 1 WHERE `users`.`vk_id` = $vkid;")) {
     // редактируем счётчик задания
     $db->query("UPDATE `$dbName`.`tasks` SET `tdone_users` =  $done + 1 WHERE  `tasks`.`tid` = $id;");
     if($done + 1 == $count) $db->query("UPDATE `$dbName`.`tasks` SET `tsuccess` = 1, `top` = 0 WHERE  `tasks`.`tid` = $id;");
     $logs->task_done($vkid, $to, $price, $id);
     $json = array('error_code' => 1, 'points' => $price);
    } else {
     $json = array('error_code' => 6);
    }
   } elseif($error == 2) {
    $json = array('error_code' => 2);
   }
  }
  return json_encode($json);
 }
 
 function delete($id) {
  global $db, $logs, $vkid, $user_points;
  $dbName = $db->dbName();
  $task_id = (int) $id;
  
  $q = $db->query("SELECT `tid`, `tvk_id`, `tprice`, `tcount`, `tdone_users`, `tdel` FROM `tasks` WHERE `tid` = $task_id");
  $d = $db->fetch($q);
  
  $id = $d['tid'];
  $count = $d['tcount'];
  $price = $d['tprice'];
  $done = $d['tdone_users'];
  $to = $d['tvk_id'];
  $del = $d['tdel'];
  $return_points = $price * ($count - $done);
  
  if(!$vkid) $json = array('error' => '!uid');
  elseif(!$id) $json = array('error' => '!id');
  elseif($del) $json = array('error' => '!del');
  elseif($to != $vkid) $json = array('error' => '!my');
  else {
   if($db->query("UPDATE `$dbName`.`tasks` SET `tdel` = 1 WHERE `tasks`.`tid` = $task_id;")) {
    // меняем поинты
    $db->query("UPDATE `$dbName`.`users` SET `points` = $user_points + $return_points WHERE `users`.`vk_id` = $vkid;");
    // лог
    $logs->task_del($vkid, $return_points, $id);
    $json = array('error' => 'success', 'points' => $return_points);
   } else {
    $json = array('error' => '!db');
   }
  }
  return json_encode($json);
 }
 
 function edit($id = '', $count = '', $price = '') {
  global $db, $logs, $vkid, $user_points, $tasks_done, $time;
  $dbName = $db->dbName();
  $task_id = (int) $id;
  $new_count = (int) abs($count);
  
  $q = $db->query("SELECT `tid`, `tvk_id`, `tcount`, `tprice`, `tdel`, `tsuccess` FROM `tasks` WHERE `tid` = $task_id");
  $d = $db->fetch($q);
  
  $id = $d['tid'];
  $to = $d['tvk_id'];
  $count = $d['tcount'];
  $price = $d['tprice'];
  $del = $d['tdel'];
  $success = $d['tsuccess'];
  
  $result_points = round($new_count * $price + ($new_count * $price /100) * 10);
  $result_points_out = $user_points - $result_points;
  
  if(!$vkid) $json = array('error' => '!uid');
  elseif(!$id) $json = array('error' => '!id');
  elseif($vkid != $to) $json = array('error' => '!my');
  elseif($tdel) $json = array('error' => '!del');
  elseif($new_count < 1) $json = array('error' => '!count_min');
  elseif($success && !$new_count) $json = array('error' => '!success');
  elseif($user_points < $result_points) $json = array('error' => '!points');
  else {
   if($db->query("UPDATE `$dbName`.`tasks` SET `tcount` =  $count + $new_count, `tsuccess` = 0 WHERE  `tasks`.`tid` = $id;")) {
    $db->query("UPDATE `$dbName`.`users` SET `points` = $result_points_out WHERE `users`.`vk_id` = $vkid;");
    $logs->task_edit($vkid, $result_points, $id, $new_count, $new_price, $count, $price);
    $json = array('error' => 'success', 'points' => $result_points);
   } else {
    $json = array('error' => '!db');
   }
  }
  return json_encode($json);
 }
 
 function ignored($id) {
  global $db, $logs, $vkid, $tasks_done;
  $dbName = $db->dbName();
  $task_id = (int) $id;
  $done_array = explode(',', $tasks_done);
  
  $q = $db->query("SELECT `tid` FROM `tasks` WHERE `tid` = $task_id");
  $d = $db->fetch($q);
  
  $id = $d['tid'];
  $_tasks_done_plus = $tasks_done.','.$id;
  
  if(!$vkid) $json = array('error' => '!uid');
  elseif(!$id) $json = array('error' => '!id');
  elseif(in_array($task_id, $done_array)) $json = array('error' => '!ignored');
  else {
   if($db->query("UPDATE `$dbName`.`users` SET `tasks_done` = '$_tasks_done_plus' WHERE `users`.`vk_id` = $vkid;")) {
    $logs->task_ignored($vkid, '', $id);
    $json = array('error' => 'success');
   } else {
    $json = array('error' => '!db');
   }
  }
  return json_encode($json);
 }
 
 public function complaints() {
  global $db;
  $limit = time() - (40 * 60);
  $q = $db->query("SELECT logs.lid, logs.lfrom, logs.lmid, tasks.turl, tasks.tcategory, tasks.trepost FROM `logs` INNER JOIN `tasks` ON logs.lmid = tasks.tid WHERE logs.lmodule = 2 AND logs.ltype = 1 AND logs.ltime > $limit ORDER BY logs.lid DESC LIMIT 600");
  while($d = $db->fetch($q)) {
   $id = $d['lid'];
   $user_id = $d['lfrom'];
   $category = $d['tcategory'];
   $repost = $d['trepost'];
   $url = $d['turl'];
   
   if($category == 1 && !$repost) $title = '<b>Нажать "мне нравится"</b> <u><a target="_blank" href="http://vk.com/'.$url.'">http://vk.com/'.$url.'</a></u>';
   elseif($category == 1 && $repost) $title = '<b>Рассказать друзьям</b> <u><a target="_blank" href="http://vk.com/'.$url.'">http://vk.com/'.$url.'</a></u>';
   elseif($category == 3) $title = '<b>Подписаться на</b> <u><a target="_blank" href="http://vk.com/id'.$url.'">http://vk.com/id'.$url.'</a></u>';
   elseif($category == 4) $title = '<b>Вступить в группу</b> <u><a target="_blank" href="http://vk.com/public'.$url.'">http://vk.com/id'.$url.'</a></u>';
   
   $template .= '
    <div class="task">
     <div class="left">
      <div class="title">
       '.$id.'. '.$title.'
      </div>
      <div class="info">
       Выполнил <a href="http://vk.com/id'.$user_id.'" target="_blank">id'.$user_id.'</a>
      </div>
     </div>
     <div class="right">
       <div id="btn_complt'.$id.'" style="width: 200px; text-align: center;" onclick="complaint._add('.$user_id.', '.$id.');" class="box_button_first_wrap"><div id="btn_complt2'.$id.'" class="box_buttons box_button_first">Оштрафовать на <b>1000 монет</b></div></div>
     </div>
    </div>
   ';
  }
  return $template;
 }
 
 public function complaint_add($id, $eid) {
  global $db, $time, $user_group;
  $user_id = (int) $id;
  $entry_id = (int) $eid;
  $q = $db->query("SELECT `points`, `complaints` FROM `users` WHERE `vk_id` = $user_id");
  $d = $db->fetch($q);
  $dbName = $db->dbName();
  
  $points = $d['points'];
  $complaint = $d['complaints'];
  
  if($user_group == 4) {
   if($db->query("UPDATE `$dbName`.`users` SET `complaints` = $complaint + 1, `points` = $points - 1000 WHERE `users`.`vk_id` = $user_id;")) {
    $db->query("UPDATE `$dbName`.`logs` SET `ltext` = '$time' WHERE `logs`.`lid` = $entry_id;");
    return 1;
   } else return 2;
  }
 }

 public function clear_tasks(){
 
  global $db, $logs, $vkid, $user_points, $tasks_done, $time;
  $dbName = $db->dbName();

   $q = $db->query("SELECT `tid` FROM `tasks` WHERE `tcount`>= `tdone_users` OR `tdel`=1");
   
   $d = $db->fetch($q);
   
   
  
 }
}


$tasks = new Tasks;
?>