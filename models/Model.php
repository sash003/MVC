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
  public function insert($table, $fields, array $values)
  {
    try{
      $db = $this->_db;
      $fields_ = explode(',', $fields);
      $fields_len = count($fields_);
      $values_len = count($values);
      if ($fields_len !== $values_len) {
        exit('Количество полей и значений не совпадает');
      }
      $prepare = str_repeat('?,', $fields_len);
      // Отрезаем последнюю запятую в составленном запросе
      $prepares = substr($prepare, 0, mb_strlen($prepare) - 1);
      $sql = "INSERT INTO $table ($fields) VALUES ($prepares)";
      $stmt = $db->prepare($sql);
      // обезвреживание данных
      for ($i = 0; $i < $values_len; $i++) {
        $value = trim($values[$i]);
        if (preg_match('/^\d+$/', $value)) {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_INT);
        }
        else {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_STR);
        }
      }
      return $stmt->execute();
    } catch (\PDOException $err) {
      echo 'Ошибка при вставке данных в таблицу ' . $err->getMessage(). '<br> 
              в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString()); 
        exit;  
    }
    
  }
  /**
   * Обновление записи
   * @param $table - название таблицы
   * @param $fields - поля таблицы
   * @param $values - значения
   *
   * @return результат выполнения, true или false
   */
  public function update($table, $fields, array $values, $condition)
  {
    try{
      $db = $this->_db;
      $fields_ = explode(',', $fields);
      $fields_len = count($fields_);
      $values_len = count($values);
      if ($fields_len !== $values_len) {
        exit('Количество полей и значений не совпадает');
      }
      $prepare = '';
      for ($i = 0; $i < $fields_len; $i++) {
        $prepare.= $fields_[$i] . "=?,";
      }
      $prepares = substr($prepare, 0, mb_strlen($prepare) - 1);
      $sql = "UPDATE $table SET $prepares WHERE $condition";
      $stmt = $db->prepare($sql);
      // обезвреживание данных
      for ($i = 0; $i < $values_len; $i++) {
        $value = trim($values[$i]);
        if (preg_match('/^\d+$/', $value)) {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_INT);
        }
        else {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_STR);
        }
      }
      return $stmt->execute();
      
    } catch (\PDOException $err) {
      echo 'Ошибка при обновлении данных в БД ' . $err->getMessage(). '<br> 
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