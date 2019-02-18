<?php

// Autoloading using composer
require '../vendor/autoload.php';

// Connect to the TOR server using password authentication
$tc = new TorControl\TorControl(
	[
		'hostname' => '127.0.0.1',
		'port' => 9051,
	]
);

$tc->connect ();

$tc->authenticate ();

// Renew identity
$res = $tc->executeCommand ('SIGNAL NEWNYM');

// Echo the server reply code and message
echo $res[0]['code'] . ': ' . $res[0]['message'];

// Quit
$tc->quit ();