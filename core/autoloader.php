<?php

spl_autoload_register(function($class) {
    $path = implode('/', explode('\\', $class)) . '.php';

    if (!file_exists($path)) {
        throw new \Exception('Модуль не найден: ' . $path);
    }
    require_once $path;
});
