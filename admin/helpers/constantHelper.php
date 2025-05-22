<?php

namespace LH\Helpers;

class ConstantHelper
{
    public static function initialize()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $path = trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

        if (strpos($path, 'admin') !== false) {
            $path = dirname($path);
        }

        define('BASE_URL', $protocol . $host . '/' . $path . '/');
    }
}