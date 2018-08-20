<?php

require '../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '..');
$dotenv->load();

$client = new \Goutte\Client();
$client->request('GET', 'https://api.telegram.org/bot'
    . getenv('TELEGRAM_TOKEN')
    . '/setWebhook?url=https://'
    . $_SERVER['HTTP_HOST']);

/** @var \Symfony\Component\BrowserKit\Response $response */
$response = $client->getResponse();
$result = json_decode($response->getContent());

if (is_object($result) && property_exists($result, 'description')) {
    echo $result->description;
} else {
    die('Failed!!');
}
