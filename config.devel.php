<?php

/**
* @file config.php Main configuration file
*
* @author Gabriele Tozzi <gabriele@tozzi.eu>
* @date   03.03.2012
*
* This file is part of DWallet
*
* DWallet is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.

* DWallet is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with Nome-Programma.  If not, see <http://www.gnu.org/licenses/>.
*/

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

//Encryption settings
$conf['mcrypt'] = array(
    'algorithm' => MCRYPT_RIJNDAEL_256,
    'mode'      => MCRYPT_MODE_CFB,
    'prehash'   => function($p) { return hash('SHA256', $p, true); }, 
);
