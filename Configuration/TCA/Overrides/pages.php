<?php
declare(strict_types=1);

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3_MODE') or die();

call_user_func(function () {
    // Add a field to pages table to identify demo pages.
    // Field is handled by DataHandler and is not needed to be shown in BE, so it is of type "passthrough"
    $additionalColumns = [
        'tx_typo3v11_demopage' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ];
    ExtensionManagementUtility::addTCAcolumns('pages', $additionalColumns);
});
