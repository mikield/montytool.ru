<?php
// склонение числительных
function declOfNum($number, $titles) {
 $cases = array(2, 0, 1, 1, 1, 2);  
 return $titles[($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)]];  
}

// определение IP
function ip_address() {
 if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip_result = $_SERVER['HTTP_X_FORWARDED_FOR'];
 elseif(isset($_SERVER['HTTP_CLIENT_IP'])) $ip_result = $_SERVER['HTTP_CLIENT_IP']; 
 else $ip_result = $_SERVER['REMOTE_ADDR'];
 return $ip_result;
}

// создание хш
function user_hash($string) {
 return md5(md5($string));
}

// определяем браузер пользователя
function user_browser() { 
  $str = getenv('HTTP_USER_AGENT'); 
  if(strpos($str, 'Avant Browser', 0) !== false) return 'Avant Browser'; 
  elseif(strpos($str, 'Acoo Browser', 0) !== false) return 'Acoo Browser'; 
  elseif(@eregi('Iron/([0-9a-z\.]*)', $str, $pocket)) return 'SRWare Iron '.$pocket[1];
  elseif(@eregi('Chrome/([0-9a-z\.]*)', $str, $pocket)) return 'Google Chrome '.$pocket[1]; 
  elseif(@eregi('(Maxthon|NetCaptor)( [0-9a-z\.]*)?', $str, $pocket)) return $pocket[1].$pocket[2];
  elseif(@strpos($str, 'MyIE2', 0) !== false) return 'MyIE2'; 
  elseif(@eregi('(NetFront|K-Meleon|Netscape|Galeon|Epiphany|Konqueror|'. 'Safari|Opera Mini)/([0-9a-z\.]*)', $str, $pocket)) return $pocket[1].' '.$pocket[2]; 
  elseif(@eregi('Opera[/ ]([0-9a-z\.]*)', $str, $pocket)) return 'Opera '.$pocket[1]; 
  elseif(@eregi('Orca/([ 0-9a-z\.]*)', $str, $pocket)) return 'Orca Browser '.$pocket[1]; 
  elseif(@eregi('(SeaMonkey|Firefox|GranParadiso|Minefield|'.'Shiretoko)/([0-9a-z\.]*)', $str, $pocket)) return 'Mozilla '.$pocket[1].' '.$pocket[2]; 
  elseif(@eregi('rv:([0-9a-z\.]*)', $str, $pocket) && strpos($str, 'Mozilla/', 0) !== false) return 'Mozilla '.$pocket[1]; 
  elseif(@eregi('Lynx/([0-9a-z\.]*)', $str, $pocket)) return 'Lynx '.$pocket[1];
  elseif(@eregi('MSIE ([0-9a-z\.]*)', $str, $pocket)) return 'Internet Explorer '.$pocket[1];
  else return 'Unknown';
} 

// русские символы в json
function jdecoder($json_str) {
 $cyr_chars = array (
  '\u0430' => 'а', '\u0410' => 'А',
  '\u0431' => 'б', '\u0411' => 'Б',
  '\u0432' => 'в', '\u0412' => 'В',
  '\u0433' => 'г', '\u0413' => 'Г',
  '\u0434' => 'д', '\u0414' => 'Д',
  '\u0435' => 'е', '\u0415' => 'Е',
  '\u0451' => 'ё', '\u0401' => 'Ё',
  '\u0436' => 'ж', '\u0416' => 'Ж',
  '\u0437' => 'з', '\u0417' => 'З',
  '\u0438' => 'и', '\u0418' => 'И',
  '\u0439' => 'й', '\u0419' => 'Й',
  '\u043a' => 'к', '\u041a' => 'К',
  '\u043b' => 'л', '\u041b' => 'Л',
  '\u043c' => 'м', '\u041c' => 'М',
  '\u043d' => 'н', '\u041d' => 'Н',
  '\u043e' => 'о', '\u041e' => 'О',
  '\u043f' => 'п', '\u041f' => 'П',
  '\u0440' => 'р', '\u0420' => 'Р',
  '\u0441' => 'с', '\u0421' => 'С',
  '\u0442' => 'т', '\u0422' => 'Т',
  '\u0443' => 'у', '\u0423' => 'У',
  '\u0444' => 'ф', '\u0424' => 'Ф',
  '\u0445' => 'х', '\u0425' => 'Х',
  '\u0446' => 'ц', '\u0426' => 'Ц',
  '\u0447' => 'ч', '\u0427' => 'Ч',
  '\u0448' => 'ш', '\u0428' => 'Ш',
  '\u0449' => 'щ', '\u0429' => 'Щ',
  '\u044a' => 'ъ', '\u042a' => 'Ъ',
  '\u044b' => 'ы', '\u042b' => 'Ы',
  '\u044c' => 'ь', '\u042c' => 'Ь',
  '\u044d' => 'э', '\u042d' => 'Э',
  '\u044e' => 'ю', '\u042e' => 'Ю',
  '\u044f' => 'я', '\u042f' => 'Я',
 
  '\r' => '',
  '\n' => '<br />',
  '\t' => '',
  '\"' => '"',
  '\u2014' => '—'
 );
 
 foreach ($cyr_chars as $key => $value) {
  $json_str = str_replace($key, $value, $json_str);
 }
 return $json_str;
}

function auto_link($str, $type = 'both', $popup = FALSE) { // преобразование текстовых ссылок в нормальные
 if(preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches)) {  
  for($i = 0; $i < count($matches['0']); $i++) {  
   $period = '';  
   if(preg_match("|\.$|", $matches['6'][$i])) {  
    $period = '.';  
    $matches['6'][$i] = substr($matches['6'][$i], 0, -1);  
   }  
   $str = str_replace($matches['0'][$i],  
   $matches['1'][$i].'<a target="_blank" href="http'.  
   $matches['4'][$i].'://'.  
   $matches['5'][$i].  
   $matches['6'][$i].'"'.$pop.'>http'.  
   $matches['4'][$i].'://'.  
   $matches['5'][$i].  
   $matches['6'][$i].'</a>'.  
   $period, $str);  
  }  
 }    
 return $str;  
}
?>