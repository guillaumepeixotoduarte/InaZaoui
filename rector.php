<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Doctrine\Set\DoctrineSetList;

return RectorConfig::configure()
    // 💡 On garde uniquement le code source et les tests
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    
    // 💡 On active la mise à niveau automatique vers ta version de PHP (indispensable pour les Attributs)
    ->withPhpSets(php83: true)
    
    // 💡 ON AJOUTE ÇA : Les règles spécifiques pour Symfony 6 et Doctrine
    ->withSets([
        SymfonySetList::SYMFONY_64,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
    ])

    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);