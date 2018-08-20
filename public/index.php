<?php

require '../vendor/autoload.php';

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

$dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '..');
$dotenv->load();

$config = [
    'telegram' => [
        'token' => getenv('TELEGRAM_TOKEN'),
    ],
];

DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
$botman = BotManFactory::create($config);

$botman->hears('/start', '\Andegna\AllItBooksBot\Handlers\StartHandler@start');
$botman->hears('^[^/].*', '\Andegna\AllItBooksBot\Handlers\SearchHandler@search');

$botman->listen();
