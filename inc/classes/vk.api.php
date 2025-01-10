<?php
class Links {
 public function check($url) { // проверяем правильность ссылки
  if(preg_match('/^vk.com\//', $url) || preg_match('/^http:\/\/vk.com\//', $url) || preg_match('/^https:\/\/vk.com\//', $url)) {
   // правильная ссылка
   return 1;
  } else {
   // неправильная ссылка
   return 0;
  }
 }
 
 public function last($url) { // получаем последнюю часть ссылки
  $url = explode('/', $url);
  return $url[count($url) - 1];
 }
 
 public function get_user_followers($from, $to) {
  global $token, $vk_codes_error;
  $api = json_decode(file_get_contents('https://api.vk.com/method/subscriptions.getFollowers?uid='.$from.'&count=1000&access_token='.$token), true);
  if(in_array($api['error']['error_code'], $vk_codes_error)) {
   $json = array('error_code' => 301);
  } else {
   if($api['response']) {
    if(in_array($to, $api['response']['users'])) {
     $json = array('error_code' => 1);
    } else {
     $json = array('error_code' => 301);
    }
   }
  }
  return json_encode($json);
 }
 
 public function get_user_id($url = '') { // получаем информацию о пользователе
  global $token;
  if(!Links::check($url)) {
   // если ссылка неверная
   $json = array('error_code' => 300);
  } else {
   // получаем информацию
   $last = preg_match('/^id([0-9]+)$/i', Links::last($url)) ? str_replace('id', '', Links::last($url)) : Links::last($url);
   // винительный падеж
   $api = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids='.$last.'&name_case=acc&access_token='.$token), true);
   // дательный падеж
   $api2 = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids='.$last.'&name_case=dat&access_token='.$token), true);
   
   if(!$api['response']) {
    $json = array('error_code' => 301);
   } elseif($api['response'][0]['first_name'] == "DELETED" || !$api['response'][0]['uid']) {
    // если ссылка неверная
    $json = array('error_code' => 300);
   } else {
    $json = array('error_code' => 1, 'user_id' => $api['response'][0]['uid'], 'user_fullname_acc' => $api['response'][0]['first_name'].' '.$api['response'][0]['last_name'], 'user_fullname_dat' => $api2['response'][0]['first_name'].' '.$api2['response'][0]['last_name'], 'url' => $api['response'][0]['uid'], 'type' => 'user');
   }
  }
  return jdecoder(json_encode($json));
 }
 
 public function get_group_id($url = '') {
  global $token, $vk_codes_error;
  if(!Links::check($url)) {
   // если ссылка неверная
   $json = array('error_code' => 300);
  } else {
   if(preg_match('/^public([0-9]+)$/i', Links::last($url))) $last = str_replace('public', '', Links::last($url));
   elseif(preg_match('/^club([0-9]+)$/i', Links::last($url))) $last = str_replace('club', '', Links::last($url));
   else $last = Links::last($url);
   $api = json_decode(file_get_contents('https://api.vk.com/method/groups.getById?gid='.$last.'&access_token='.$token), true);
   if($api['error']['error_code'] == 200 || $api['response'][0]['name'] == 'DELETED') {
    $json = array('error_code' => 300);
   } elseif(in_array($api['error']['error_code'], $vk_codes_error)) {
    $json = array('error_code' => 301);
   } else {
    if($api['response']) {
     $json = array('error_code' => 1, 'group_id' => $api['response'][0]['gid'], 'title' => $api['response'][0]['name'], 'closed' => $api['response'][0]['is_closed'], 'type' => 'photo', 'url' => $api['response'][0]['gid'], 'type' => 'group');
    } else {
     $json = array('error_code' => 301);
    }
   }
  }
  return json_encode($json);
 }
 
 public function get_status($id) {
  global $token, $vk_codes_error;
  $api = json_decode(file_get_contents('https://api.vk.com/method/status.get?uid='.$id.'&access_token='.$token), true);
  if(in_array($api['error']['error_code'], $vk_codes_error)) {
   $json = array('error_code' => 301);
  } else {
   $json = array('text' => $api['response']['text']);
  }
  return json_encode($json);
 }
 
