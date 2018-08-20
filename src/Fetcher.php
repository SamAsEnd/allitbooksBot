<?php

namespace Andegna\AllItBooksBot;

use Goutte\Client;

class Fetcher
{
    /** @var  string */
    private $term;

    public function __construct(string $term, Client $client)
    {
        $this->term = $term;
        $this->client = $client;
    }

    public function fetch(): array
    {
        $returnNodes = [];

        $nodes = $this->client
            ->request('GET', 'http://www.allitebooks.com/?s=' . $this->term)
            ->filter('main article');

        foreach ($nodes as $node) {
            try {
                $returnNodes[] = $this->fetchNode($node, $returnNodes);
            } catch (\Exception $ignore) {
            }
        }

        return $returnNodes;
    }

    private function fetchNode(\DOMElement $node): Node
    {
        $thumbnail = $node->getElementsByTagName('img')->item(0);
        $paragraph = $node->getElementsByTagName('p')->item(0);

        $secondRequestUri = $thumbnail->parentNode->getAttribute('href');

        list($stats, $down) = $this->sendRequest($secondRequestUri);

        return (new Node())
            ->setTitle($thumbnail->getAttribute('alt'))
            ->setThumbnail($thumbnail->getAttribute('src'))
            ->setDescription($paragraph->textContent)
            ->setFile($down)
            ->setStats($stats);
    }

    private function sendRequest($secondRequestUri): array
    {
        $crawler2 = $this->client->request('GET', $secondRequestUri);

        $stats = implode("\n", array_map('trim', explode("\n", $crawler2->filter('dl')->text())));
        $down = $crawler2->filter('footer .download-links a')->getNode(0)->getAttribute('href');

        return [$stats, $down];
    }

}
