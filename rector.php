<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
                ->withPaths([
                    __DIR__ . '/src',
                    __DIR__ . '/tests'
                ])
                ->withSkip([
                    RemoveUselessParamTagRector::class,
                    RemoveUselessReturnTagRector::class,
                    NewlineBetweenClassLikeStmtsRector::class,
                    // Conflicts with php-cs-fixer's php_unit_test_case_static_method_calls
                    // (self:: style), which is the direction we standardize on.
                    PreferPHPUnitThisCallRector::class,
                ])
                ->withCache(__DIR__ . '/.rector.cache')
                ->withPreparedSets(
                        deadCode: true,
                        codeQuality: true,
                        codingStyle: true,
                        typeDeclarations: true,
                        typeDeclarationDocblocks: true,
                        privatization: true,
                        naming: true,
                        namedArgs: false,
                        instanceOf: true,
                        if: true,
                        earlyReturn: true,
                        phpunitCodeQuality: true,
                        phpunitNarrowAsserts: true,
                )
                // No args: resolves the target PHP version from composer.json's
                // "require.php" (>=8.2), instead of assuming a fixed version.
                ->withPhpSets()
                // Pinned to composer.json's floor so Rector never assumes syntax/APIs
                // only available on newer PHP than what the library declares support for.
                ->withSets(
                    [
                        LevelSetList::UP_TO_PHP_84,                    ]
                )
                // No Symfony/Doctrine/Twig/Laravel dependency in composer.json — this
                // library is a plain PSR-4 API client. Only PHPUnit is a real dev dependency.
                ->withComposerBased(phpunit: true)
;
