<?php
$finder = PhpCsFixer\Finder::create()
    ->exclude('vender')
    ->exclude('server')
    ->exclude('webroot')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@PSR2' => true,
    ))
    ->setUsingCache(true)
    ->setFinder($finder);

