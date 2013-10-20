<?php

class path{

		function __construct($root){
			$this->root=$root;
			$this->css=$this->root.'css/';
			$this->img=$this->root.'img/';
			$this->js=$this->root.'js/';
			return $this;

		}

}
?>