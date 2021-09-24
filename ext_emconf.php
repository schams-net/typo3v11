<?php
declare(strict_types=1);

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 *
 * NOTE: This file is not required in Composer-based TYPO3 installations anymore.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 v11 Demo/Test Extension',
    'description' => 'Demo/test extension for TYPO3 v11',
    'category' => 'example',
    'author' => 'Michael Schams',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.0.0-11.99.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ]
    ]
];
