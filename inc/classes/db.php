
<?php
class db {
 public $link;
 public $result;
        
 public function __construct($hostName = '', $hostUser = '', $hostPass = '', $dbName = '') { // ���������� � ����� ������
  $this->link = mysql_connect($hostName, $hostUser, $hostPass);
  mysql_select_db($dbName);
  mysql_query("SET NAMES utf8");
 }
 
 public function query($q = '') { // ������� � ���� ������
  return @mysql_query($q);
 }
 
 public function dbName() {
  return 'user1734_monty';
 }
 
 public function fetch($result = '') { // �������� ������
  $result = $this->result;
  return mysql_fetch_array($result);
 }
 
 public function num($result = '') { // ���-�� �������
  $result = $this->result;
  return mysql_num_rows($result);
 }
 
 public function escape($string = '') {
  return mysql_real_escape_string($string);
 }
 
 public function __destruct() { // ��������� ���������� � ����� ������
  mysql_close($this->link);
 }
}

$db = new db('localhost', 'user1734_modal', '5658280aq', 'user1734_monty');
?>