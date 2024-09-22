<?php
namespace App\Logging;

class Logger
{
    private $logFile;

    public function __construct($logFile = null)
    {
        $this->logFile = $logFile ?? __DIR__ . '/../../logs/app.log';
    }

    public function log($message, $level = 'INFO')
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    public function info($message)
    {
        $this->log($message, 'INFO');
    }

    public function warning($message)
    {
        $this->log($message, 'WARNING');
    }

    public function error($message)
    {
        $this->log($message, 'ERROR');
    }
}
