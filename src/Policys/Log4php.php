<?php

namespace App\Policys;
use App\Contracts\LogInterface;

class Log4php implements LogInterface
{
    function __construct()
    {
        $this->logger = \Logger::getLogger("Log");
    }

    function info($message)
    {
        $this->logger->info($message);
    }

    function debug($message)
    {
        $this->logger->debug($message);
    }

    function error($message)
    {
        $this->logger->error($message);
    }
}
