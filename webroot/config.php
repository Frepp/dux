<?php
/**
 * Config-file for Dux. Change settings here to affect installation.
 *
 */
 
/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
 
 
/**
 * Define Dux paths.
 *
 */
define('DUX_INSTALL_PATH', __DIR__ . '/..');
define('DUX_THEME_PATH', DUX_INSTALL_PATH . '/theme/render.php');
 
 
/**
 * Include bootstrapping functions.
 *
 */
include(DUX_INSTALL_PATH . '/src/bootstrap.php');
 
 
/**
 * Start the session.
 *
 */
session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
session_start();
 
 
/**
 * Create the Dux variable.
 *
 */
$dux = array();
 
 
/**
 * Site wide settings.
 *
 */
$dux['lang']         = 'sv';
$dux['title_append'] = ' | ME-sidan';

$dux['header'] = <<<EOD
<img src='img/logo.png' alt='Dux Logo'/>
EOD;

$dux['footer'] = <<<EOD
<footer>Copyright (c) YOU </footer>
EOD;

/**
* Navigation bar
*
*/


//$speedy['navbar'] = null; // To skip the navbar 
$dux['navbar'] = array( 
        'class' => 'navbar', 
        'items' => array( 
                'home'         => array('text'=>'Home',         'url'=>'index.php',          'title' => 'Home'),  
                 
        ),
		
		 
        'callback_selected' => function($url) { 
            if(basename($_SERVER['SCRIPT_FILENAME']) == $url) { 
                return true; 
            } 
        } 
);


/**
 * Theme related settings.
 *
 */
$dux['stylesheets'] = array('css/style.css');
$dux['favicon']    = 'img/favicon.ico';

/**
 * Settings for the database.
 *
 */
$dux['database']['dsn']            = 'mysql:host=;dbname=;';
$dux['database']['username']       = '';
$dux['database']['password']       = '';
$dux['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/**
 * Set constants
 *
 */

