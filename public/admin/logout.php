<?php


require '../../vendor/autoload.php';

use LH\Helpers\ConstantHelper;


ConstantHelper::initialize();

session_start();

$_SESSION = [];


session_destroy();




header("Location: " .  BASE_URL ); 
exit;
exit;