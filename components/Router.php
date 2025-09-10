<?php

namespace components;

/**
* Класс Router
* Компонент для работы с маршрутами
*/
class Router{

	/**
	* Свойство для хранения массива роутов
	* @var array 
	*/
	private $routes;

	/**
	* Конструктор
	*/
	public function __construct(){
		// Путь к файлу с роутами
		$routesPath = ROOT . '/config/routes.php';

		// Получаем роуты из файла
		$this->routes = include($routesPath);
		//echo $_SERVER['REQUEST_URI'];        
	}

	/**
	* Возвращает строку запроса
	*/
	private function getURI(){
		if(!empty($_SERVER['REQUEST_URI'])){
			return trim($this->escapeStr($_SERVER['REQUEST_URI'], 123), '/');
		}
	}
  
  
  
  public function escapeStr($str, $size = 0)
  {
    $str = trim($str);
    $str = preg_replace('/[`\'"\(\)\<\>\]\[\}\{\\\\]/', '', $str);
    $str = htmlentities($str, ENT_QUOTES, "UTF-8");
    if($size) $str = mb_substr($str, 0, $size, "UTF-8");
    return $str;
  }
  
  
  
	/**
	* Метод для обработки запроса
	*/
	public function run(){
		// Получаем строку запроса
		$uri = $this->getURI();

		// Проверяем наличие такого запроса в массиве маршрутов (routes.php)
		foreach($this->routes as $uriPattern => $path){

			// Сравниваем $uriPattern и $uri
			if(preg_match("~$uriPattern~", $uri)){
        
				// Получаем внутренний путь из внешнего согласно правилу.
				//echo $path . " " . $uri .' '.$uriPattern;   
			
				// Определить контроллер, action, параметры

				$segments = explode('/', $path);

				$controllerName = array_shift($segments) . 'Controller';
				$controllerName = ucfirst($controllerName);
        
				$actionName = 'action' . ucfirst(array_shift($segments));
        
				$parameters = explode('/', $uri);
;
				
				// Подключить файл класса-контроллера
				$controllerFile = ROOT . '/controllers/' .
				$controllerName . '.php';

				if(file_exists($controllerFile)){
					include_once($controllerFile);
				}
                
				$controllerName = "\\controllers\\$controllerName";
                
				// Создать объект, вызвать метод (т.е. action)
				$controllerObject = new $controllerName;

				/* Вызываем необходимый метод ($actionName) у определенного 
				* класса ($controllerObject) с заданными ($parameters) параметрами
				*/
				//print_r($parameters);
				$result = call_user_func_array(array($controllerObject, $actionName), array($parameters));
        return;
				// Если метод контроллера успешно вызван, завершаем работу роутера
				if($result != null){
					break;
          return;
				}
			}
		}
	}

}
