<?php
class Profile {
 public function user_change_hash($cookie_hash, $db_hash, $vkid, $page_name) { // если сменён hash или закончились куки
  if($cookie_hash != $db_hash) {
   setCookie('_user_id', $vkid, time() - 86400, '/');
   setCookie('_user_hash', $cookie_hash, time() - 86400, '/');
   header('Location: /');
   exit;
  } else {
   if($page_name == 'main') {
    header('Location: /tasks');
    exit;
   }
  }
 }
}

$profile = new Profile;
?>