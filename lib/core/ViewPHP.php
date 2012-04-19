<?php

namespace pff;

/**
 * View that uses plain php files as template.
 *
 * @author paolo.fagni<at>gmail.com
 */
class ViewPHP extends \pff\AView {

    /**
     * @var array Contains the data to be used in the template file
     */
    private $_data;

    public function set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function render() {
        $templatePath = ROOT . DS . 'app' . DS . 'views' . DS . $this->_templateFile;
        if(!file_exists($templatePath)){
            throw new \pff\ViewException('Template file '.$templatePath.' does not exist');
        }
        extract($this->_data); // Extract set data to scope vars
        ob_start(array($this,'preView'));
        /*$locale = "it_IT.utf8";
        putenv("LC_ALL=$locale");
        setlocale(LC_ALL, $locale);
        bindtextdomain("messages", ROOT . DS. 'app' . DS . 'locale');
        textdomain("messages");*/
        include (ROOT . DS . 'app' . DS . 'views' . DS . $this->_templateFile);
        ob_end_flush();
    }

    /**
     * Callback method to sanitize HTML output
     *
     * @param string $output HTML output string
     * @return string
     */
    public function preView($output) {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('HTML.TidyLevel', 'medium');

        $purifier = new \HTMLPurifier($config);
        $output   = $purifier->purify($output);

        return $output;
    }


}
