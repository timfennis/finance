<?php

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__.'/src/')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'phpdoc_order' => true,
        'concat_space' => ['spacing' => 'one'] ,
        'phpdoc_add_missing_param_annotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'protected_to_private' => true,
        'no_useless_return' => true,
        'linebreak_after_opening_tag' => true,
        'phpdoc_align' => false,
        'declare_strict_types' => true,
        'mb_str_functions' => true,
        'modernize_types_casting' => true,
        'no_php4_constructor' => true,
        'no_useless_else' => true,
        'random_api_migration' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ;
