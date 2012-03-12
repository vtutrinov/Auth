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

    /**
     *
     * @var Providers_Config
     */
    protected $provider = null;

    public function  __construct(Providers_Config $provider) {
        $this -> provider = $provider;
        $this -> consumerKey = $provider -> getParam('consumer_key');
        $this -> consumerSecret = $provider ->getParam('consumer_secret');
        $this -> workerObject = new OAuth($this -> consumerKey['value'], $this -> consumerSecret['value']);
        $this -> workerObject -> debug = (bool)$provider ->getParam('debug');
        $this -> tokenRequestUrl = $provider -> getParam('token_request_url');
    }

    public function  prepare(Providers_Config $providerConfig) {
        $this -> authUrl = $providerConfig -> getServer();
    }

    public function  goToProvider() {
        $_SESSION['provider'] = $_GET['provider'];
        header('Location: '.$this -> authUrl);
    }

    public function  isAuthenticated() {
        if(!isset($_GET[$this -> provider -> getParam('token_param_name')]) && !$_SESSION['state']) {
            $_SESSION['state']=1;
            return false;
        } elseif ($_SESSION['state'] == 1) {
            $params = $this->provider -> getParam('access_token_request_params');
            $paramsArray = explode(',', $params);
            $paramsStrArray = array();
            foreach ($paramsArray as $p) {
                $p = trim($p);
                $param = $this -> provider -> getParam($p);
                if (strpos($param['value'], ':get') === false) {
                    //TODO
                } else {
                    $paramValue = substr($param['value'], 5);
                    $param['value'] = $_GET[$paramValue];
                }
                $paramsStrArray[] = $param['alias']."=".$param['value'];
            }
            $tokenRequestUtl = $this -> provider -> getParam('token_request_url')."?".implode('&', $paramsStrArray);
            $response = @file_get_contents($tokenRequestUtl);
            $params = null;
            parse_str($response, $params);
            $this -> access_token = $params['access_token'];
            if ($response) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function  validate() {
        ;
    }

    public function  getAttributes() {
        $url = trim($this -> provider -> getParam('user_info_url'), "/");
        $tokenParam = $this -> provider -> getParam('user_token_alias');
        $tokenParamStr = $tokenParam['alias']."=".$this -> access_token;
        $url .= "/?".$tokenParamStr;
        $user = json_decode(file_get_contents($url));
        return $user;
    }

}
?>
