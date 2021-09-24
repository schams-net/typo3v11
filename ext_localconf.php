<?php
declare(strict_types=1);

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

// all use statements must come first
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Prevent Script from being called directly
defined('TYPO3') or die();

// encapsulate all locally defined variables
(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Typo3v11',
        'Frontend',
        [
            \SchamsNet\Typo3v11\Controller\ExampleController::class => 'list, detail'
        ],
        [
            \SchamsNet\Typo3v11\Controller\ExampleController::class => 'list, detail'
        ]
    );
})();
