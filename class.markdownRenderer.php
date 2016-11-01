<?php

/**
 * Class SeedDMS_ExtMarkdownRenderer
 *
 * Subscribe hooks.
 *
 * @category DMS
 * @package SeedDMS_ExtMarkdownRenderer
 * @license MIT
 * @author Stefan Berger
 * @copyright Copyright (C) 2016, Stefan Berger
 * @version 31.10.16
 */
class SeedDMS_ExtMarkdownRenderer extends SeedDMS_ExtBase {

    public function init() {

        $GLOBALS['SEEDDMS_HOOKS']['controller']['viewOnline'][] = new SeedDMS_ExtMarkdownRenderer_ViewDocumentOnline;
    }
}

/**
 * Class SeedDMS_ExtMarkdownRenderer_ViewDocumentOnline
 *
 * Customize online display of markdown files.
 *
 * @category DMS
 * @package SeedDMS_ExtMarkdownRenderer
 * @license MIT
 * @author Stefan Berger
 * @copyright Copyright (C) 2016, Stefan Berger
 * @version 31.10.16
 */
class SeedDMS_ExtMarkdownRenderer_ViewDocumentOnline {

    /**
     * Method called by hook
     *
     * @param SeedDMS_Controller_ViewOnline $viewOnline
     * @return bool
     */
    public function version(SeedDMS_Controller_ViewOnline $viewOnline) {

        /** @var SeedDMS_Core_DocumentContent $content */
        $content = $viewOnline->getParam('content');
        /** @var SeedDMS_Core_DMS $dms */
        $dms = $viewOnline->getParam('dms');
        /** @var Settings $settings */
        $settings = $viewOnline->getParam('settings');

        if(strtolower($content->getFileType()) !== '.md') {
            return false;
        }

        # if files should not be shown "online" this extension is not responsible for rendering
        if (!isset($settings->_viewOnlineFileTypes) || !is_array($settings->_viewOnlineFileTypes)) {
            return false;
        }

        # if markdown files should not be shown "online" this extension is not responsible for rendering
        if(!in_array('.md', $settings->_viewOnlineFileTypes)) {
            return false;
        }

        include_once('parsedown/Parsedown.php');
        if(!class_exists('Parsedown')) {
            return false;
        }

        $this->renderMarkdown($dms->contentDir . $content->getPath(), $settings->_httpRoot);

        return true;
    }

    /**
     * @param string $fullPath path and filename of physical file
     * @param string $httpRoot HTTP base directory of SeedDMS
     */
    protected function renderMarkdown($fullPath, $httpRoot) {

        $parsed = Parsedown::instance()->text(file_get_contents($fullPath));

        $output = '<!DOCTYPE html><html lang="en"><head><title></title><link rel="stylesheet" href="' .
            $httpRoot . 'ext/markdownRenderer/markdown.css"/></head><body class="markdown-body">' . $parsed . '</body></html>';

        $fileSize = strlen($output);

        header("Content-Type: text/html");
        header("Content-Length: " . $fileSize);
        header("Expires: 0");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        ob_clean();
        echo $output;
    }

}
