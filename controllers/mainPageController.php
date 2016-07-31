<?php

namespace controllers;

class MainPageController extends ACore
{
  
    public function actionIndex($way)
    {   
        $way = substr($way, 0, strrpos($way, '.'));
        $arrData = $this->m->select('mainPages', '', '`title`, `description`, `text`', "`href`='$way'");
        $title = $arrData[0]['title'];
        $description = $arrData[0]['description'];
        $text = $arrData[0]['text'];
        
        // header
        $this->get_header('header.html', array('title'=>$title, 'description'=>$description));
        
        //$categories = $this->m->_select_('`statti`', 'distinct', '`category`');
        
        // Подключаем вид
        $tpl = $this->twig->loadTemplate('main.html');
        echo $tpl->render(array('text'=>$text));
        
        // footer
        $this->get_footer();
        return true;
    }
        
}
