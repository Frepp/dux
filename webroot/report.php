<?php 
/**
 * This is a Dux pagecontroller.
 *
 */
// Include the essential config-file which also creates the $dux variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Dux container.
$dux['title'] = "Redovisningar";
 
$dux['main'] = <<<EOD
<h1>Redovisningar ooPHP</h1>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Dux.
include(DUX_THEME_PATH);