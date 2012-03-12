<?php
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
    require_once 'auth/Loader.php';
    spl_autoload_register(array('Loader', 'autoload'));
    Providers_Manager::initProvidersCollection(array('vk', 'twitter', 'facebook','yandex','google', 'mail'));
    $itemCollection = Providers_Manager::getProvidersCollection();
    ?>
    <div id="auth">
        <?php
        foreach ($itemCollection as $key => $item) {
//            var_dump($item);
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
                //данные от OpenID провайдеров
                var_dump($auth->getAttributes());
            }
        } elseif (isset($_SESSION['provider'])) {
            $provider = Providers_Manager::getConfig($_SESSION['provider']);
            $auth = Auth::getAuthGateway($provider);
            $auth -> prepare($provider);
            if ($auth -> isAuthenticated()) {
                //данные от OAuth провайдеров (Facebook, Twitter)
                var_dump($auth -> getAttributes());
            }
        }
    } catch (ErrorException $e) {
        echo "<span style='color:#f00;'>".$e->getMessage()."</span>";
    }
    ?>
    </body>
</html>