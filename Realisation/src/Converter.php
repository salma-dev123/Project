<?php
declare(strict_types=1);

namespace App;

class Converter implements ConvertibleInterface
{
    use LoogerTrait;

    public function __construct(private int $number) {}

    public function toDecimal(): int {
        return $this->number;
    }

    public function toBinary(): string {
        return decbin($this->number);
    }

    public function toHex(): string {
        return strtoupper(dechex($this->number));
    }

    public function bitwiseAnd(int $other): int
    { 
        return $this->number & $other; 
    }

    public function bitwiseOr(int $other): int 
    { 
        return $this->number | $other; 
    }

    public function bitwiseXor(int $other): int 
    { 
        return $this->number ^ $other; 
    }

    public function bitwiseNot(): int 
    { 
        return ~$this->number; 
    }

    public function shiftLeft(int $bits) : int {
        return $this->number  << $bits;
    }

    public function shiftRight(int $bits) : int {
        return $this->number >> $bits;
    }

    public function formatted(): array {
        return [
            'Decimal' => $this->toDecimal(),
            'Binary'  => $this->toBinary(),
            'Hex'     => $this->toHex(),
        ];
    }
}
