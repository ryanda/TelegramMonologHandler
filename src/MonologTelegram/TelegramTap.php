<?php

namespace Ryanda\MonologTelegram;

class TelegramTap
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(function ($record) {
                // if type of exception get source of error
                if (isset($record['context']['exception']) && !empty($record['context']['exception'])) {
                    $e = $record['context']['exception'];
                    $record['extra']['file'] = sprintf('%s : %d', basename($e->getFile()), $e->getLine());
                    $record['extra']['file_full'] = $e->getFile();
                }

                // additional extra info
                $record['extra']['app'] = 'App-Name';

                return $record;
            });
        }
    }
}
