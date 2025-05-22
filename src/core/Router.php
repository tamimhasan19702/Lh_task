<?php 


namespace LH\core;


class Router {
    public function dispatch() {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
                require_once __DIR__ . '/../../public/home.php';
                break;

            case 'post':
                require_once __DIR__ . '/../../public/post.php';
                break;

            case 'login':
                require_once __DIR__ . '/../../public/login.php';
                break;

            case 'admin':
                require_once __DIR__ . '/../../public/admin/dashboard.php';
                break;

            default:
                require_once __DIR__ . '/../../public/404.php';
                break;
        }

    }
}