<?php

namespace Andegna\AllItBooksBot\Handlers;

use Andegna\AllItBooksBot\Fetcher;
use Andegna\AllItBooksBot\Node;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Goutte\Client;

class SearchHandler
{
    public function search(BotMan $bot)
    {
        $searchTerm = $bot->getMessage()->getText();

        $bot->reply("Search result for \"{$searchTerm}\"");

        $result = (new Fetcher($searchTerm, new Client()))->fetch();

        $bot->reply('Found ' . \count($result) . ' result.');

        /** @var Node $node */
        foreach ($result as $node) {
            $bot->reply(OutgoingMessage::create($node->getTitle())
                ->withAttachment(new Image($node->getThumbnail())));

            $bot->reply($node->getDescription() . PHP_EOL . $node->getStats());

            $bot->reply(OutgoingMessage::create($node->getTitle(), new File($node->getFile())));
        }
    }
}