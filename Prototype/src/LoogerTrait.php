<?php 
declare(strict_types=1);

namespace App;
trait LoogerTrait{
    protected function log(string $message) : void {
        $ts=date('y-m-d H:i:s');
        file_put_contents(__DIR__. '/../logs/app.log',"[$ts] $message", FILE_APPEND);
    }
}