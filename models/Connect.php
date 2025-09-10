<?php

namespace models;


// пример синглтона
class Connect {
  
  private static $connect = null;
  
  private function __construct(){}
  
  private function __clone(){}
  
  public static function setConnect($xml_file)
  {
    if(is_null(self::$connect)){   
     try{
        // читаем xml файл в обьект::
        $xml = simplexml_load_file(ROOT.$xml_file);
        $host = $xml->host[0];
        $dbname = $xml->dbname[0];
        $user = $xml->user[0];
        $password = $xml->password[0];
        
        $db = self::$connect = new \PDO('mysql: host='.$host.'; dbname='. $dbname, $user, $password);
        
        $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $db->exec("SET NAMES 'utf8'"); 
        $db->exec("SET CHARACTER SET 'utf8'");
        $db->exec("SET SESSION collation_connection = 'utf8_general_ci'");
      
     }catch(\PDOException $err) { 
        echo 'Ошибка при соединении с БД ' . $err->getMessage(). '<br> 
              в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString()); 
              
        // пример логировапия ошибок
        $log = ROOT.'/log/PDOErrors.txt';
			  file_put_contents($log, $err->getMessage()." (".date("l, d-m-Y H:i:s").") - Ошибка коннекта к БД\r\n", FILE_APPEND);
        exit;  
      }

     return $db;
    
    }   
  }
	
}