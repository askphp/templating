<?php

spl_autoload_register(function ($class) {
    require __DIR__ . str_replace('\\', '/', match (explode('\\', $class)[0]) {
                'App' => '/../example' . substr($class, 3),
                'AskPHP' => substr($class, 6),
            } . '.php');
});
