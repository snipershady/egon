<?php

$finder = (new PhpCsFixer\Finder())
        ->in(__DIR__ . "/src")
        ->in(__DIR__ . "/tests")
        ->exclude('var')
        ->exclude('vendor')
;
return (new PhpCsFixer\Config())
                ->setRules([
                    '@PhpCsFixer' => true,
                    '@PhpCsFixer:risky' => true,
                    '@PHPUnit100Migration:risky' => true,
                    'declare_strict_types' => true,
                    'strict_comparison' => true,
                    'strict_param' => true,
                    'ordered_class_elements' => true,
                    'ordered_imports' => [
                        'sort_algorithm' => 'alpha',
                    ],
                    'phpdoc_to_comment' => false,
                    'yoda_style' => true,
                    'php_unit_test_class_requires_covers' => false,
                    'final_internal_class' => false,
                    // Would rewrite assertEquals() to assertSame() even where the DTO
                    // returns string and the expectation is an int literal, breaking
                    // otherwise-passing tests via strict type comparison.
                    'php_unit_strict' => false,
                ])
                ->setRiskyAllowed(true)
                ->setFinder($finder)
;
