<?php

$page = $_GET['page'] ?? 'home';



switch ($page) {
  case 'home':
    include 'home.php';
    break;
  case 'login':
    include 'login.php';
    break;
  default:
    include '404.php';
}