<?php

namespace models;


class Model
{

  public function __construct()
  {

    $xml      = simplexml_load_file(ROOT.'/config/db_conf.xml');
    $host     = $xml->host[0];
    $dbname   = $xml->dbname[0];
    $user     = $xml->user[0];
    $password = $xml->password[0];

    $this->db = new \PDO('mysql: host='.$host.'; dbname='. $dbname, $user, $password);

    $this->db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    $this->db->exec("SET NAMES 'utf8'");
    $this->db->exec("SET CHARACTER SET 'utf8'");
    $this->db->exec("SET SESSION collation_connection = 'utf8_general_ci'");

  }



  public function query($query, array $values = array(
    ), $param = false, $param2 = false)
  {
    try
    {
      $stmt       = $this->db->prepare($query);
      $values_len = count($values);

      for($i = 0; $i < $values_len; $i++){
        $value = trim($values[$i]);
        if(preg_match('/^\d+$/', $value)){
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_INT);
        }
        else
        {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_STR);
        }
      }
      $stmt->execute($values);
      if(!$param){
        return $stmt->fetchAll();
      }
      else
      {
        if($param2)
        {
          return $this->db->lastInsertId();
        }
        else
        {
          return $stmt->rowCount();
        }
      }
      return $stat;
    } catch(\PDOException $err){
      echo 'Ошибка при выборке из БД ' . $err->getMessage(). '<br>
      в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString());
      exit;
    }

  }







  public function escapeStr($str, $size = 0)
  {
    $str = trim($str);
    $str = htmlentities($str, ENT_QUOTES, "UTF-8");
    if($size) $str = mb_substr($str, 0, $size, "UTF-8");
    return $str;
  }





  public function getTitle()
  {
    $url    = trim($this->escapeStr($_SERVER['REQUEST_URI']), '/');
    //$url    = preg_replace('#[/.]#', '', $url);
    $titles = array(
      'ru'=>'Цветочный рай',


      'en'=>'Flowers paradise'
    );

    if(array_key_exists($url, $titles)){
      return $titles[$url];
    }
    else
    {
      return '';
    }
  }



  function getIp()
  {
    $keys = array(
      'REMOTE_ADDR',
      'HTTP_X_REAL_IP',
      'HTTP_CLIENT_IP',
      'HTTP_X_FORWARDED_FOR'
    );
    foreach($keys as $key){
      if(!empty($_SERVER[$key])){
        @$ip = trim(end(explode(',', $_SERVER[$key])));
        if(filter_var($ip, FILTER_VALIDATE_IP)){
          return $ip;
        }
      }
    }
  }
}
