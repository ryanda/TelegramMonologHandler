# Telegram Monolog Handler

Monolog Handler sends your logs to Telegram Channel via Bot.

## Installation

Install using composer

```bash
$ composer require ryanda/monolog-telegram
```

## Basic Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Ryanda\MonologTelegram\TelegramBotHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new TelegramBotHandler('YOUR_API_KEY', 'YOUR_CHANNEL_ID', Logger::WARNING));

// push to the channel
$log->warning('Foo');
$log->error('Bar');
```
