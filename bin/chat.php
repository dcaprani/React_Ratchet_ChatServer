#!/usr/bin/php
<?php

require_once __DIR__."/../vendor/autoload.php";

$ip = (isset($argv[1])) ? $argv[1] : "10.0.2.15";
$hostname = (isset($argv[2])) ? $argv[2] : "localhost";


$loop = React\EventLoop\Factory::create();


$http_socket = new React\Socket\Server($loop);
$http = new React\Http\Server($http_socket);
$http->on('request', [ new Demo\Http(), "onRequest" ]);
$http_socket->listen(8000, $ip);

echo "Web server active at http://localhost:8000/\n";


$app = new Ratchet\App($hostname, 5050, $ip, $loop);
$app->route("/", new Demo\Chat());

echo "Chat server active at ws://localhost:5050/\n";

$app->run();



?>
