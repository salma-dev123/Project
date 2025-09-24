<?php
declare(strict_types=1);

namespace App;

trait LoogerTrait {
    protected string $logFile = __DIR__ . '/../logs/app.log';

    protected function log(string $message): void {
        $ts = date('Y-m-d H:i:s');
        @mkdir(dirname($this->logFile), 0777, true);
        file_put_contents($this->logFile, "[$ts] $message" . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
