<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Nitsan.' . $_EXTKEY,
	'Nitsansharethis',
	'Nitsan Social Widget'
	// TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'sharethis.png'
   	);
    $pluginSignature = str_replace('_', '', $_EXTKEY).'_nitsansharethis';

	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_socialwidget.xml');	


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Nitsan Sharethis');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nssharethis_domain_model_sharethis', 'EXT:ns_sharethis/Resources/Private/Language/locallang_csh_tx_ns_sharethis_domain_model_sharethis.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_sharethis/Configuration/TSconfig/ContentElementWizard.txt">'
);
