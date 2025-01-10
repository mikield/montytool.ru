<?php
setCookie('_user_id', $_COOKIE['_user_id'], time() - 86400, '/');
setCookie('_user_hash', $_COOKIE['_user_hash'], time() - 86400, '/');
header('Location: /');
?>