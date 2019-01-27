<?php

use FScraper\Modules\Scraper\Scraper;
use FScraper\Modules\Scraper\Templates\HomeDetailPage;

$container->share(HomeDetailPage::class);

$container->add('app.scraper.templateMap', [
    HomeDetailPage::class,
]);

$container
    ->share(Scraper::class)
    ->addArgument($container->get('app.infrastructure.logger'))
    ->addArgument($container->get('app.scraper.templateMap'));
