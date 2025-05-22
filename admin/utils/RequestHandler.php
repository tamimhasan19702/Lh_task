<?php 

// admin/utils/RequestHandler.php
namespace LH\Utils;

class RequestHandler
{
    public static function getRequest(string $key): mixed
    {
        return $_GET[$key] ?? null;
    }

    public static function postRequest(string $key): mixed
    {
        return $_POST[$key] ?? null;
    }

    public static function validate(array $data): array
    {
        $errors = [];
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $errors[$key] = 'This field is required';
            }
        }

        return $errors;
    }
}