<?php

namespace Andegna\AllItBooksBot;

class Controllers
{
    public function search(BotMan $bot) {
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
    }
}
