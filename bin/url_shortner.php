<?php

use App\HomeWork04\UrlShortener\Models\FileRepository;
use App\HomeWork04\UrlShortener\Services\UrlValidator;
use App\HomeWork04\UrlShortener\Services\UrlConverter;

require_once __DIR__ . '/../examples/autoload.php';

$fileRepository = new FileRepository(__DIR__ . '/../db_shortner.json');
$urlValidator = new UrlValidator();
$codeLength = 4;
$converter = new UrlConverter(
    $fileRepository,
    $urlValidator,
    $codeLength
);

// 200 code response
$code = $converter->encode('https://fantasy.foot-ball.com.ua/');
echo $code . PHP_EOL;
$url = $converter->decode($code);
echo $url . PHP_EOL;
// 404 code response
$code = $converter->encode('https://fantasy.foot-ball.com.ua/fff');
echo $code . PHP_EOL;
// not exist code
$notExistCode = 'asdasd';
$url = $converter->decode($notExistCode);
echo $url . PHP_EOL;
