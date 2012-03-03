<?php

/**
* @file common_user.php Common file to all user area files
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

if( ! $user->isAuthenticated() )
    throw new RuntimeException('Unvalid user!');

$smarty->assign('userinfo', $db->getUserInfo());

// Init encoder
$encoder = new dwallet_encoder(
    $conf['mcrypt']['algorithm'],
    $conf['mcrypt']['mode']
);

// Build path
$lastfolder = (int)$_GET['folder'];
$path = array();
while( $lastfolder ) {
    $f = $db->getFolder($lastfolder);
    $path[] = $f;
    $lastfolder = $f['parent'];
}
$path = array_reverse($path);
$smarty->assign('path', $path);

// Store current folder
$folder = (int)$_GET['folder'] ? $_GET['folder'] : null;
$smarty->assign('folder', $folder);
