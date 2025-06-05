<?php
require __DIR__ . '/../vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;

$compiler = new Compiler();

// Définir le dossier racine pour les imports
$compiler->setImportPaths(__DIR__ . '/../styles/');

// Définissez les chemins
$inputFile = __DIR__ . '/../styles/style.scss';
$outputFile = __DIR__ . '/../public/assets/styles/style.css';

// Assurez-vous que le dossier de sortie existe
if (!is_dir(dirname($outputFile))) {
    mkdir(dirname($outputFile), 0777, true);
}

// Compilez le SCSS
try {
    $scss = file_get_contents($inputFile);
    $css = $compiler->compileString($scss)->getCss();
    file_put_contents($outputFile, $css);
    echo "SCSS compiled successfully!\n";
} catch (Exception $e) {
    echo "Compilation failed: " . $e->getMessage() . "\n";
}
