<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->in(__DIR__ . '/fakes')
;

$config = new PhpCsFixer\Config();

$config->setRules([
    '@PER-CS1.0' => true
])->setFinder($finder);

return $config;
