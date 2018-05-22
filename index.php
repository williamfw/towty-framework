<?php
session_start();

setlocale(LC_ALL, 'pt_BR'); 
date_default_timezone_set('Brazil/East');	
	
define ('BASE_DIR', __DIR__ . '/');
define ('BASE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'].str_replace('index.php', '', $_SERVER['PHP_SELF']));

require_once(BASE_DIR . 'sistema/Sistema.php');

use Sistema\Sistema;

$sistema = new Sistema();
$sistema->executar();