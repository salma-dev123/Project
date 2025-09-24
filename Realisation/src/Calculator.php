<?php
declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class Calculator {
    use LoogerTrait;

    public function __construct(private int $a, private int $b) {
        if ($a < 0 || $b < 0) {
            throw new InvalidArgumentException('Les nombres doivent être des entiers positifs.');
        }
    }

    public function calculate(): array {
        $convA = new Converter($this->a);
        $convB = new Converter($this->b);

        return [
            'A' => $convA->formatted(),
            'B' => $convB->formatted(),
            'A_AND_B' => $convA->bitwiseAnd($this->b),
            'A_OR_B' => $convA->bitwiseOr($this->b),
            'A_XOR_B' => $convA->bitwiseXor($this->b),
            'NOT_A' => $convA->bitwiseNot(),
            'NOT_B' => $convB->bitwiseNot()
        ];
    }

    public function display(): void {
        $results = $this->calculate();

        echo "Entrée A : {$results['A']['Decimal']} ({$results['A']['Binary']})\n";
        echo "Entrée B : {$results['B']['Decimal']} ({$results['B']['Binary']})\n";
        echo "A ET B : {$results['A_AND_B']} (" . decbin($results['A_AND_B']) . ")\n";
        echo "A OU B : {$results['A_OR_B']} (" . decbin($results['A_OR_B']) . ")\n";
        echo "A XOR B : {$results['A_XOR_B']} (" . decbin($results['A_XOR_B']) . ")\n";
        echo "NON A : {$results['NOT_A']} (" . decbin($results['NOT_A']) . ")\n";
        echo "NON B : {$results['NOT_B']} (" . decbin($results['NOT_B']) . ")\n";

        $this->log("Calcul effectué: A={$this->a}, B={$this->b}");
    }
}
