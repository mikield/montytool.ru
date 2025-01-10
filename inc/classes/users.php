<?php
class Users {
 public function check_login($login = '') { // проверяем логин на занятость
  global $db;
  if(!$q = $db->query("SELECT `id` FROM `users` WHERE `login` = '$login'")) return 601;
  else {
   if($db->num($q)) {
    return 600;
   } else {
    return 602;
   }
  }
 }
 
 public function check_vkid($vkid = '') { // проверяем id ВК на занятость
  global $db;
  if(!$q = $db->query("SELECT `id` FROM `users` WHERE `vk_id` = '$vkid'")) return 701;
  else {
   if($db->num($q)) {
    return 700;
   } else {
    return 702;
   }
  }
 }
 
 public function returned($param = '') {
  global $db, $logs, $links;
  $url = $db->escape($param['url']);
  $password = $db->escape($param['password']);
  $password_md5 = $db->escape(md5(md5($param['password'])));
  $get_user = $links->get_user_id($url);
  $get_user_id = json_decode($get_user, true);
  $get_user_id_result = (int) $get_user_id['user_id'];
  $dbName = $db->dbName();
  $hash = user_hash($password);
  
  
  $get_status = json_decode($links->get_status($get_user_id['user_id']), true);
  $statuses = array('Счастье имеет смысл только тогда, когда есть с кем его разделить '.rand(), 'Есть те, с кем легко, а есть те, к кому тянет '.rand(), 'Тому, кто умеет ждать, всегда достается самое лучшее '.rand());
  $result_status = $_SESSION['ustatus'.$get_user_id_result] ? $_SESSION['ustatus'.$get_user_id_result] : $_SESSION['ustatus'.$get_user_id_result] = $statuses[rand(0, count($statuses) - 1)]; 
  if(!$get_user_id_result) $json = array('error' => '!url');
  elseif(!preg_match('/^([-_.@a-zA-Z0-9]){1,50}$/i', $password)) $json = array('error' => '!password'); // проверяем пароль на верность
  elseif(mb_strlen($result_status, 'UTF-8') < 2) $json = array('error' => '!status', 'text' => '...'); // проверяем статус
  elseif($get_status['text'] != $result_status) $json = array('error' => '!status', 'text' => $result_status); // проверяем статус
  else {
   $q = $db->query("SELECT `id`, `login` FROM `users` WHERE `vk_id` = $get_user_id_result");
   $d = $db->fetch($q);
   if(@mysql_num_rows($q)) {
    if($db->query("UPDATE `$dbName`.`users` SET `password` = '$password_md5', `hash` = '$hash' WHERE `users`.`vk_id` = $get_user_id_result;")) { 
     $logs->return_password($get_user_id_result);
     $json = array('error' => 'success', 'login' => $d['login'], 'password' => $password);
    } else {
     $json = array('error' => '!db');
    }
   } else {
    $json = array('error' => '!id');
   }
  }
  return json_encode($json);
 }
 
 public function login($param = '') {
  global $db, $logs;
  $login = $db->escape($param['login']);
  $password = $db->escape(md5(md5($param['password'])));
  
  $q = $db->query("SELECT `vk_id`, `password`, `hash` FROM `users` WHERE `login` = '$login'");
  $d = $db->fetch($q);
  $_vkid = $d['vk_id'];
  $_password = $d['password'];
  $_hash = $d['hash'];
  
  if(isset($_COOKIE['_user_id'])) { // если авторизация уже проходилась
   $json = array('error_code' => 402, 'error_text' => 'access denied');
  } else if($_password == '1') { // если пароль не установлен вообще
   $json = array('error_code' => 400, 'error_text' => 'access denied');
  } elseif($password == $_password) { // если пароль верный
   if(setCookie('_user_id', $_vkid, time() + 86400, '/') && setCookie('_user_hash', $_hash, time() + 86400, '/')) {
    // если установились куки
    $logs->auth($_vkid); // записываем информацию в лог
    $json = array('error_code' => 1);
   } else {
    // если куки не установились
    $json = array('error_code' => 401, 'error_text' => 'cookies is error');
   }
  } else {
   // если логин или пароль неверные
   $json = array('error_code' => 2, 'error_text' => 'auth is error');
  }
  return json_encode($json);
 }
 
 public function reg($param = '') {
  global $db, $token, $links, $logs, $ip, $browser, $time;
  $dbName = $db->dbName();
  $url = $db->escape($param['url']);
  $login = $db->escape($param['login']);
  $password = $param['password'];
  $password_md5 = $db->escape(md5(md5($password)));
  
  $get_user = $links->get_user_id($url);
  $get_user_id = json_decode($get_user, true);
  $get_user_friend = json_decode($links->get_user_followers(152585671, $get_user_id['user_id']), true);
  $check_url = json_decode($get_user, true);
  $check_login = Users::check_login($login);
  $check_vkid = Users::check_vkid($get_user_id['user_id']);
  
  if($check_url['error_code'] == 300) $json = array('error_code' => 300);
  elseif($check_url['error_code'] == 301) $json = array('error_code' => 301);
  elseif($check_vkid != 702) $json = array('error_code' => $check_vkid); // проверяем занятость id ВК
  elseif(!preg_match('/^([-_.@a-zA-Z0-9]){1,30}$/i', $login)) $json = array('error_code' => 307); // проверяем логин на верность
  elseif($check_login != 602) $json = array('error_code' => $check_login); // проверяем занятость логина
  elseif(!preg_match('/^([-_.@a-zA-Z0-9]){6,50}$/i', $password)) $json = array('error_code' => 308); // проверяем пароль на верность
  elseif($get_user_friend['error_code'] == 601) $json = array('error_code' => 301);
  elseif($get_user_friend['error_code'] != 1) $json = array('error_code' => 309);
  else {
   $hash = user_hash($password);
   $user_info = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids='.$get_user_id['user_id'].'&fields=photo,sex&access_token='.$token), true);
   $user_id = $user_info['response'][0]['uid'];
   $user_name = $user_info['response'][0]['first_name'];
   $user_surname = $user_info['response'][0]['last_name'];
   $user_avatar = $user_info['response'][0]['photo'];
   $user_gender = $user_info['response'][0]['sex'];
   if($db->query("INSERT INTO `$dbName`.`users` (`id`, `login`, `password`, `vk_id`, `first_name`, `last_name`, `avatar`, `gender`, `ip_address`, `reg_time`, `group`, `points`, `tasks_done`, `ref_count`, `agent_num`, `agent_ava`, `agent_rate_plus`, `agent_rate_minus`, `agent_questions`, `agent_answers`, `agent_last`, `hash`, `browser`, `time_zone`, `last_time`, `ban`, `ban_time`, `ban_text`, `tasks_summ_done`, `rate`, `complaints`) VALUES (NULL, '$login', '$password_md5', '$user_id', '$user_name', '$user_surname', '$user_avatar', '$user_gender', '$ip', '$time', '0', '0', '', '', '', '', '', '', '', '', '', '$hash', '$browser', '', '$time', '', '', '', '', '', '');") && $user_id) {
    setCookie('_user_id', $user_id, time() + 86400, '/');
    setCookie('_user_hash', $hash, time() + 86400, '/');
    $json = array('error_code' => 1);
   } else {
    $json = array('error_code' => 601);
   }
  }
  return json_encode($json);
 }
}

$users = new Users();
?>