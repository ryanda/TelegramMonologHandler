<?php

namespace Ryanda\MonologTelegram;

use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\NormalizerFormatter;

class TelegramFormatter extends NormalizerFormatter
{
    const DATE_FORMAT = 'Y-m-d H:i:s e';

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
        $lineFormatter = new LineFormatter();

        $message = $record['message'].PHP_EOL;

        if ($record['context']) {
            $context = '*Context*  '.PHP_EOL;
            $context .= '```'.$lineFormatter->stringify($record['context']).'```';
            $message .= $context.PHP_EOL;
        }

        if ($record['extra']) {
            $extra = '*Extra*  '.PHP_EOL;
            $extra .= '```'.$lineFormatter->stringify($record['extra']).'```';
            $message .= $extra.PHP_EOL;
        }

        return sprintf('%s %s at %s: %s', $emoji, $record['level_name'], $record['datetime'], $message);
    }
}
