<?php

namespace FScraper\Modules\Scraper;

use FScraper\Modules\Scraper\Templates\Interfaces\TemplateInterface;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

/**
 * Class App
 *
 * @package Scraper
 */
class Scraper
{
    /**
     * @var GoutteClient
     */
    private $goutteClient;
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;
    /**
     * @var array
     */
    private $guzzleClientSettings;
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $templateMap;

    /**
     * App constructor.
     *
     * @param LoggerInterface $logger
     * @param array           $templateMap
     * @param array           $guzzleClientSettings
     */
    public function __construct(LoggerInterface $logger, array $templateMap = [], array $guzzleClientSettings = ['timeout' => 60])
    {
        $this->logger = $logger;
        $this->guzzleClientSettings = $guzzleClientSettings;
        $this->templateMap = $templateMap;
    }

    /**
     * @param String $url
     * @param String $templateName
     * @param String $method
     * @param array  $data
     *
     * @return array
     */
    public function crawl(String $url, String $templateName, String $method = 'GET', array $data = []): array
    {
        $this->logger->info("Crawling $templateName page: $url");
        $crawler = $this->request($url, $method);

        try {
            $data = $this->getTemplate($templateName)->parse($crawler);
        } catch (Throwable $exception) {
            $msg = $exception->getMessage().' In file: '. $exception->getFile().' On line: '. $exception->getLine();
            $this->logger->error($msg, ['$url'=>$url,'$templateName'=>$templateName,'$method'=>$method,'$data'=>$data]);
            $data = [];
        }
        //$this->logger->debug("Crawler results for page $url with template $templateName", $data);
        return $data;
    }

    /**
     * @return GuzzleClient
     */
    protected function getGuzzleClient(): GuzzleClient
    {
        if ($this->guzzleClient === null) {
            $this->guzzleClient = new GuzzleClient($this->guzzleClientSettings);
        }

        return $this->guzzleClient;
    }


    /**
     * @return GoutteClient
     */
    protected function getGoutteClient(): GoutteClient
    {
        if ($this->goutteClient === null) {
            $this->goutteClient = new GoutteClient();
            $this->goutteClient->setClient($this->getGuzzleClient());
        }

        return $this->goutteClient;
    }

    /**
     * @param String $url
     *
     * @param String $method
     * @return Crawler
     */
    protected function request(String $url, String $method = 'GET'): Crawler
    {
        return $this->getGoutteClient()->request($method, $url);
    }

    /**
     * @param String $name
     *
     * @return TemplateInterface
     * @throws \Exception
     */
    protected function getTemplate(String $name): TemplateInterface
    {
        if (array_key_exists($name, $this->templateMap)) {
            return $this->templateMap[$name];
        }

        throw new \Exception("No template with name $name found", 404);
    }
}
