<?php
/**
 * ProviderConfig
 *
 * @author Slava Tutrinov
 */
class Providers_Config {

    protected $openIdServer = '';
    protected $redirectURL = '';
    protected $iconSrc = '';
    protected $serviceName = '';
    protected $protocol = '';
    protected $params = array();
    protected $userNameRequired = false;
    protected $consumerSecret = null;
    protected $consumerKey = null;

    public function setServer($serverUrl) {
        $this -> openIdServer = $serverUrl;
    }

    public function getServer() {
        return $this -> openIdServer;
    }

    public function setRedirectUrl($redirectUrl) {
        $this -> redirectURL = $redirectUrl;
    }

    public function getRedirectUrl() {
        return $this -> redirectURL;
    }

    public function setIconSrc($ico) {
        $this -> iconSrc = $ico;
    }

    public function getIconSrc() {
        return $this -> iconSrc;
    }

    public function setServiceName($name) {
        $this -> serviceName = $name;
    }

    public  function getServiceName() {
        return $this -> serviceName;
    }

    public function setProtocol($protocol) {
        $this -> protocol = $protocol;
    }

    public function getProtocol() {
        return $this -> protocol;
    }

    public function setParams($paramNodes) {
        $params = $paramNodes->item(0)->childNodes;
        foreach ($params as $param) {
            if ($param instanceof  DOMElement && $param->hasAttribute('name') && $param->hasAttribute('value')) {
                $paramName = $param->getAttribute('name');
                if ($param->hasAttribute('alias')) {
                    $paramValue = array('alias' => $param->getAttribute('alias'), 'value' => $param->getAttribute('value'));
                } else {
                    $paramValue = $param ->getAttribute('value');
                }
                $this -> $paramName  = $paramValue;
            }
        }
    }

    public function setUserNameRequired(DOMDocument $xmlConfig) {
        $userNodes = $xmlConfig ->getElementsByTagName('username');
        $userRequired = (int)$userNodes -> item(0) -> getAttribute('required');
        $this -> userNameRequired = (bool)$userRequired;
    }

    public function isUserNameRequired() {
        return $this -> userNameRequired;
    }

    public function getParam($paramName) {
        return $this -> params[$paramName];
    }

    public function setConsumerKey($key) {
        $this -> consumerKey = $key;
    }

    public function getConsumerKey() {
        return $this -> consumerKey;
    }

    public function setConsumerSecret($secret) {
        $this -> consumerSecret = $secret;
    }

    public function getConsumerSecret() {
        return $this -> consumerSecret;
    }

    public function __set($name, $value) {
        $this -> params[$name] = $value;
    }

}
?>
