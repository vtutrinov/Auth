<?php
require 'lightopenid/openid.php';
require 'lightopenid/providers/ProviderManager.php';
require 'lightopenid/providers/ProviderConfig.php';
try {
    if (array_key_exists('provider', $_GET)) {
        $providerConfig = ProviderManager::getConfig($_GET['provider']);
        $openId = new LightOpenID($providerConfig -> getRedirectUrl());
        if (!$openId -> mode) {
            $openId -> identity = $providerConfig -> getServer();
            $openId->required = array('contact/email');
            $openId->optional = array('namePerson', 'namePerson/friendly');
            header('Location: ' . $openId->authUrl());

        } elseif($openId->mode == 'cancel') {
            echo 'User has canceled authentication!';
        } else {
            echo 'User ' . ($openId->validate() ? $openId->identity . ' has ' : 'has not ') . 'logged in.';
            print_r($openId->getAttributes());
        }
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>
<a href="/openid.php?provider=google">Login with Google!</a>