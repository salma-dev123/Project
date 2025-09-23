<?php

declare(strict_types=1);
namespace App;

use App\BatchConverter;
use App\Converter;

use InvalidArgumentException;
use RuntimeException;
use Throwable;

require __DIR__ . '/../vendor/autoload.php';

$options = getopt("", ['help', 'number:', 'input:', 'output:', 'mode:', 'bitop:', 'other:']);
if(isset($options['help'])){
    echo "Usage:\n";
    echo "php convert.php --number=42\n";
    echo "php convert.php --input=data/sample.json --output=out.json --mode=batch\n";
    echo "Options:\n";
    echo "--number : single number to convert\n";
    echo "--input : fichier json d'entrée avec array des nombres\n";
    echo "--output : fichier de sortie des resultats\n";
    echo "--mode : single(par defaut) ou batch\n";
    echo "--bitop : AND, OR, XOR, NOT, SHL, SHR (opérations optionnelles en mode single)\n";
    exit(0);
}

$mode=$options['mode'] ?? 'single';
try{
    if($mode === 'single'){
        $input=$options['number'] ?? null;
        if ($input === null || !is_numeric($input)){
            throw new InvalidArgumentException("entrer un nombre valide en mode single");
        }
        $num=(int)($input);
        $conv=new Converter($num);
        $result=$conv->formatted();

        if(isset($options['bitop'])){
            $op=strtoupper($options['bitop']);
            $other=$options['other'] && is_numeric($options['other']) ? (int)($options['other']) : 0;
            $result['bitwise']=match($op){
                'AND'=> $conv->bitwiseAnd($other),
                'OR' => $conv->bitwiseOr($other),
                'XOR'=> $conv->bitwiseXor($other),
                'NOT'=> $conv->bitwiseNot(),
                'SHL'=> $conv->shiftLeft($other),
                'SHR' => $conv->shiftRight($other),
                default => 'Opération invalide',
            };
        } 
        echo "Decimal : {$result['Decimal']}\n";
        echo "Binary :{$result['Binary']}\n";
        echo "HexaDecimal :{$result['HexaDecimal']}\n";

        if(isset($result['bitwise'])){
            echo "Bitwise Result : {$result['bitwise']}\n";
        }
        exit(0);
    }elseif($mode ==='batch'){
        $inputFile=$options['input'] ?? null;
        if($inputFile === null || !is_readable($inputFile)){
            throw new RuntimeException("fichier d'entrée invalide ou ilisible");
        }
        $json=file_get_contents($inputFile);
        $data=json_decode($json,true);
        if(!is_array($data)){
            throw new RuntimeException((" le fichier d'entrée doit contenir un array des nombres"));
        }

        $batch= new BatchConverter($data);
        $out= $batch->toAll();

        $outputFile=$options['output'] ?? "out.json";
        file_put_contents($outputFile, json_encode($out, JSON_PRETTY_PRINT));
        echo "Conversion en mode batch terminée :" . count($out). "elements écrits dans $outputFile\n";
        exit(0);
    }

}
catch(Throwable $e){
    fwrite(STDERR, "Erreur" .   $e->getMessage()  . "\n");
    exit(1);
}