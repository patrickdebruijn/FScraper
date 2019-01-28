<?php

use FScraper\Modules\Scraper\Scraper;
use FScraper\Modules\Scraper\Templates\HomeDetailPage;

$container->share(HomeDetailPage::class);

$container->add('app.scraper.templateMap', [
    'HomeDetailPage' => $container->get(HomeDetailPage::class),
]);

$container
    ->share(Scraper::class)
    ->addArgument($container->get('app.infrastructure.logger'))
    ->addArgument($container->get('app.scraper.templateMap'))
    ->addArgument([
        'timeout' => 60,
        'proxy' => 'http://' . CRAWLERA_API_KEY . ':@proxy.crawlera.com:8010',
        'verify' => false,
        'defaults' => [
            'verify' => false,
        ],
    ]);

