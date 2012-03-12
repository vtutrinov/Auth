<?php
/**
 * OpenID authentication gateway
 *
 * @author Slava Tutrinov
 */
class Authtype_OpenID implements Interface_AuthGateway {

    /**
     * @var LightOpenID
     */
    protected $workerObject = null;
    protected $redirectHost = 'ulmart.pr:3356';

    public function __construct() {
        $this -> workerObject = new LightOpenID($this -> redirectHost);
    }

    public function  prepare(Providers_Config $providerConfig) {
        $this -> workerObject -> identity = $providerConfig -> getServer();
        $this -> workerObject -> required = array('contact/email');
        $this -> workerObject -> optional = array('namePerson', 'namePerson/friendly');
    }

    public function  goToProvider() {
        header('Location: '.$this -> workerObject ->authUrl());
    }

    public function  isAuthenticated() {
        return (bool)$this -> workerObject -> mode;
    }

    public function validate() {
        return $this -> workerObject -> validate();
    }

    public function  __get($name) {
        return $this -> workerObject -> $name;
    }

    public function getAttributes() {
        return $this -> workerObject ->getAttributes();
    }

}
?>
