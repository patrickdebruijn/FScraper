<?php

use FScraper\Modules\Scraper\Scraper;
use FScraper\Modules\Scraper\Templates\HomeDetailPage;

$container->share(HomeDetailPage::class);

$container->add('app.scraper.templateMap', [
    'HomeDetailPage' => $container->get(HomeDetailPage::class),
]);

//$jar = new \GuzzleHttp\Cookie\CookieJar();

$container
    ->share(Scraper::class)
    ->addArgument($container->get('app.infrastructure.logger'))
    ->addArgument($container->get('app.scraper.templateMap'))
    ->addArgument([
        'timeout' => 60,
	    'strict' => false,
	    'referer' => true,
	    'protocols' => ['http', 'https'],
	    'track_redirects' => true,
	    'cookies' => true,
	    'headers' => [
		    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.81 Safari/537.36',
		    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
		    'Accept-Language' => 'en-US,en;q=0.9,nl;q=0.8',
	    ],
	    //'proxy' => 'http://' . CRAWLERA_API_KEY . ':@proxy.crawlera.com:8010',
        'verify' => false,
        'defaults' => [
            'verify' => false,
        ],
    ]);
