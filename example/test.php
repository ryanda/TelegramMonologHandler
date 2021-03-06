<?php

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Ryanda\MonologTelegram\TelegramBotHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new TelegramBotHandler('YOUR_API_KEY', 'YOUR_CHANNEL_ID', Logger::WARNING));

// push to the channel
$log->warning('Foo');
$log->error('Bar');
