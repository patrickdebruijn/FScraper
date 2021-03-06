<?php /** @noinspection ALL */
declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
$container = require APP_ROOT . 'config' . DIRECTORY_SEPARATOR . 'dependencies.php';

use FScraper\Commands\ParseHomeDetailPageCommand;
use League\Tactician\CommandBus;

set_time_limit (-1);

/**
 *
 * SETUP THE BUSSES
 *
 */

$commandBus = $container->get(CommandBus::class);
$cmd = new ParseHomeDetailPageCommand();
$cmd->setPayload([
	'url' => 'https://www.funda.nl/koop/leidschendam/huis-40820553-westvlietweg-126/',
]);
$commandBus->handle($cmd);