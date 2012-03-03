<?php

/**
* @file utils.php Miscellaneous utility functions
*
* @author Gabriele Tozzi <gabriele@tozzi.eu>
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

/**
* Returns current page URL
*/
function my_url() {
    $url = 'http';
    if( $_SERVER['HTTPS'] == 'on' )
        $url .= 's';
    $url .= '://' . $_SERVER['SERVER_NAME'];
    if( $_SERVER['SERVER_PORT'] != 80)
        $url .= ':' . $_SERVER['SERVER_PORT'];
    $url .= $_SERVER['REQUEST_URI'];

    return $url;
}

/**
* Returns website base url
*/
function base_url() {
    $url = parse_url(my_url());
    return $url['scheme'] . '://' . $url['host'] . (":{$url['port']}"?$url['port']:'') .
        $url['path'];
}

?>
