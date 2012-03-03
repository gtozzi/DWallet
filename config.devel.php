<?php

// main configuration file

$conf['debug'] = true;

$conf['db'] = array(
    'user' => 'root',
    'pass' => '',
    'host' => 'localhost',
    'name' => 'dwallet',
    'log_queries' => true,
    'log_file'    => 'log/query.log',
    'exc_log'     => 'log/exceptions.log',
    'lexc_log'    => 'log/except.log',
);

//Paths
$conf['paths'] = array(
    //Libraries
    'lib'      => 'lib',
    //Templates
    'tpl'      => 'tpl',
    //General cache
    'cache'    => 'cache',
    //Template cache (must be writable)
    'tplcache' => 'cache/tpl',
    //Include files
    'inc'      => 'inc',
    //Uploaded files
    'upl'      => 'upload',
    //Images
    'img'      => 'media/img',
);

?>
