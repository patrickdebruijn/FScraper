<?php

use FScraper\Commands\Handlers\ParseHomeDetailPageHandler;
use FScraper\Commands\ParseHomeDetailPageCommand;
use FScraper\Modules\Scraper\Scraper;
use League\Event\Emitter;
use League\Tactician\CommandBus;
use League\Tactician\CommandEvents\Event\CommandFailed;
use League\Tactician\CommandEvents\EventMiddleware;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Logger\Formatter\ClassNameFormatter;
use League\Tactician\Logger\LoggerMiddleware;
use League\Tactician\Plugins\LockingMiddleware;
use Psr\Log\LogLevel;

//@TODO//Autofind / load commands + handlerMaps
//Commands
$container->share(ParseHomeDetailPageCommand::class);

//CommandHandlers
$container->share(ParseHomeDetailPageHandler::class)
    ->addArgument($container->get('app.infrastructure.logger'))
    ->addArgument(Scraper::class);

//CommandHandlerMap
$container->add(
    'app.commandHandlerMap',
    [
        ParseHomeDetailPageCommand::class => ParseHomeDetailPageHandler::class,
    ]
);

$container
    ->add(HandleInflector::class);

$container
    ->add(ClassNameExtractor::class);

$container
    ->add(ClassNameFormatter::class)
    ->addArgument(LogLevel::DEBUG)
    ->addArgument(LogLevel::INFO)
    ->addArgument(LogLevel::CRITICAL);

$container
    ->add(ContainerLocator::class)
    ->addArgument($container)
    ->addArgument($container->get('app.commandHandlerMap'));

$container
    ->add(CommandHandlerMiddleware::class)
    ->addArgument($container->get(ClassNameExtractor::class))
    ->addArgument($container->get(ContainerLocator::class))
    ->addArgument($container->get(HandleInflector::class));

$container
    ->add(LoggerMiddleware::class)
    ->addArgument($container->get(ClassNameFormatter::class))
    ->addArgument($container->get('app.infrastructure.logger'));

$container
    ->add(LockingMiddleware::class);


$container
    ->add(Emitter::class);

$container
    ->add(EventMiddleware::class)
    ->addArgument($container->get(Emitter::class))
    ->addMethodCall('addListener', [
        'command.failed',
        function (CommandFailed $event) {
            // log the failure
            $event->catchException(); // without calling this the exception will be thrown
        },
    ]);

$container
    ->add(CommandBus::class)
    ->addArgument([
        $container->get(LoggerMiddleware::class),
        $container->get(EventMiddleware::class),
        $container->get(LockingMiddleware::class),
        $container->get(CommandHandlerMiddleware::class),
    ]);
