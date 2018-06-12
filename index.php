<?php
header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', 1);

error_reporting(E_ALL);
require_once('config.php');
require_once('core.php');

$core = new Core();
$core->setDefaultController('site');
$core->setDefaultAction('index');
$core->process();
