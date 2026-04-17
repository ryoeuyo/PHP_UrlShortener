<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->notPath([
        'config/bundles.php',
        'config/reference.php',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'global_namespace_import' => false,
        'yoda_style' => false,
        'phpdoc_align' => false,
        'concat_space' => false,
    ])
    ->setFinder($finder)
;
