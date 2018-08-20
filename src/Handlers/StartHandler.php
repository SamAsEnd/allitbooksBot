<?php

namespace Andegna\AllItBooksBot\Handlers;

use BotMan\BotMan\BotMan;

const BOOKS = ['📔', '📒', '📕', '📗', '📘', '📙'];
const MAX = 5;

class StartHandler
{
    public function start(BotMan $bot)
    {
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
    }
}