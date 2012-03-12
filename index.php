<?php
//phpinfo();exit;
session_start();
?>
<html>
    <head>
        <title>Authentication</title>
        <script type="text/javascript" src="/auth/assets/js/jquery-ui-1.8.18.custom/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/auth/assets/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="/auth/assets/js/auth.js"></script>
        <link rel="stylesheet" type="text/css" href="/auth/assets/js/jquery-ui-1.8.18.custom/css/ui-lightness/jquery-ui-1.8.18.custom.css">
    </head>
    <body>
    <?php
    var_dump($_SESSION);
    require_once 'auth/Loader.php';
    spl_autoload_register(array('Loader', 'autoload'));
    Providers_Manager::initProvidersCollection(array('vk', 'facebook','yandex','google', 'mail'));
    $itemCollection = Providers_Manager::getProvidersCollection();
    ?>
    <div id="auth">
        <?php
        foreach ($itemCollection as $key => $item) {
            $popupClass = "";
            if ($item->isUserNameRequired()) {
                $popupClass = 'class="userPopup"';
            }
            echo "<div><a href='/?provider=".$key."' ".$popupClass."><img src='".$item -> getIconSrc()."' /></a></div>";
        }
        ?>
    </div>
    <?php
    try {
        if (array_key_exists('provider', $_GET)) {
            $provider = Providers_Manager::getConfig($_GET['provider']);
            $auth = Auth::getAuthGateway($provider);
            $auth -> prepare($provider);
            if (!$auth -> isAuthenticated()) {
                $auth->goToProvider();
            } else {
                echo 'User ' . ($auth->validate() ? $auth->identity . ' has ' : 'has not ') . 'logged in.';
                var_dump($auth->getAttributes());
            }
        } elseif (isset($_SESSION['provider'])) {
            $provider = Providers_Manager::getConfig($_SESSION['provider']);
            $auth = Auth::getAuthGateway($provider);
            if ($auth -> isAuthenticated()) {
                var_dump($auth -> getAttributes());
            }
        } elseif (isset($_GET['oauth_token'])) {
            header('Location: http://api.twitter.com/oauth/authorize?oauth_token='.$_GET['oauth_token']);
        }
    } catch (ErrorException $e) {
        echo "<span style='color:#f00;'>".$e->getMessage()."</span>";
    }
    ?>
    </body>
</html>