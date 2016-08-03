<?php

namespace models;


class Model
{
  protected $_db;
  
  public function __construct()
  {
    try{
      $this->_db = \models\Connect::setConnect('/config/db_conf.xml');
    } catch (\Exception $e) {
      echo 'Ошибка конструктора ' . $err->getMessage(). '<br> в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString());
      exit;  
    }
    
  }
  
  public function select($table, $prevCond = '', $fields = '*', $condition = '1', array $values = array(
) , $postCond = '')
  {
    try{
      if (!$fields) $fields = '*';
      if (!$condition) $condition = '1';
      $query = "select $prevCond $fields from $table where $condition $postCond";
      $stmt = $this->_db->prepare($query);
      $stmt->execute($values);
      $stat = array();
      while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $stat[] = $row;
      }
      return $stat;
    } catch (\PDOException $err) {
      echo 'Ошибка при выборке из БД ' . $err->getMessage(). '<br> 
              в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString()); 
        exit;  
    }
    
  }
  
  public function escapeStr($str, $size=0){
      $str = trim($str);
      $str = preg_replace('/`/', '', $str);
      $str = htmlentities($str, ENT_QUOTES, "UTF-8");
      if($size)$str = mb_substr($str, 0, $size, "UTF-8");
      return $str;
  }
 
  
  function __destruct()
  {
    $this->_db = null;
    unset($this);
  }
  
  
}
