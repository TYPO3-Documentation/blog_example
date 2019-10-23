<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = unserialize($_EXTCONF);

/**
 * Configure the Plugin to call the
 * right combination of Controller and Action according to
 * the user input (default settings, FlexForm, URL etc.)
 */
if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['registerSinglePlugin']) {
	// fully fletged blog
	Tx_Extbase_Utility_Extension::configurePlugin(
		$_EXTKEY,																	// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
		'Pi1',																		// A unique name of the plugin in UpperCamelCase
		array (																		// An array holding the controller-action-combinations that are accessible
			'Blog' => 'index,new,create,delete,deleteAll,edit,update,populate',		// The first controller and its first action will be the default
			'Post' => 'index,show,new,create,delete,edit,update',
			'Comment' => 'create,delete'
		),
		array(																		// An array of non-cachable controller-action-combinations (they must already be enabled)
			'Blog' => 'create,delete,deleteAll,update,populate',
			'Post' => 'create,delete,update',
			'Comment' => 'create,delete'
		)
	);
} else {

	// Blog plugins
	Tx_Extbase_Utility_Extension::configurePlugin(
		$_EXTKEY,
		'BlogList',
		array('Blog' => 'index')
	);

	// Post plugins
	Tx_Extbase_Utility_Extension::configurePlugin(
		$_EXTKEY,
		'PostList',
		array('Post' => 'index')
	);
	Tx_Extbase_Utility_Extension::configurePlugin(
		$_EXTKEY,
		'PostSingle',
		array('Post' => 'show', 'Comment' => 'create'),
		array('Comment' => 'create')
	);

	// admin plugins
	Tx_Extbase_Utility_Extension::configurePlugin(
		$_EXTKEY,
		'BlogAdmin',
		array(
			'Blog' => 'new,create,delete,deleteAll,edit,update,populate',
			'Post' => 'new,create,delete,edit,update',
			'Comment' => 'delete',
		),
		array(
			'Blog' => 'create,delete,deleteAll,update,populate',
			'Post' => 'create,delete,update',
			'Comment' => 'delete',
		)
	);
}

?>