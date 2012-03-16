<?php
/**
 *
 * @author Slava Tutrinov
 */
interface Interface_AuthGateway {

    public function prepare(Providers_Config $providerConfig);
    public function goToProvider();
    public function isAuthenticated();
    public function validate();
    public function getAttributes();

}
?>
