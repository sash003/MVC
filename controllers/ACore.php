<?php
namespace controllers;

class ACore{
	
  public $m;

	public function __construct(){
		$this->m = new \models\Model();
  }
}
