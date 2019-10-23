<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_blogexample_domain_model_blog'] = array(
	'ctrl' => $TCA['tx_blogexample_domain_model_blog']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title, posts, administrator'
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_blogexample_domain_model_blog',
				'foreign_table_where' => 'AND tx_blogexample_domain_model_blog.uid=###REC_FIELD_l18n_parent### AND tx_blogexample_domain_model_blog.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array(
				'type'=>'passthrough'
			)
		),
		't3ver_label' => Array (
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => Array (
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'description' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog.description',
			'config'  => array(
				'type' => 'text',
				'eval' => 'required',
				'rows' => 30,
				'cols' => 80,
			)
		),
		'logo' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog.logo',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => 'uploads/pics',
				'show_thumbs'   => 1,
				'size'          => 1,
				'maxitems'      => 1,
				'minitems'      => 0
			)
		),
		'posts' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog.posts',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_blogexample_domain_model_post',
				'foreign_field' => 'blog',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 999999,
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'administrator' => Array (		
			'exclude' => 1,		
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog.administrator',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => "AND fe_users.tx_extbase_type='Tx_BlogExample_Domain_Model_Administrator'",
				'items' => array(
					array('--none--', 0),
					),
				'wizards' => Array(
		             '_PADDING' => 1,
		             '_VERTICAL' => 1,
		             'edit' => Array(
		                 'type' => 'popup',
		                 'title' => 'Edit',
		                 'script' => 'wizard_edit.php',
		                 'icon' => 'edit2.gif',
		                 'popup_onlyOpenIfSelected' => 1,
		                 'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		             ),
		             'add' => Array(
		                 'type' => 'script',
		                 'title' => 'Create new',
		                 'icon' => 'add.gif',
		                 'params' => Array(
		                     'table'=>'fe_users',
		                     'pid' => '###CURRENT_PID###',
	                         'setValue' => 'prepend'
		                 ),
		                 'script' => 'wizard_add.php',
		             ),
		         )
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, title, description, logo, posts, administrator')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_blogexample_domain_model_post'] = array(
	'ctrl' => $TCA['tx_blogexample_domain_model_post']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title, date, author',
		'maxDBListItems' => 100,
		'maxSingleDBListItems' => 500
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, blog, title, date, author, content, tags, comments, related_posts')
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_blogexample_domain_model_post',
				'foreign_table_where' => 'AND tx_blogexample_domain_model_post.uid=###REC_FIELD_l18n_parent### AND tx_blogexample_domain_model_post.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array(
				'type'=>'passthrough'
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'blog' => Array (		
			'exclude' => 1,		
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.blog',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_blogexample_domain_model_blog',
				'maxitems' => 1,
			)
		),		
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'date' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.date',
			'config'  => array(
				'type'    => 'input',
				'size' => 12,
				'checkbox' => 1,
				'eval' => 'datetime, required',
				'default' => time()
			)
		),
		'author' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.author',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_blogexample_domain_model_person',
				'wizards' => Array(
		             '_PADDING' => 1,
		             '_VERTICAL' => 1,
		             'edit' => Array(
		                 'type' => 'popup',
		                 'title' => 'Edit',
		                 'script' => 'wizard_edit.php',
		                 'icon' => 'edit2.gif',
		                 'popup_onlyOpenIfSelected' => 1,
		                 'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		             ),
		             'add' => Array(
		                 'type' => 'script',
		                 'title' => 'Create new',
		                 'icon' => 'add.gif',
		                 'params' => Array(
		                     'table'=>'tx_blogexample_domain_model_person',
		                     'pid' => '###CURRENT_PID###',
		                     'setValue' => 'prepend'
		                 ),
		                 'script' => 'wizard_add.php',
		             ),
		         )
			)
		),
		'content' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.content',
			'config'  => array(
				'type' => 'text',
				'rows' => 30,
				'cols' => 80
			)
		),
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.tags',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_blogexample_domain_model_tag',
				'MM' => 'tx_blogexample_post_tag_mm',
				'maxitems' => 9999,
				'appearance' => array(
					'useCombination' => 1,
					'useSortable' => 1,
					'collapseAll' => 1,
					'expandSingle' => 1,
				)
			)
		),
		'comments' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.comments',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_blogexample_domain_model_comment',
				'foreign_field' => 'post',
				'size' => 10,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 0,
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				)
			)
		),
		'related_posts' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_post.related',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 0,
				'foreign_table' => 'tx_blogexample_domain_model_post',
				'foreign_table_where' => 'AND ###THIS_UID### != tx_blogexample_domain_model_post.uid',
				'MM' => 'tx_blogexample_post_post_mm',
				'MM_opposite_field' => 'related_posts',
			)
		),
	)
);

$TCA['tx_blogexample_domain_model_comment'] = array(
	'ctrl' => $TCA['tx_blogexample_domain_model_comment']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, date, author, email, content'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'date' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_comment.date',
			'config'  => array(
				'type'    => 'input',
				'size' => 12,
				'checkbox' => 1,
				'eval' => 'datetime, required',
				'default' => time()
			)
		),
		'author' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_comment.author',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'email' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_comment.email',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'content' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_comment.content',
			'config'  => array(
				'type' => 'text',
				'rows' => 30,
				'cols' => 80
			)
		),
		'post' => array(		
			'config' => array(
				'type' => 'passthrough',	
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, date, author, email, content')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_blogexample_domain_model_person'] = array(
	'ctrl' => $TCA['tx_blogexample_domain_model_person']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'firstname, lastname, email, avatar'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'firstname' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_person.firstname',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'lastname' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_person.lastname',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'email' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_person.email',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		)
	),
	'types' => array(
		'1' => array('showitem' => 'firstname, lastname, email, avatar')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_blogexample_domain_model_tag'] = array(
	'ctrl' => $TCA['tx_blogexample_domain_model_tag']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, name, posts'
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_blogexample_domain_model_tag',
				'foreign_table_where' => 'AND tx_blogexample_domain_model_tag.uid=###REC_FIELD_l18n_parent### AND tx_blogexample_domain_model_tag.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array(
				'type'=>'passthrough'
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_tag.name',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'posts' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_tag.posts',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 0,
				'foreign_table' => 'tx_blogexample_domain_model_post',
				'MM' => 'tx_blogexample_post_tag_mm',
				'MM_opposite_field' => 'tags',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, hidden, name, posts')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

?>