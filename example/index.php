<?php

namespace App;

$timer = microtime(true);

use App\Template\Render;
use AskPHP\Factory;

require '../src/autoload.php';

$app = Factory::fromGlobals('ru');

$app->route('/')
    ->params([Route\Main::class, 'index'], 'index');
$app->route('/page')
    ->params([Route\Pages::class, 'index'], 'pages-index');
$app->route('/page/{slug}')
    ->tokens(['slug' => '\w+'])
    ->params([Route\Pages::class, 'pages'], 'pages-pages');

$app->render([Render::class, 'base']);

$app->run(Error::class);

echo PHP_EOL . '<br>' . PHP_EOL;
echo 'Timer: ' . microtime(true) - $timer;
