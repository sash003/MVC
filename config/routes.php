<?php

return array(
  '^[a-z]{2}$' => 'mainPage/main/$0',
	//'^([a-zA-Z]{2}/)?books\/(.)+' => 'mainPage/book/$0',
	//'^[A-Za-z]{2,22}$' => 'mainPage/main/$0',
  '.' => 'mainPage/error/$0'
);
