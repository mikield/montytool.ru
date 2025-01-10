<?php
class Logs {
 public function auth($vk_id = '') {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`) VALUES (NULL, '$vk_id', '$vk_id', '$ip', '$time', '$browser', '1', '1', '', '', '', '', '', '', '', '1');");
 }
 
 public function reg($vk_id = '') {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`) VALUES (NULL, '$vk_id', '$vk_id', '$ip', '$time', '$browser', '2', '1', '', '', '', '', '', '', '', '1');");
 }
 
 public function return_password($vk_id = '') {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`) VALUES (NULL, '$vk_id', '$vk_id', '$ip', '$time', '$browser', '3', '1', '', '', '', '', '', '', '', '1');");
 }
 
 public function task_done($from = '', $to = '', $price = '', $id = '') {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`) VALUES (NULL, '$from', '$to', '$ip', '$time', '$browser', '1', '2', '$id', '$from', '', '1', '$price', '', '', '0');");
 }
 
 public function task_del($from = '', $points = '', $id = '') {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`) VALUES (NULL, '$from', '$from', '$ip', '$time', '$browser', '2', '2', '$id', '$from', '', '1', '$points', '', '', '1');");
 }
 
 public function task_ignored($from = '', $points = '', $id = '') {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`) VALUES (NULL, '$from', '$from', '$ip', '$time', '$browser', '3', '2', '$id', '$from', '', '0', '$points', '', '', '1');");
 }
 
 public function task_edit($from = '', $points = '', $id = '', $new_count, $new_price, $old_count, $old_price) {
  global $db, $ip, $browser, $time;
  $dbName = $db->dbName();
  $template = '{"new_count" : "'.$new_count.'", "new_price" : "'.$new_price.'", "old_count" : "'.$old_count.'", "old_price" : "'.$old_price.'"}';
  $db->query("INSERT INTO `$dbName`.`logs` (`lid`, `lfrom`, `lto`, `lip_address`, `ltime`, `lbrowser`, `ltype`, `lmodule`, `lmid`, `lview1`, `lview2`, `lhistory`, `lpoints`, `lmobile`, `lapi`, `lread`, `ltext`) VALUES (NULL, '$from', '$from', '$ip', '$time', '$browser', '4', '2', '$id', '$from', '', '1', '$points', '', '', '1', '$template');");
 }
}

$logs = new Logs;
?>