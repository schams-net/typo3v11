<?php
declare(strict_types=1);

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

// all use statements must come first
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use SchamsNet\Typo3v11\Controller\ExampleController;

// Prevent Script from being called directly
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Typo3v11',
    'Frontend',
    [
        ExampleController::class => 'list, show'
    ],
    [
        ExampleController::class => 'list, show'
    ]
);
