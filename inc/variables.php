<?php
$ip = ip_address(); // ip
$browser = user_browser(); // браузер
$time = time(); // unixtime
$hash = $db->escape($_COOKIE['_user_hash']); // hash
$vkid = (int) $_COOKIE['_user_id'];
$tokens = array('7cd5e8a59225cd1ea3e13052bcfaecff604d21366920c9ed905c7511bc1158fffca6c18a2683478746d8f', 'a2f692bfbc5c285c074704e99d017b94902c346e589642125133b3dd5c62d86c9096573c84d2681b7be67', 'dad13fa253910e42fbfd4ead56d0f21818b02e2d9f7c3d7b79b49ac1bd06245620e0dadbe950210322fce', 'df38fc1e46d2a6567c3b29414ec54ef5ae525524444d489467a195d58869131396df08a8d8dd8429e8a08', '598da3db5e396271f865892572535f5db7e67d9f19b94695538f7e0d5b5c1c88ecc357fc78e5e8e4c3b24', 'd7bd320ac4f535f77776ca3b82dee30e0e7128cd8b7c7e389f08f634296484613ec27ca3eb598d774cec4', '24c65745eb55855621b1306056c61d6188807e6aa2bcf8f8f8967263c7bd4f38a1efdfc42d54bd6dd9508');
$token = $tokens[rand(0, count($tokens) - 1)];
$vk_codes_error = array(1, 2, 4, 5, 6, 7);
?>