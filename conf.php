<?php

/**
 * Configuration for extension "Markdown Renderer".
 *
 * @category DMS
 * @package SeedDMS_ExtMarkdownRenderer
 * @license MIT
 * @author Stefan Berger
 * @copyright Copyright (C) 2016, Stefan Berger
 * @version 31.10.16
 */
$EXT_CONF['markdownRenderer'] = array(
    'title' => 'Markdown Renderer',
    'description' => 'Rendered display for Markdown files if viewed "online".',
    'disable' => false,
    'version' => '1.0.0',
    'releasedate' => '2016-10-31',
    'author' => array(
        'name' => 'Stefan Berger',
        'email' => 'mail@example.com',
        'company' => ''
    ),
    'config' => array(
        'checkbox' => array(
            'title'=>'Use Markdown-CSS',
            'type'=>'checkbox',
        ),
    ),
    'constraints' => array(
        'depends' => array(
            'php' => '5.5.0-',
            'seeddms' => '5.0.6-',
        ),
    ),
    'icon' => 'icon.png',
    'class' => array(
        'file' => 'class.markdownRenderer.php',
        'name' => 'SeedDMS_ExtMarkdownRenderer'
    ),
);