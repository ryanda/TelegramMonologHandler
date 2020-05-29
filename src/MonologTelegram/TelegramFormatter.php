<?php

namespace Ryanda\MonologTelegram;

use Monolog\Formatter\NormalizerFormatter;

class TelegramFormatter extends NormalizerFormatter
{
    public function __construct()
    {
        parent::__construct();
    }

    public function format(array $record)
    {
        $record = parent::format($record);

        return $this->getException($record);
    }

    /**
     * Generate custom format message from exception log
     * @param array $record
     * @return string
     */
    protected function getException(array $record)
    {
        $emoji = '⚙️';
        $record['level'] = strtolower($record['level_name']);
        $record['description'] = $record['message'];

        return sprintf('%s %s: ```%s```', $emoji, strtoupper($record['level']), $record['description']);
    }
}
