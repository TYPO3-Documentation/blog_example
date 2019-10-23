<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);

/**
 * Registers a Plugin to be listed in the Backend. You also have to configure the Dispatcher in ext_localconf.php.
 */
if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['registerSinglePlugin']) {
	Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY,// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
		'Pi1',				// A unique name of the plugin in UpperCamelCase
		'A Blog Example'	// A title shown in the backend dropdown field
	);

	$pluginSignature = strtolower($extensionName) . '_pi1';
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key';
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform,recursive';
	t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');
} else {
	t3lib_div::loadTCA('tt_content');
	//$TCA['tt_content']['columns']['list_type']['config']['iconsInOptionTags'] = 0;
	$TCA['tt_content']['columns']['list_type']['config']['items'][] = array('Blog Example', '--div--', t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif');
	Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY,
		'BlogList',
		'List of Blogs (BlogExample)'
	);
	Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY,
		'PostList',
		'List of Posts (BlogExample)'
	);
	Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY,
		'PostSingle',
		'Single Post (BlogExample)'
	);
	Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY,
		'BlogAdmin',
		'Admin Plugin (BlogExample)'
	);
	$TCA['tt_content']['columns']['list_type']['config']['items'][] = array('', '--div--');

	$pluginSignature = strtolower($extensionName) . '_postlist';
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key';
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform,recursive';
	t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');
}

if (TYPO3_MODE === 'BE')	{
	/**
	* Registers a Backend Module
	*/
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',					// Make module a submodule of 'web'
		'tx_blogexample_m1',	// Submodule key
		'',						// Position
		array(																			// An array holding the controller-action-combinations that are accessible
			'Blog' => 'index,new,create,delete,deleteAll,edit,update,populate',	// The first controller and its first action will be the default
			'Post' => 'index,show,new,create,delete,edit,update',
			'Comment' => 'create,delete,deleteAll',
			),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:blog_example/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
		)
	);

}

/**
 * Add labels for context sensitive help (CSH)
 */
t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_BlogExampleTxBlogexampleM1', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BlogExample setup');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/DefaultStyles', 'BlogExample CSS Styles (optional)');

t3lib_extMgm::allowTableOnStandardPages('tx_blogexample_domain_model_blog');
$TCA['tx_blogexample_domain_model_blog'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_blogexample_domain_model_blog.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_blogexample_domain_model_post');
$TCA['tx_blogexample_domain_model_post'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post',
		'label'				=> 'title',
		'label_alt'			=> 'author',
		'label_alt_force'	=> TRUE,
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete'            => 'deleted',
		'enablecolumns'     => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_blogexample_domain_model_post.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_blogexample_domain_model_comment');
$TCA['tx_blogexample_domain_model_comment'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_comment',
		'label'				=> 'date',
		'label_alt'			=> 'author',
		'label_alt_force'	=> TRUE,
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'delete'            => 'deleted',
		'enablecolumns'     => array (
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_blogexample_domain_model_comment.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_blogexample_domain_model_person');
$TCA['tx_blogexample_domain_model_person'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_person',
		'label' 			=> 'lastname',
		'label_alt'			=> 'firstname',
		'label_alt_force'	=> TRUE,
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'prependAtCopy' 	=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_blogexample_domain_model_person.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_blogexample_domain_model_tag');
$TCA['tx_blogexample_domain_model_tag'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_tag',
		'label'				=> 'name',
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'delete'            => 'deleted',
		'enablecolumns'     => array (
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_blogexample_domain_model_tag.gif'
	)
);

t3lib_div::loadTCA('fe_users');
if (is_array($TCA['fe_users']['columns']['tx_extbase_type'])) {
	$TCA['fe_users']['types']['Tx_BlogExample_Domain_Model_Administrator'] = $TCA['fe_users']['types']['0'];
	array_push($TCA['fe_users']['columns']['tx_extbase_type']['config']['items'], array('LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_BlogExample_Domain_Model_Administrator', 'Tx_BlogExample_Domain_Model_Administrator'));
}
?>