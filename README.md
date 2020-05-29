# Telegram Monolog Handler

Monolog Handler sends your logs to Telegram Channel via Bot.

## Requirements

* PHP 5.6 or above
* cURL extension

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

## Integrate with Laravel

Open up `config/logging.php` and find the channels key. Add the following channel to the list.

```php
...
'channels' => [
    'stack' => [
        'driver'   => 'stack',
        'channels' => ['telegram'],
    ],

    ....

    'telegram' => [
        'driver' => 'monolog',
        'handler' => \Ryanda\MonologTelegram\TelegramBotHandler::class,
        'formatter' => \Ryanda\MonologTelegram\TelegramFormatter::class,
        'with' => [
            'apiKey' => env('TELEGRAM_BOT_API'),
            'channel' => env('TELEGRAM_BOT_CHANNEL'),
        ],
    ]
]
...
```

Add the following information to your `.env` file. Your TELEGRAM_BOT_API is the bot key and TELEGRAM_BOT_CHANNEL is the chat ID for a telegram user or channel.

```env
TELEGRAM_BOT_API=123456789:ABCDEFGHIJKLMNOPQUSTUFWXYZabcdefghi
TELEGRAM_BOT_CHANNEL=12345678
```

## Note

If you want to add extra information, you can use `tap` feature on Laravel, by passing it as array.

[Tap documentation](https://laravel.com/docs/5.8/logging#customizing-monolog-for-channels)

```php
'telegram' => [
    'driver' => 'monolog',
    'handler' => \Ryanda\MonologTelegram\TelegramBotHandler::class,
    'formatter' => \Ryanda\MonologTelegram\TelegramFormatter::class,
    'tap' => [\App\Exceptions\TelegramTap::class],
    'with' => [
        'apiKey' => env('TELEGRAM_BOT_API'),
        'channel' => env('TELEGRAM_BOT_CHANNEL'),
    ],
]
```

## License

See [LICENSE](LICENSE).
