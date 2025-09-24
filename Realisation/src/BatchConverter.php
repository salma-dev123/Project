<?php

declare(strict_types=1);
namespace App;

class BatchConverter implements ConvertibleInterface{
    use LoogerTrait;
    private array $numbers;
    public function __construct(array $numbers){
        $clean=array_filter($numbers, fn($n)=> is_numeric($n) && $n!== "" && $n!== null);
        $this->numbers=array_map(fn($n)=> (int) trim((string)($n)) , array_values($clean));
    }

    public function toDecimal(): int
    {
        return $this->numbers[0] ?? 0;
    }

    public function toBinary(): string
    {
        return decBin($this->toDecimal());
    }

    public function toHex(): string
    {
        return strtoupper(dechex($this->toDecimal()));
    }

    public function toAll(): array {
        return array_map(fn(int $n)=>
        [
            "Decimal" => $n,
            "Binary" => decBin($n),
            "HexaDecimal" =>strtoupper((decHex($n)))
        ],
        $this->numbers
        );
    }
}