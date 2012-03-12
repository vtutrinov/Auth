<?php
/**
 * Loader
 *
 * @author Slava Tutrinov
 */
class Loader {

    public static function load($className) {
        $path = dirname(__FILE__).'/'.str_replace('_', '/', $className).'.php';

        if (!file_exists($path))
        {
          return false;
        }
        require_once $path;
    }

}
?>
