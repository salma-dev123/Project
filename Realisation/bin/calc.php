#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Calculator;
use InvalidArgumentException;
use Throwable;

try {
    $a = $argv[1] ?? null;
    $b = $argv[2] ?? null;

    if (!is_numeric($a) || !is_numeric($b)) {
        throw new InvalidArgumentException("Veuillez fournir deux entiers positifs. Exemple: php bin/calc.php 5 3");
    }

    $calc = new Calculator((int)$a, (int)$b);
    $calc->display();

    // sauvegarde résultats
    @mkdir(__DIR__ . '/../samples', 0777, true);
    file_put_contents(__DIR__ . '/../samples/output.json', json_encode($calc->calculate(), JSON_PRETTY_PRINT));

} catch (Throwable $e) {
    fwrite(STDERR, "Erreur: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
