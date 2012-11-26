<?php
namespace pff\modules;

/**
 * Module to perform payment with Paypal express checkout system
 * 
 * @author Marco Bernini <marco.bernini@neropaco.net> 
 */
class Paypal extends \pff\AModule {
    
    /**
     * This constant value is provided by Paypal to a merchant (seller) account.
     */
    private $_API_USERNAME;
    
    /**
     * This constant value is provided by Paypal to a merchant (seller) account.
     */
    private $_API_PASSWORD;
    
    /**
     * This constant value is provided by Paypal to a merchant (seller) account.
     */    
    private $_API_SIGNATURE;
    
    /**
     * This is the server URL which you have to connect for submitting your API request.
     */
    private $_API_ENDPOINT;
    
    /**
     * The latest version of API service. 
     */
    private $_version;
    
    /**
     * Define the PayPal URL. This is the URL that the buyer is first sent to 
     * to authorize payment with their paypal account.
     */
    private $_paypal_url;
    
    /**
     * @var NetworkHelper 
     */
    private $_nh;
    
    public function __construct($network_helper, $configFile = 'paypal/paypal.conf.yaml') {
        $this->_nh = $network_helper;
        $this->loadConfig($this->readConfig($configFile));
    }    
    
    
    public function getAPI_USERNAME() {
        return $this->_API_USERNAME;
    }

    public function setAPI_USERNAME($API_USERNAME) {
        $this->_API_USERNAME = $API_USERNAME;
    }

    public function getAPI_PASSWORD() {
        return $this->_API_PASSWORD;
    }

    public function setAPI_PASSWORD($API_PASSWORD) {
        $this->_API_PASSWORD = $API_PASSWORD;
    }

    public function getAPI_SIGNATURE() {
        return $this->_API_SIGNATURE;
    }

    public function setAPI_SIGNATURE($API_SIGNATURE) {
        $this->_API_SIGNATURE = $API_SIGNATURE;
    }
    
    public function getAPI_ENDPOINT() {
        return $this->_API_ENDPOINT;
    }

    public function setAPI_ENDPOINT($API_ENDPOINT) {
        $this->_API_ENDPOINT = $API_ENDPOINT;
    }

    public function getVersion() {
        return $this->_version;
    }

    public function setVersion($_version) {
        $this->_version = $_version;
    }

    public function getPaypal_url() {
        return $this->_paypal_url;
    }

    public function setPaypal_url($_paypal_url) {
        $this->_paypal_url = $_paypal_url;
    }
    
    /**
     * Reads parsed config file and sets needed attributes
     * 
     * @param array $config
     * @throws PaypalException
     */
    private function loadConfig($config) {
        if(isset($config['moduleConf']['API_USERNAME']) && 
                isset($config['moduleConf']['API_PASSWORD']) && 
                isset($config['moduleConf']['API_SIGNATURE']) &&
                isset($config['moduleConf']['API_ENDPOINT']) &&
                isset($config['moduleConf']['version']) &&
                isset($config['moduleConf']['paypal_url'])){
            $this->setAPI_USERNAME($config['moduleConf']['API_USERNAME']);
            $this->setAPI_PASSWORD($config['moduleConf']['API_PASSWORD']);
            $this->setAPI_SIGNATURE($config['moduleConf']['API_SIGNATURE']);
            $this->setAPI_ENDPOINT($config['moduleConf']['API_ENDPOINT']);
            $this->setVersion($config['moduleConf']['version']);
            $this->setPaypal_url($config['moduleConf']['paypal_url']);
        }
        else{
            throw new PaypalException('Missing values in config file.');
        }
    }
    
    /**
     * Initialize the npv string with required pairs for sale transactions.
     * 
     * @param string $method API service name (es. "setExpressCheckout") 
     * @return string|boolean
     */
    public function nvpStringInit($method){
        if($method != ""){
            $str = "METHOD=".urlencode($method)."&VERSION=".urlencode($this->getVersion()).
                    "&NOSHIPPING=1&LOCALECODE=IT&PAYMENTREQUEST_0_PAYMENTACTION=Sale
                        &REQCONFIRMSHIPPING=0&L_PAYMENTREQUEST_0_ITEMCATEGORY0=Digital
                        &PAYMENTREQUEST_0_CURRENCYCODE=EUR";
            return $str;
        }
        return false;
    }
    
    /**
     * Create the nvp (name value pairs) string for the API call
     * 
     * @param string $name the name of the pair name - value, must be uppercase
     * @param string $value the value associated to name provided
     * @param string $str the nvp string generated so far (initially is empty)
     * @return string|boolean
     */
    public function nvpStringCreator($name = "", $value = "", $str = "") {
        if($str != "") {
            if($name != "" && $value != "") {
                $valtoadd = "&".$name."=".urlencode($value);
                $str = $str.$valtoadd;
                return $str;
            }
            else {
                return false;
            }
        }
        //is first value in the string
        else {
            if($name != "" && $value != "") {
                $valtoadd = $name."=".urlencode($value);
                $str = $valtoadd;
                return $str;
            }
            else {
                return false;
            }
        }
    }
    
    public function callAPIService($service, $nvpstr){
        if($service == "" || $nvpstr == ""){
            throw new PaypalException('Parametri non validi');
        }
        $url = $this->getAPI_ENDPOINT();
        $this->_nh->doPost($url, $nvpstr, 443);
    }
}