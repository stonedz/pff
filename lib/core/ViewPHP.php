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
        if(is_array($this->_data)) {
            extract($this->_data); // Extract set data to scope vars
        }

        //ob_start(array($this,'preView'));
        /*$locale = "it_IT.utf8";
        putenv("LC_ALL=$locale");
        setlocale(LC_ALL, $locale);
        bindtextdomain("messages", ROOT . DS. 'app' . DS . 'locale');
        textdomain("messages");*/

        include (ROOT . DS . 'app' . DS . 'views' . DS . $this->_templateFile);
        //ob_end_flush();
    }

    /**
     * Callback method to sanitize HTML output
     *
     * @param string $output HTML output string
     * @return string
     */
    public function preView($output) {
        $purifierConfig = \HTMLPurifier_Config::createDefault();
        $purifierConfig->set('Core.Encoding', 'UTF-8');
        $purifierConfig->set('HTML.TidyLevel', 'medium');

        /** @var \HTMLPurifier_Config $purifierConfig */
        $purifier = new \HTMLPurifier($purifierConfig);
        $output   = $purifier->purify($output);

        return $output;
    }


}
