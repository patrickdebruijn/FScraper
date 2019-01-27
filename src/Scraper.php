<?php

namespace Scraper;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Log\LoggerInterface;
use Scraper\Templates\Interfaces\TemplateInterface;
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


    /**
     * App constructor.
     *
     * @param LoggerInterface $logger
     * @param array  $guzzleClientSettings
     */
    public function __construct(LoggerInterface $logger, array $guzzleClientSettings = ['timeout' => 60])
    {
        $this->logger = $logger;
        $this->guzzleClientSettings = $guzzleClientSettings;
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
        if (file_exists("Templates/$name.php")) {
            $className = "Scraper\Templates\\".$name;
            return new $className();
        }

        throw new \Exception("No template with name $name found", 404);
    }
}
