
<?php
class db {
 public $link;
 public $result;
        
 public function __construct($hostName = '', $hostUser = '', $hostPass = '', $dbName = '') { // соединение с базой данных
  $this->link = mysql_connect($hostName, $hostUser, $hostPass);
  mysql_select_db($dbName);
  mysql_query("SET NAMES utf8");
 }
 
 public function query($q = '') { // запросы к базе данных
  return @mysql_query($q);
 }
 
 public function dbName() {
  return 'user1734_monty';
 }
 
 public function fetch($result = '') { // получаем данные
  $result = $this->result;
  return mysql_fetch_array($result);
 }
 
 public function num($result = '') { // кол-во записей
  $result = $this->result;
  return mysql_num_rows($result);
 }
 
 public function escape($string = '') {
  return mysql_real_escape_string($string);
 }
 
 public function __destruct() { // закрываем соединение с базой данных
  mysql_close($this->link);
 }
}

$db = new db('localhost', 'user1734_modal', '5658280aq', 'user1734_monty');
?>