<?php /** @noinspection ALL */

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
    public static function parse(Crawler $crawler): array
    {
        return [
            'Summary' => self::basic($crawler),
            'Properties' => self::properties($crawler),
            'Buurt' => self::buurt($crawler),
            'Photos' => self::photos($crawler),
        ];
    }

    /**
     * @param Crawler $crawler
     *
     * @return mixed
     */
    public static function basic(Crawler $crawler): array
    {
        $basic = [];

        //Parse the 40-block summary
        $crawler->filter('ul.kenmerken-highlighted__list li.kenmerken-highlighted__list-item')->each(function ($node) use (&$properties) {
            $key = ucfirst(str_replace(" ", "_", strtolower(trim($node->filter('span.kenmerken-highlighted__term')->text()))));
            $basic[$key] = $node->filter('span.kenmerken-highlighted__details')->text();
        });

        //Add some custom info from the sides
        $basic['Omschrijving'] = $crawler->filter('div.object-description-body')->text();
        $basic['Makelaar'] = $crawler->filter('a.object-contact-aanbieder-link')->text();

        return $properties;
    }


    /**
     * @param Crawler $crawler
     *
     * @return array
     */
    public static function properties(Crawler $crawler): array
    {
        $properties = [];

        //Add some custom info from the sides
        $properties['Basic']['Omschrijving'] = $crawler->filter('div.object-description-body')->text();
        $properties['Basic']['Makelaar'] = $crawler->filter('a.object-contact-aanbieder-link')->text();

        //Parse the 40-block summary
        $crawler->filter('ul.kenmerken-highlighted__list li.kenmerken-highlighted__list-item')->each(function ($node) use (&$properties) {
            $key = ucfirst(str_replace(" ", "_", strtolower(trim($node->filter('span.kenmerken-highlighted__term')->text()))));
            $properties['Summary'][$key] = $node->filter('span.kenmerken-highlighted__details')->text();
        });

        //Add the properties list
        $titles = [];
        $crawler->filter('div.object-kenmerken-body h3')->each(function ($node) use (&$titles) {
            $titles[] = ucfirst(str_replace(" ", "_", strtolower(trim($node->text()))));
        });

        $keys = [];
        $crawler->filter('div.object-kenmerken-body dt')->each(function ($node) use (&$keys) {
            $keys[] = ucfirst(str_replace(" ", "_", strtolower(trim($node->text()))));
        });

        $values = [];
        $crawler->filter('div.object-kenmerken-body dd')->each(function ($node) use (&$values) {
            $values[] = trim($node->text());
        });

        foreach ($titles as $index => $title) {
            if (array_key_exists($index, $values) && array_key_exists($index, $keys)) {
                $properties['Kenmerken'][$title][$keys[$index]] = $values[$index];
            }
        }

        return $properties;
    }

    /**
     * @param Crawler $crawler
     *
     * @return array
     */
    public static function buurt(Crawler $crawler): array
    {
        $buurt = [];

        //Add buurt info
        $buurt['Naam'] = $crawler->filter('p.object-buurt__name')->text();
        $buurt['Title'] = $crawler->filter('div.object-description-body')->text();
        $crawler->filter('ul.object-buurt__list li.object-buurt__list-item')->each(function ($node) use (&$buurt) {
            $buurt['Dichtbij'][] = trim($node->filter("span.object-buurt__term")->text());
        });

        return $buurt;
    }

    /**
     * @param Crawler $crawler
     *
     * @return array
     */
    public static function photos(Crawler $crawler): array
    {
        $photos = [];

        $crawler->filter('.media-viewer-overview__section-list .media-viewer-overview__section-list-item--floorplan')->each(function ($node) use (&$photos) {
            $src = trim($node->filter("img")->attr('data-lazy'));
            if (empty($src)) {
                $src = trim($node->filter("img")->attr('src'));
            }

            $title = trim($node->filter("a")->attr('title'));
            if (empty($src)) {
                $title = trim($node->filter("img")->attr('alt'));
            }

            $photos['Plattegrond'][] = [
                'src' => $src,
                'title' => $title,
            ];
        });

        //Add photos info
        $crawler->filter('.object-media-fotos .object-media-foto')->each(function ($node) use (&$photos) {
            $src = trim($node->filter("img")->attr('data-lazy'));
            if (empty($src)) {
                $src = trim($node->filter("img")->attr('src'));
            }

            $title = trim($node->filter("a")->attr('title'));
            if (empty($src)) {
                $title = trim($node->filter("img")->attr('alt'));
            }

            $photos['Gallerij'][] = [
                'src' => $src,
                'title' => $title,
            ];
        });

        return $photos;
    }
}
