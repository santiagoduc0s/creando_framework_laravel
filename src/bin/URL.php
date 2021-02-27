<?php

class URL
{
    public static function base() // retorna la URL raiz del proyecto
    {
        $base_dir = str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
        $base_url = (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://{$_SERVER["HTTP_HOST"]}{$base_dir}";
        return trim($base_url, '/'); // 'http://localhost/Crud con PDO/segundo_intento'
    }

    public static function to($url = '')
    {
        $url = trim($url, '/');
        return self::base() . "/{$url}";
    }

    public static function full()
    {
        return (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }
}
