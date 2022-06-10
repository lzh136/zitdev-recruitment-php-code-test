<?php

namespace App\Service;

use App\Policys\Log4php;
use App\Policys\ThinkLog;


class AppLogger
{
    const TYPE_LOG4PHP = 'log4php';
    const TYPE_ThINKLOG = 'thinklog';

    private $logger;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        if ($type == self::TYPE_LOG4PHP) {
            $this->logger = new Log4php();
        }else{
            $this->logger = new ThinkLog();
        }
    }

    public function info($message = '')
    {
        $this->logger->info($message);
    }

    public function debug($message = '')
    {
        $this->logger->debug($message);
    }

    public function error($message = '')
    {
        $this->logger->error($message);
    }
}