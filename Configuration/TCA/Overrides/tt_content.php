<?php
declare(strict_types=1);

/**
 * TYPO3 Configuration Array (TCA) to override the tt_content model
 * @author Michael Schams | https://schams.net
 */

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Typo3v11',
    'Frontend',
    //'LLL:EXT:typo3v11/Resources/Private/Language/locallang_be.xlf:title',
    'Frontend Plugin',
    'EXT:typo3v11/Resources/Public/Icons/frontend-plugin.svg'
);
