<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'J18.' . $_EXTKEY,
	'Pi1',
	array(
		'Item' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Item' => '',
		
	)
);

?>