<?php
/**
 * Auth
 *
 * @author Slava Tutrinov
 */
class Auth {

    /**
     *
     * @param string $protocolName
     * @return Interface_AuthGateway
     */
    public static function getAuthGateway(Providers_Config $provider) {
        $className = 'Authtype_'.$provider -> getProtocol();
        return new $className($provider);
    }

}
?>
