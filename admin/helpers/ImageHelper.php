<?php

namespace LH\Helpers;

class ImageHelper
{
    public static function getImagePath(string $filename): ?string
    {
       
        $basePath = __DIR__ . '/../../public/assets/images/';
        $filePath = $basePath . $filename;

        if (!file_exists($filePath)) {
            return null;
        }

       
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = $protocol . $host. '/Lh_task/public';

        // Relative web path to image
        $webPath = '/assets/images/' . $filename;

        return $baseUrl . $webPath;
    }
}