<?php
require '../vendor/autoload.php';
/**
 * @param $url
 *
 * @return bool|string
 * @throws \Exception
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function get_file($url)
{
	$client = new GuzzleHttp\Client();
	$res = $client->request ('GET', $url, default_ops ());

	if ($res->getStatusCode () != 200) {
		throw new Exception('HTTP Error retrieving URL ' . $url . ' HTTP return code=' . $res->getStatusCode () . ' ' . $output);
	}

	return $res->getBody ();
}


/**
 * @param bool  $proxy
 * @param bool  $resetCookieJar
 * @param array $options
 *
 * @return array
 */
function default_ops($proxy = true, $resetCookieJar = true, $options = []): array
{
	$jar = new \GuzzleHttp\Cookie\CookieJar();
	$opts = [
		'cookies' => $jar,
		'allow_redirects' => true,
		'strict' => false,
		'referer' => true,
		'protocols' => ['http', 'https'],
		'track_redirects' => true,
		'timeout' => 60,
		'connect_timeout' => 30,
		'verify' => false,
		'defaults' => [
			'verify' => false,
		],
		'headers' => [
			'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.81 Safari/537.36',
			'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
			'Accept-Language' => 'en-US,en;q=0.9,nl;q=0.8',
		],
	];

	if ($proxy) {
		$opts['proxy'] = 'socks5://localhost:9050';
	}
	foreach ($options as $key => $value) {
		$opts[$key] = $value;
	}
	return $opts;
}


print get_file ('https://httpbin.org/ip'); //https://www.funda.nl/koop/leidschendam/huis-40820553-westvlietweg-126/
