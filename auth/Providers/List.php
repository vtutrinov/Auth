<?php
/**
 * ProvidersList
 *
 * @author Slava Tutrinov
 */
class Providers_List implements ArrayAccess, Countable, Iterator {

    protected $_instances = array();

    public function __construct($array=null) {
            if (!is_null($array) && is_array($array)) {
                    $this -> _instances = $array;
            }
    }

    public function getProviderByName($name=null) {
            if(!is_null($name)) {
                    if (array_key_exists($name, $this -> _instances)) {
                            return $this -> _instances[$name];
                    } else {
                            throw new CException("Requested instance of OpenId provider doesn't initialized!");
                    }
            } else {
                    throw new CException("name of the requested instance of OpenId provider can't be null!");
            }
    }

    /**
     * Implementation of the Countable interface
     * @see Countable::count()
     * @return int
     */
    public function count() {
            return count($this -> _instances);
    }

    /**
     * Implementation of the ArrayAccess interface
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) {
            return isset($this -> _instances[$offset]);
    }

    /**
     *
     * Implementation of the ArrayAccess interface
     * @param mixed $offset
     * @return ProviderConfig|null
     */
    public function offsetGet($offset) {
            return $this -> offsetExists($offset)?$this -> _instances[$offset]:null;
    }

    /**
     *
     * Implementation of the ArrayAccess interface.
     * @param string|mixed $offset
     * @param ProviderConfig $value
     * @return void
     */
    public function offsetSet($offset, $value) {
            if (is_null($offset)) {
                    $this -> _instances[] = $value;
            } else {
                    $this -> _instances[$offset] = $value;
            }
    }

    /**
     * Implementation of the ArrayAccess interface
     * @param string|mixed $offset
     * @return void
     */
    public function offsetUnset($offset) {
            unset($this -> _instances[$offset]);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::current()
     */
    public function current() {
            return current($this -> _instances);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::key()
     */
    public function key() {
            return key($this -> _instances);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::next()
     */
    public function next() {
            return next($this -> _instances);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind() {
            reset($this -> _instances);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid() {
            $currentKey = key($this -> _instances);
            $isValid = (!is_null($currentKey) && (bool)$currentKey);
            return $isValid;
    }

}
?>
