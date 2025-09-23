<?php

declare(strict_types=1);
namespace App;

interface ConvertibleInterface{
    public function toDecimal() :int;
    public function toBinary() : string;
    public function toHex() : string;
}