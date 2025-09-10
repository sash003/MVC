<?php

namespace controllers;

class MainPageController extends ACore{
  
  
  function setFlags(){;
    $way = trim($_SERVER['REQUEST_URI'], '/');
    $parts = explode("/", $way);
    $lang = $parts[0];
    if ($lang != 'ru' && $lang != 'en') return '';
    if (count($parts) > 1){
      $way = substr($way, 3);
    }else{
      $way = '';
    }

    $flags = "";
    $files = scandir(ROOT.'/template/img/flags');
    unset($files[0], $files[1]);

    foreach ($files as $key=>$value){
      if (preg_match("~$lang~", $files[$key])){
        $flags = "<img src='/template/img/flags/$lang.png' />";
        unset($files[$key]);
      }
    }
    foreach ($files as $file){
      $l = substr($file, 0, 2);
        $flags .= "<br/><a href='/$l/$way'><img src='/template/img/flags/$file' /></a>";
    }
    return $flags;
  }





	public function actionMain($way){

    $flags = $this->setFlags();

    if (count($way)==1){
      $file = 'main';
      $way = $way[0];
    }else{
      $file = $way[1];
      $way = $way[0];
    }

		if(!file_exists(ROOT."/template/views/$way/$file.php")){
			$this->actionError($way2);
			return;
		}
		$title = $this->m->getTitle();
		require_once ROOT."/template/views/$way/header.php";
		require_once ROOT."/template/views/$way/$file.php";
		require_once ROOT."/template/views/$way/footer.php";
		return true;
	}

  public function actionBook($way){
    $way2 = $way;
    $lang = $way[0];
    $file = $way[2];
    $flags = $this->setFlags();

    $file = ROOT."/template/views/$lang/books/$file";

		if(!file_exists($file)){
			$this->actionError($way2);
			return;
		}
		$title = $this->m->getTitle();
		require_once ROOT."/template/views/$lang/header.php";
		require_once ROOT."/template/views/$lang/headBook.php";
		require_once $file;
		require_once ROOT."/template/views/$lang/footer.php";
		return true;
	}




	public function actionError($way){
    $lang = $way[0];
    if ($lang != 'ru' && $lang != 'en'){
      $lang = 'en';
    }
    $flags = $this->setFlags();
		$title = "Error";
		$desc = "Error";
		require_once ROOT."/template/views/$lang/header.php";
		require_once ROOT."/template/views/$lang/404.php";
		require_once ROOT."/template/views/$lang/footer.php";
		return true;
	}

  private function isAjax() {
    return (
      !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
    );
  }

}
