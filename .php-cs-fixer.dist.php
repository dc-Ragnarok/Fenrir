<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->in(__DIR__ . '/fakes')
;

$config = new PhpCsFixer\Config();

$config->setRules([
    '@PER-CS1.0' => true,

    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,

    'explicit_indirect_variable' => true,

    'clean_namespace' => true,

    'assign_null_coalescing_to_coalesce_equal' => true,

    'concat_space' => [
        'spacing' => 'one'
    ],

    'no_useless_nullsafe_operator' => true,

    'declare_strict_types' => true,
    'strict_comparison' => true,

    'single_blank_line_at_eof' => true,
])->setFinder($finder);

return $config;
