<?php

/*
 * Copyright 2016 Sandro Marcell <smarcell@mail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

require 'include/config.inc.php';

/* Values received/sent by the interface */
$rx_1 = trim(file_get_contents('/sys/class/net/'.IFACE.'/statistics/rx_bytes'));
$tx_1 = trim(file_get_contents('/sys/class/net/'.IFACE.'/statistics/tx_bytes'));
usleep(950000);
$rx_2 = trim(file_get_contents('/sys/class/net/'.IFACE.'/statistics/rx_bytes'));
$tx_2 = trim(file_get_contents('/sys/class/net/'.IFACE.'/statistics/tx_bytes'));

$values = array(
	/* Converting bytes to megabit */
	'download' => round(($rx_2 - $rx_1) * 8 / 1000000, 1),
	'upload' => round(($tx_2 - $tx_1) * 8 / 1000000, 1)
);

/* Print json objects */
header('Content-Type: application/json');
echo json_encode($values);

?>
