<?php

namespace FScraper\Modules\Scraper\Templates\Interfaces;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Interface TemplateInterface
 *
 * @package Scraper\Templates\Interfaces
 */
interface TemplateInterface
{
    /**
     * @param Crawler $crawler
     *
     * @return array
     */
    public function parse(Crawler $crawler): array;
}
