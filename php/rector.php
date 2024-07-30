<?php

declare(strict_types=1);

use Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use RectorLaravel\Set\LaravelSetList;
use Vanta\Integration\Rector\GitlabOutputFormatter;

try {
    $projectRoot = realpath(__DIR__);
    $setDir = dirname(LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL);

    return RectorConfig::configure()
        ->withPaths([
            $projectRoot . '/app',
            $projectRoot . '/bootstrap',
            $projectRoot . '/config',
            $projectRoot . '/database',
            $projectRoot . '/public/index.php',
            $projectRoot . '/resources/views',
            $projectRoot . '/routes',
            $projectRoot . '/tests',
        ])
        ->withPhpSets()
        ->withSets([
            LaravelSetList::LARAVEL_110,
            LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
            LaravelSetList::LARAVEL_CODE_QUALITY,
            LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
            LaravelSetList::LARAVEL_CODE_QUALITY,
            LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
            LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
            LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
            $setDir . '/laravel-container-string-to-fully-qualified-name.php',
            $setDir . '/laravel-if-helpers.php',
        ])
        ->withRules([
            AddVoidReturnTypeWhereNoReturnRector::class,
        ])->withSkip([
            AddOverrideAttributeToOverriddenMethodsRector::class,
        ])->registerService(GitlabOutputFormatter::class, 'gitlab', OutputFormatterInterface::class);
} catch (Throwable $exception) {
    var_dump($exception->getMessage());
    exit(1);
}
