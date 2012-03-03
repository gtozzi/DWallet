<?php

/**
* @file index.home.php Serving the home page
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

// Login if POST
if( $_POST['email'] ) {
    $uid = $db->login($_POST['email'], $_POST['passwd']);
    if( $uid ) {
        $user->login($uid, $_POST['encKey']);
        $redirect = '?do=userhome';
    }else{
        $smarty->assign('login_error', 'Unvalid credentials.');
        $smarty->assign('email', $_POST['email']);
    }
}
