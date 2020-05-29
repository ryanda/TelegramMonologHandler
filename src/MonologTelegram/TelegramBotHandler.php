<?php

namespace Ryanda\MonologTelegram;

use Monolog\Logger;
use RuntimeException;
use Monolog\Handler\AbstractProcessingHandler;

class TelegramBotHandler extends AbstractProcessingHandler
{
    const BASE_URL = 'https://api.telegram.org';

    private $apiKey;

    private $channel;

    public function __construct(
        string $apiKey,
        string $channel,
        $level = Logger::DEBUG,
        bool $bubble = true
    ) {
        parent::__construct($level, $bubble);

        $this->apiKey = $apiKey;
        $this->channel = $channel;
        $this->level = $level;
        $this->bubble = $bubble;
    }

    protected function write(array $record): void
    {
        $this->send($record['formatted']);
    }

    protected function send(string $message): void
    {
        $url = $this->urlBuilder();
        $payload = [
            'text' => $message,
            'chat_id' => $this->channel,
            'parse_mode' => 'markdown',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

        $result = Curl::execute($ch);
        $result = json_decode($result, true);

        if ($result['ok'] === false) {
            $errMessage = sprintf('Telegram API error: %s', $result['description']);
            throw new RuntimeException($errMessage);
        }
    }

    protected function urlBuilder()
    {
        return sprintf('%s/bot%s/SendMessage', self::BASE_URL, $this->apiKey);
    }

    protected function getDefaultFormatter()
    {
       return new TelegramFormatter();
    }
}
