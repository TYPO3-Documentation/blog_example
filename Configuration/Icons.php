<?php

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    // icon identifier
    'blog_example_icon' => [
        // icon provider class
        'provider' => SvgIconProvider::class,
        // the source SVG for the SvgIconProvider
        'source' => 'EXT:blog_example/Resources/Public/Icons/Extension.svg',
    ],
    'blogexample_blog' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_blog.gif',
    ],
    'blogexample_comment' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_comment.gif',
    ],
    'blogexample_person' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_person.gif',
    ],
    'blogexample_post' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_post.gif',
    ],
    'blogexample_tag' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_tag.gif',
    ],
];
