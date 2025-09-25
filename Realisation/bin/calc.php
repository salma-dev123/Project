<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Calculator;

try {
    // lire le fichier input.txt
    $inputFile = __DIR__ . '/../samples/input.txt';
    if (!is_readable($inputFile)) {
        throw new RuntimeException("Le fichier input.txt est introuvable ou illisible.");
    }

    // récupérer le contenu du fichier
    $content = trim(file_get_contents($inputFile));
    [$a, $b] = explode(" ", $content);

    if (!is_numeric($a) || !is_numeric($b)) {
        throw new InvalidArgumentException("Le fichier input.txt doit contenir deux entiers séparés par un espace. Exemple: '5 3'");
    }

    // utiliser Calculator
    $calc = new Calculator((int)$a, (int)$b);
    $calc->display();

    // sauvegarde des résultats dans un fichier JSON
    @mkdir(__DIR__ . '/../samples', 0777, true);
    file_put_contents(
        __DIR__ . '/../samples/output.json',
        json_encode($calc->calculate(), JSON_PRETTY_PRINT)
    );

} catch (Throwable $e) {
    fwrite(STDERR, "Erreur: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
