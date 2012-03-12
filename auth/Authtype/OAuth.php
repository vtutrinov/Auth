<?php
/**
 * OAuth authentication gateway
 *
 * @author Slava Tutrinov
 */
class Authtype_OAuth implements Interface_AuthGateway {

    /**
     *
     * @var OAuth
     */
    protected $workerObject = null;
    protected $consumerKey = '';
    protected $consumerSecret = '';
    protected $tokenRequestUrl = '';
    protected $authUrl = '';
    protected $oauth = null;

    /**
     *
     * @var Providers_Config
     */
    protected $provider = null;

    public function  __construct(Providers_Config $provider) {
        $this -> provider = $provider;
    }

    public function  prepare(Providers_Config $providerConfig) {
        $oauthClassName = "Providers_Oauth_".$providerConfig -> getServiceName();
        $this -> oauth = $oauthClassName::prepare($providerConfig);
    }

    public function  goToProvider() {
        $this -> oauth -> goToProvider();
    }

    public function  isAuthenticated() {
        return $this -> oauth -> isAuthenticated();
    }

    public function  validate() {
        return true;
    }

    public function  getAttributes() {
        return $this -> oauth -> getInfo($this -> provider);
    }

}
?>
