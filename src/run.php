<?php declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
$container = require APP_ROOT . 'config' . DIRECTORY_SEPARATOR . 'dependencies.php';

use FScraper\Commands\ParsePageCommand;
use League\Tactician\CommandBus;

/**
 *
 * SETUP THE BUSSES
 *
 */

$commandBus = $container->get(CommandBus::class);
$cmd = new ParsePageCommand();
$commandBus->handle($cmd);

//$scraper = new Scraper();
//$data = $scraper->crawl($argv[1], 'HomeDetailPage');
//var_dump($data);




