<?php

/**
* @file index.newfolder.php Creates a new folder
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

$tplfile = 'modpassword';

// Assign unlock
$unlock = (bool)$_GET['unlock'];
$smarty->assign('unlock', $unlock);

// If mod
$decrypterror = false;
if( $_GET['password'] ) {
    $pid = (int)$_GET['password'];
    $smarty->assign('pid', $pid);

    $p = $db->getPassword($pid);
    try{
        $pwd = $encoder->decrypt($p['password'],$user->getKeyPwd(),$p['iv']);
    }catch(DecriptionException $e) {
        $decrypterror = true;
    }
    $smarty->assign('decrypterror', $decrypterror);

    $smarty->assign('name', $p['name']);
    $smarty->assign('username', $p['username']);
    $smarty->assign('password1', $pwd);
    $smarty->assign('password2', $pwd);
    $smarty->assign('url', $p['url']);
    $smarty->assign('note', $p['note']);
}
// If request submitted
if( ! $decrypterror && $_POST['name'] ) {
    // Validate
    if( $_POST['password1'] !== $_POST['password2'] ) {
        $smarty->assign('validation_error', 'Passwords doesn\'t match.');
        $smarty->assign('name', $_POST['name']);
        $smarty->assign('username', $_POST['username']);
        $smarty->assign('url', $_POST['url']);
        $smarty->assign('note', $_POST['note']);
    }else{
        list($pwd, $iv) = $encoder->encrypt($_POST['password1'],$user->getKeyPwd());
        if( $_GET['password'] )
            $db->modifyPassword(
                (int)$_GET['password'],
                $_POST['name'],
                $_POST['username'] ? $_POST['username'] : null,
                $_POST['url'] ? $_POST['url'] : null,
                $_POST['password1'] ? $pwd : null,
                $_POST['password1'] ? $iv : null,
                $_POST['note'] ? $_POST['note'] : null,
                $folder
            );
        else
            $db->createPassword(
                $_POST['name'],
                $_POST['username'] ? $_POST['username'] : null,
                $_POST['url'] ? $_POST['url'] : null,
                $_POST['password1'] ? $pwd : null,
                $_POST['password1'] ? $iv : null,
                $_POST['note'] ? $_POST['note'] : null,
                $folder
            );
        $redirect = "?do=userhome&folder=$folder";
    }
}
