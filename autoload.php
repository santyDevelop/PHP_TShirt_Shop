<?php

function controllers_autoload($classname){
	include 'Controllers/' . $classname . '.php';
}

spl_autoload_register('controllers_autoload');

?>