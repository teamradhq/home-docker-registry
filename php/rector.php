<?php

declare(strict_types=1);

use Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Vanta\Integration\Rector\GitlabOutputFormatter;

try {
    $projectRoot = realpath(__DIR__ . '/..');

    return RectorConfig::configure()
        ->withPaths([
            $projectRoot . '/app',
            $projectRoot . '/bootstrap.php',
            $projectRoot . '/config',
            $projectRoot . '/console',
            $projectRoot . '/tests',
        ])
        ->withPhpSets()
        ->withRules([
            AddVoidReturnTypeWhereNoReturnRector::class,
        ])->withSkip([
            AddOverrideAttributeToOverriddenMethodsRector::class,
        ])->registerService(GitlabOutputFormatter::class, 'gitlab', OutputFormatterInterface::class);
} catch (Throwable $exception) {
    var_dump($exception->getMessage());
    exit(1);
}
