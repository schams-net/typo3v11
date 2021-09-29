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
    // Domain model "Example"
    ExtensionManagementUtility::addLLrefForTCAdescr(
        'tx_typo3v11_domain_model_example',
        'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_typo3v11_domain_model_example.xlf'
    );
    ExtensionManagementUtility::allowTableOnStandardPages(
        'tx_typo3v11_domain_model_example'
    );
})();
