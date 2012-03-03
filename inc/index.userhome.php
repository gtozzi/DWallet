<?php

/**
* @file index.userhome.php Serving user home area
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

require 'common_user.php';

$tplfile = 'userhome';

// Gets folders & passwords in the current folder
$smarty->assign('folders', $db->getFolders($folder));
$passwords = $db->getPasswords($folder);
foreach( $passwords as & $p )
    try{
        $encoder->decrypt($p['password'],$user->getKeyPwd(),$p['iv']);
        $p['readable'] = true;
    }catch(DecriptionException $e) {
        $p['readable'] = false;
    }
unlink($p);
$smarty->assign('passwords', $passwords);
