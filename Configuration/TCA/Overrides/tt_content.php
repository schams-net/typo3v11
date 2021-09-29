<?php
declare(strict_types=1);

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3_MODE') or die();

ExtensionUtility::registerPlugin(
    'Typo3v11',
    'Frontend',
    //'LLL:EXT:typo3v11/Resources/Private/Language/locallang_be.xlf:title',
    'Frontend Plugin',
    'EXT:typo3v11/Resources/Public/Icons/typo3.svg'
);
