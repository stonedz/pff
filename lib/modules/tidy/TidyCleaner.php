<?php

namespace pff\modules;

/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class TidyCleaner extends \pff\AModule implements \pff\IBeforeViewHook, \pff\IAfterViewHook {

    /**
     * Executes actions before the Views are rendered
     *
     * @return mixed
     */
    public function doBeforeView() {
        ob_start(array($this,'preView'));
    }

    /**
     * Executes actions after the views are rendered
     *
     * @return mixed
     */
    public function doAfterView() {
        ob_end_flush();
    }


    /**
     * @param $output
     * @return \tidy
     */
    public function preView($output) {
        $config = array(
            'show-body-only' => false,
            'clean' => true,
            'char-encoding' => 'utf8',
            'add-xml-decl' => true,
            'add-xml-space' => true,
            'output-html' => false,
            'output-xml' => false,
            'output-xhtml' => true,
            'numeric-entities' => false,
            'ascii-chars' => false,
            'doctype' => 'auto',
            'bare' => true,
            'fix-uri' => true,
            'indent' => true,
            'indent-spaces' => 4,
            'tab-size' => 4,
            'wrap-attributes' => true,
            'wrap' => 0,
            'indent-attributes' => true,
            'join-classes' => true,
            'join-styles' => false,
            'enclose-block-text' => true,
            'fix-bad-comments' => true,
            'fix-backslash' => true,
            'replace-color' => false,
            'wrap-asp' => false,
            'wrap-jste' => false,
            'wrap-php' => false,
            'write-back' => true,
            'drop-proprietary-attributes' => false,
            'hide-comments' => true,
            'hide-endtags' => false,
            'literal-attributes' => false,
            'drop-empty-paras' => true,
            'enclose-text' => true,
            'quote-ampersand' => true,
            'quote-marks' => false,
            'quote-nbsp' => true,
            'vertical-space' => true,
            'wrap-script-literals' => false,
            'tidy-mark' => true,
            'merge-divs' => false,
            'repeated-attributes' => 'keep-last',
            'break-before-br' => true,
        );
        $tidy = new \tidy();
        $tidy->parseString($output, $config, 'utf8');
        $tidy->cleanRepair();
        return $tidy;
        // Output
    }
}
