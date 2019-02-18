<?php

/**
 * @param $url
 *
 * @return bool|string
 * @throws \Exception
 */
function get_file($url)
{
	$curl = curl_init ();
	$options = default_ops (true, true, [CURLOPT_URL => $url]);
	curl_setopt_array ($curl, $options);
	$output = curl_exec ($curl);
	//print $output;
	$err = curl_errno ($curl);
	$errmsg = curl_error ($curl);
	if ($err != 0) {
		print "ERROR MESSAGE=" . $err . " $errmsg";
	}
	$info = curl_getinfo ($curl);
	if ($info['http_code'] != 200) {
		throw new Exception('HTTP Error retrieving URL ' . $url . ' HTTP return code=' . $info['http_code'] . ' ' . $output);
	}

	return $output;
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
	$cookie_file = 'cookies.txt';
	if ($resetCookieJar && file_exists ($cookie_file)) {
		unlink ($cookie_file);
	}
	$opts = [
		CURLOPT_CONNECTTIMEOUT => 5,
		CURLOPT_TIMEOUT => 10,
		CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.81 Safari/537.36',
		CURLOPT_HEADER => true, // return headers
		CURLOPT_FOLLOWLOCATION => true,    // follow redirects
		CURLOPT_ENCODING => 'UTF-8', // handle all encodings
		CURLOPT_SSL_VERIFYHOST => false, // http://ademar.name/blog/2006/04/curl-ssl-certificate-problem-v.html
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_AUTOREFERER => true,
		CURLOPT_VERBOSE => true,
		CURLOPT_COOKIEFILE => $cookie_file,
		CURLOPT_COOKIEJAR => $cookie_file,
		CURLOPT_COOKIESESSION => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
		CURLOPT_HTTPHEADER => [
			'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.81 Safari/537.36',
			'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
			'Accept-Language' => 'en-US,en;q=0.9,nl;q=0.8',
			'cache-control' => 'max-age=0',
		],
	];

	if ($proxy) {
		$opts[CURLOPT_PROXYTYPE] = 7;
		$opts[CURLOPT_PROXY] = 'http://localhost:9050';
	}
	foreach ($options as $key => $value) {
		$opts[$key] = $value;
	}
	return $opts;
}


print get_file ('https://www.funda.nl/koop/st-annaparochie/huis-40882925-stadhoudersweg-73/'); //https://www.funda.nl/koop/leidschendam/huis-40820553-westvlietweg-126/
