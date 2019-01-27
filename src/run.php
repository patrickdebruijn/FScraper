<?php

require_once '../vendor/autoload.php';

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Scraper\Scraper;

// create a log channel
$logger = new Logger('Scraper');
$logger->pushHandler(new RotatingFileHandler('logs/scraper.log', Logger::WARNING));
$logger->pushHandler(new ErrorLogHandler());

$scraper = new Scraper($logger);
$data = $scraper->crawl($argv[1], 'HomeDetailPage');
var_dump($data);
