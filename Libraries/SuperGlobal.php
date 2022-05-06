<?php

namespace App\Libraries;

class SuperGlobal
{
    private $_SERVER;
    private $_POST;
    private $_FILES;
    private $_GET;
    private $_SESSION;

    public function __construct()
    {
        $this->define_superglobals();
    }

    /**
     * Function to define superglobals for use locally.
     * We do not automatically unset the superglobals after
     * defining them, since they might be used by other code.
     *
     * @return mixed
     */
    private function define_superglobals()
    {

        $this->_SERVER = (isset($_SERVER)) ? $_SERVER : null;
        $this->_POST = (isset($_POST)) ? $_POST : null;
        $this->_GET = (isset($_GET)) ? $_GET : null;
        $this->_FILES = (isset($_FILES)) ? $_FILES : null;
        $this->_SESSION = (isset($_SESSION)) ? $_SESSION : null;

    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_SERVER($key = null)
    {
        if (null !== $key) {
            return (isset($this->_SERVER["$key"])) ? $this->_SERVER["$key"] : null;
        } else {
            return $this->_SERVER;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_POST($key = null)
    {
        if (null !== $key) {

            return (isset($this->_POST["$key"])) ? $this->_POST["$key"] : null;
        } else {
            return $this->_POST;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_GET($key = null)
    {
        if (null !== $key) {

            return (isset($this->_GET["$key"])) ? $this->_GET["$key"] : null;
        } else {
            return $this->_GET;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_SESSION($key = null)
    {
        if (null !== $key) {
            return (isset($this->_SESSION["$key"])) ? $this->_SESSION["$key"] : null;
        } else {
            return $this->_SESSION;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_FILE($key = null)
    {
        if (null !== $key) {

            return (isset($this->_FILES["$key"])) ? $this->_FILES["$key"] : null;
        } else {
            return $this->_FILES;
        }
    }

    /**
     * You may call this function from your compositioning root,
     * if you are sure superglobals will not be needed by
     * dependencies or outside of your own code.
     *
     * @return void
     */
    public function unset_superglobals()
    {
        unset($_SERVER);
        unset($_POST);
        unset($_GET);
        unset($_SESSION);
    }


}
