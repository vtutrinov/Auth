<?php
/**
 * ProviderManager
 *
 * @author Slava Tutrinov
 */
class Providers_Manager {

    protected static $providerCollection;

    /**
     * @param string $providerId
     * @return ProviderConfig
     */
    public static function getConfig($providerId) {
        $xmlConfig = new DOMDocument();
        $xmlConfig -> load(dirname(__FILE__).'/config/'.$providerId.'.xml');
        $server = $xmlConfig ->getElementsByTagName('server');
        $ico = $xmlConfig->getElementsByTagName('icon');
        $configObject = new Providers_Config();
        $providerUrl = self::getProviderUrl($xmlConfig);
        $configObject->setServer($providerUrl);
        $configObject->setUserNameRequired($xmlConfig);
        $configObject->setRedirectUrl('ulmart.pr:3356/openid.php');
        $configObject->setIconSrc("/auth/img/".$ico->item(0)->getAttribute('src'));
        $configObject->setServiceName($server->item(0)->getAttribute('name'));
        $configObject->setProtocol($server->item(0)->getAttribute('type'));
        $configObject->setParams($xmlConfig -> getElementsByTagName('params'));
        return $configObject;
    }

    public static function initProvidersCollection(array $list) {
        $providerList = new Providers_List();
        foreach ($list as $pName) {
            $config  =self::getConfig($pName);
            $providerList -> offsetSet($pName, $config);
        }
        self::$providerCollection = $providerList;
    }

    public static function getProvidersCollection() {
        return self::$providerCollection;
    }

    private static function getProviderUrl($domXML) {
        $template = $domXML -> getElementsByTagName('url_template');
        $serverNode = $domXML -> getElementsByTagName('server');
        $url = trim($serverNode->item(0)->getAttribute('value'), '/');
        $templateStr = $template -> item(0) -> getAttribute('value');
        $url = str_replace('{server}', $url, $templateStr);
        $userNodes = $domXML -> getElementsByTagName('username');
        $userNameRequired = (int)$userNodes->item(0)->getAttribute('required');
        if ($userNameRequired) {
            $defaultUserName = $userNodes -> item(0) -> getAttribute('default');
            if (isset($_GET['username'])) {
                $defaultUserName = $_GET['username'];
            }
            $url = str_replace('{username}', $defaultUserName ,$url);
        }
        $requestParams = $domXML -> getElementsByTagName('request_param');
        $paramsCount = $requestParams -> length;
        $paramsArray = array();
        for ($i = 0; $i < $paramsCount; $i++) {
            $curParam = $requestParams -> item($i);
            $paramName = $curParam -> getAttribute('name');
            $paramValue = $curParam -> getAttribute('value');
            $paramsArray[] = $paramName."=".$paramValue;
        }
        $paramsStr = implode('&', $paramsArray);
        if (strlen($paramsStr) > 0) {
            $url .= '/?'.$paramsStr;
        }
        return $url;
    }

}
?>
