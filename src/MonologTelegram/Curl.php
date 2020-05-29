<?php

namespace Ryanda\MonologTelegram;

class Curl
{
    public static function execute($ch)
    {
        if (curl_exec($ch) === false) {
            $curlErrno = curl_errno($ch);

            $curlError = curl_error($ch);

            curl_close($ch);

            throw new \RuntimeException(sprintf('Curl error (code %s): %s', $curlErrno, $curlError));
        }

        curl_close($ch);
    }
}
