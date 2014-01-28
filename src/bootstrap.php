<?php
/**
 * Bootstrapping functions, essential and needed for Dux to work together with some common helpers. 
 *
 */
 
/**
 * Default exception handler.
 *
 */
function myExceptionHandler($exception) {
  echo "Dux: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('myExceptionHandler');
 
 
/**
 * Autoloader for classes.
 *
 */
function myAutoloader($class) {
  $path = DUX_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    include($path);
  }
  else {
    throw new Exception("Classfile '{$class}' does not exists.");
  }
}

/**
 * Print content of an array
 *
 */
spl_autoload_register('myAutoloader');

function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}
