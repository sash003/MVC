<?php

return array(
    
    // Главная страница
    //'index.php' => 'mainPage/index', // actionIndex в mainPageController
    '^([^\/]+)?$' => 'mainPage/index/$1', // actionIndex в mainPageController
    
);
