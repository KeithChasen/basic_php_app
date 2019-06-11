<?php

namespace Kernel;

use Throwable;

trait LostConnection
{
    protected static function checkLostConnection(Throwable $e)
    {
        $message = $e->getMessage();

        return self::checkHaystacks($message);
    }

    protected static function checkHaystacks($message) {
        foreach (self::haystacks() as $haystack) {
            if (strpos($haystack, $message) !== false) {
                return true;
            }
        }

        return false;
    }

    protected static function haystacks() {
        return [
            'server has gone away',
            'no connection to the server',
            'Lost connection',
            'is dead or not enabled',
            'Error while sending',
            'decryption failed or bad record mac',
            'server closed the connection unexpectedly',
            'SSL connection has been closed unexpectedly',
            'Error writing data to the connection',
            'Resource deadlock avoided',
            'Transaction() on null',
            'child connection forced to terminate due to client_idle_limit',
            'query_wait_timeout',
            'reset by peer',
            'Physical connection is not usable',
            'TCP Provider: Error code 0x68',
            'ORA-03114',
            'Packets out of order. Expected',
            'Adaptive Server connection failed',
            'Communication link failure',
        ];
    }
}