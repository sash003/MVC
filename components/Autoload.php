<?php

// функция автозагрузки классов
function myAutoload($classname){
  if(preg_match('/\\\\/', $classname)){
      $path = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
  }else{
      $path = str_replace('_', DIRECTORY_SEPARATOR, $classname);
  }
  require_once(ROOT.DIRECTORY_SEPARATOR."$path.php");
}

// регистрация функции автозагрузки
//spl_autoload_register('myAutoload');