 public function get_all_info($url = '') {
  global $token, $vk_codes_error;
  if(!Links::check($url)) {
   // если ссылка неверная
   $json = array('error_code' => 300);
  } else {
   if(preg_match('/photo\-?([0-9]+)_([0-9]+)/', $url)) {
    preg_match('/photo\-?([0-9]+)_([0-9]+)/', $url, $result);
    $explode_id = explode('_', str_replace('photo', '', $result[0]));
    $owner_id = $explode_id[0];
    $other_id = $explode_id[1];
    $api = json_decode(file_get_contents('https://api.vk.com/method/photos.getById?photos='.$owner_id.'_'.$other_id.'&access_token='.$token), true);
    if($api['error']['error_code'] == 200) {
     $json = array('error_code' => 300);
    } elseif(in_array($api['error']['error_code'], $vk_codes_error)) {
     $json = array('error_code' => 301);
    } else {
     if($api['response']) {
      $json = array('error_code' => 1, 'owner_id' => $owner_id, 'other_id' => $other_id, 'url' => 'photo'.$owner_id.'_'.$other_id, 'type' => 'photo');
     } else {
      $json = array('error_code' => 301);
     }
    }
   } elseif(preg_match('/wall\-?([0-9]+)_([0-9]+)/', $url)) {
    preg_match('/wall\-?([0-9]+)_([0-9]+)/', $url, $result);
    preg_match('/wall\-?([0-9]+)_([0-9]+)\?reply=([0-9]+)/', $url, $reply);
    $explode_id = explode('_', str_replace('wall', '', $result[0]));
    $owner_id = $explode_id[0];
    $other_id = $explode_id[1];
    $api = json_decode(file_get_contents('https://api.vk.com/method/wall.getById?posts='.$owner_id.'_'.$other_id.'&access_token='.$token), true);
    $pid = $api['response'][0]['attachment']['poll']['poll_id'].''.$api['response'][0]['attachments'][1]['poll']['poll_id'].''.$api['response'][0]['attachments'][2]['poll']['poll_id'].''.$api['response'][0]['attachments'][3]['poll']['poll_id'].''.$api['response'][0]['attachments'][4]['poll']['poll_id'].''.$api['response'][0]['attachments'][5]['poll']['poll_id'].''.$api['response'][0]['attachments'][6]['poll']['poll_id'].''.$api['response'][0]['attachments'][7]['poll']['poll_id'].''.$api['response'][0]['attachments'][8]['poll']['poll_id'].''.$api['response'][0]['attachments'][9]['poll']['poll_id'].''.$api['response'][0]['attachments'][10]['poll']['poll_id'].''.$api['response'][0]['attachments'][11]['poll']['poll_id'];
    if($api['error']['error_code'] == 200) {
     $json = array('error_code' => 300);
    } elseif(in_array($api['error']['error_code'], $vk_codes_error)) {
     $json = array('error_code' => 301);
    } else {
     if($api['response']) {
      if($reply[3]) {
       $json = array('error_code' => 1, 'owner_id' => $owner_id, 'other_id' => $other_id, 'reply' => $reply[3], 'url' => 'wall'.$owner_id.'_'.$other_id, 'type' => 'comment', 'text' => $api['response'][0]['text'], 'pid' => $pid);
      } else {
       $json = array('error_code' => 1, 'owner_id' => $api['response'][0]['copy_owner_id'] ? $api['response'][0]['copy_owner_id'] : $owner_id, 'other_id' => $api['response'][0]['copy_post_id'] ? $api['response'][0]['copy_post_id'] : $other_id, 'reply' => $reply[3], 'type' => 'wall', 'text' => $api['response'][0]['text'], 'pid' => $pid);
      }
     } else {
      $json = array('error_code' => 301);
     }
    }
   }
  }
  return json_encode($json);
 }
 
 function check_like($id, $url) {
  global $token;
 }
}

$links = new Links();
?>