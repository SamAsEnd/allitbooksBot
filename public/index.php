<?php

require '../vendor/autoload.php';

use Andegna\AllItBooksBot\Fetcher;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

const BOOKS = ['📔', '📒', '📕', '📗', '📘', '📙'];
const MAX = 5;

$dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '..');
$dotenv->load();

$config = [
    'telegram' => [
        'token' => getenv('TELEGRAM_TOKEN'),
    ],
];

// Load the driver(s) you want to use
DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

// Create an instance
$botman = BotManFactory::create($config);

$botman->hears('/start', function(BotMan $bot) {
    $name = $bot->getUser()->getFirstName() . ' ' . $bot->getUser()->getLastName();
    $book = BOOKS[random_int(0, MAX)];

    $bot->typesAndWaits(1);

    $bot->reply(<<<MSG
Welcome *{$name}* to *📚 All IT Books 📚* bot.

Just type the topic {$book} and am gonna spam ur inbox ... 🤗
MSG
        , ['parse_mode' => 'markdown']);

    $bot->typesAndWaits(1);

    $bot->reply('Hopefully 🙏');
});

// Give the bot something to listen for.
$botman->hears('^[^/].*', function(BotMan $bot) {
    $bot->types();

    $term = $bot->getMessage()->getText();
    $bot->reply("Search result for \"{$term}\"");

    $bot->reply('wait a sec ...');

    $fetcher = new Fetcher($term, new \Goutte\Client());
    $result = $fetcher->fetch();

    $bot->reply('Found ' . count($result) . ' result.');

    /** @var Node $node */
    foreach ($result as $node) {

        $bot->reply(OutgoingMessage::create($node->getTitle())
            ->withAttachment(new Image($node->getThumbnail())));
        $bot->reply($node->getDescription());
        $bot->reply($node->getStats());
        $bot->reply(OutgoingMessage::create($node->getTitle(), new File($node->getFile())));
    }
});

// Start listening
$botman->listen();
