<?php 
/**
 * This is a Dux pagecontroller.
 *
 */
// Include the essential config-file which also creates the $dux variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Add style for csource
$dux['stylesheets'][] = 'css/source.css';
 
// Create the object to display sourcecode
//$source = new CSource();
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));
 
// Do it and store it all in variables in the Dux container.
$dux['title'] = "Visa källkod";
$dux['main'] = "<h1>Visa källkod</h1>\n" . $source->View();
 

 
 
// Finally, leave it all to the rendering phase of Dux.
include(DUX_THEME_PATH);