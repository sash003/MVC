<?php
namespace controllers;

abstract class ACore{
	
	protected $m;
  protected $loader;
  protected $twig;

	public function __construct(){
		$this->m = new \models\Model();
    $this->loader = new \Twig_Loader_Filesystem(ROOT.'/template/views');
    $this->twig = new \Twig_Environment($this->loader);
  }

  protected function get_header($header, $vars=array()){
    $tpl = $this->twig->loadTemplate($header);
    echo $tpl->render($vars);
  }
  
  protected function get_footer($footer='footer.html'){
    $tpl = $this->twig->loadTemplate($footer);
    echo $tpl->render(array());
  }
	
}
