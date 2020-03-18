<?php

namespace App\Log;

use Psr\Log\LoggerInterface;

class ImportLogger
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function info(string $message)
    {
        $this->logger->info($message);
    }

    public function alert(string $message)
    {
        $this->logger->alert($message);
    }
}
