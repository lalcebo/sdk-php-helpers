<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 4/17/21 9:49 PM
 */

declare(strict_types=1);

use PhpCsFixer\Finder;

return (new PhpCsFixer\Config())
    ->setRules(
        [
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'no_unused_imports' => true,
            'concat_space' => [
                'spacing' => 'one'
            ]
        ]
    )
    ->setFinder(
        Finder::create()
            ->in(__DIR__)
            ->exclude(['vendor'])
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
    );
