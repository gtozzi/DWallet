<?php

/**
* @file index.php Main service file
*/

$timecounter = microtime(true);

// Enable output buffering (will use this as debug output)
ob_start();

require_once 'config.php';
//require_once "{$conf['paths']['lib']}/utils.php";
require_once "{$conf['paths']['lib']}/topiq_myum_db.php";
require_once "{$conf['paths']['lib']}/dwallet_db.php";
require_once "{$conf['paths']['lib']}/dwallet_user.php";
require_once "{$conf['paths']['lib']}/smarty/libs/Smarty.class.php";

// Disables the session garbage collection
ini_set('session.gc_probability', 0);

// Start the session AFTER importing object definitions
session_start();

//Init the user management backend
$user = & $_SESSION['user'];
if( ! $user )
    $user = new dwallet_user();

//Connect to database
$db = new dwallet_db(
    $_SERVER['REMOTE_ADDR'],
    $user,
    $conf['db']['name'],
    $conf['db']['user'],
    $conf['db']['pass'],
    $conf['db']['host'],
    'mysql',
    $conf['db']['lexc_log'],
    $conf['db']['exc_log']
);
$db->__connect();
$db->setLog( $conf['db']['log_queries'], $conf['db']['log_file'] );
// set Local timezone
$db->__query('SET time_zone = \'Europe/Rome\'');
// set traditional SQL mode
$db->__query('SET sql_mode = \'traditional\'');

//Init redirect system
$redirect = null;

//Init the template system
$tplfile = 'home';
$title = 'DWallet';
$debug = $conf['debug'] ? "Debug enabled.\n" : '';
$debug .= 'New locale: ' . print_r(setlocale(LC_ALL, 'it_IT.utf8'), true) . "\n";
$smarty = new Smarty();
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';
$smarty->setTemplateDir("{$conf['paths']['tpl']}/");
$smarty->setCompileDir("{$conf['paths']['cache']}/");
$smarty->setCacheDir("{$conf['paths']['tplcache']}/");
$smarty->assignByRef('loadtime', $loadtime);
$smarty->assignByRef('user', $user);
$smarty->assignByRef('title', $title);
$smarty->assignByRef('debug', $debug);
$smarty->assign('selfpath', basename($_SERVER['REQUEST_URI']));

// browscap = path/broscap.ini in php.ini
$browser = get_browser();
$smarty->assign('browser', $browser );

if( $conf['debug'] )
    $debug .= "\nBrowser:\n\n" . utf8_encode(print_r($browser,true)) . "\n";

//Load the given page
if( array_key_exists('do', $_GET) && $_GET['do'] && ! strpos($_GET['do'], '/') &&
    file_exists("{$conf['paths']['inc']}/index.{$_GET['do']}.php") )
    $page = $_GET['do'];
else
    if( $user->isAuthenticated() )
        $page = 'userhome';
    else
        $page = 'default';

$smarty->assign('page', $page);

require "{$conf['paths']['inc']}/index.$page.php";

//Calculate loadtime
$loadtime = round( microtime(true) - $timecounter, 3 );

//Redirect if needed
if( $redirect !== null ) {
    ob_end_clean();
    header('Location: ' . base_url() . $redirect);
} else {
    //Display the output
    if( $conf['debug'] )
        $debug .= ob_get_contents();
    ob_end_clean();
    $smarty->display($tplfile.'.tpl');
}
