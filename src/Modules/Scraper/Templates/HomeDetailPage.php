<?php

namespace FScraper\Modules\Scraper\Templates;

use FScraper\Modules\Scraper\Templates\Interfaces\TemplateInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class HomeDetailPage
 */
final class HomeDetailPage implements TemplateInterface
{
    /**
     * @param Crawler $crawler
     *
     * @return array
     */
    public function parse(Crawler $crawler):array
    {
        return ['body' => $crawler->html()];
    }
}
