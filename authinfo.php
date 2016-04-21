<?php

namespace OCA\SingleSignOn;

/**
 * Class AuthInfo
 * @author Dauba
 */
class AuthInfo implements IAuthInfo
{
    /**
     * requeir keys for auth info
     *
     * @var array
     */
    //private static $requireKeys = array("key","userid");
    private static $requireKeys = array("token1");

    /**
     * auth info
     *
     * @var array
     */
    private static $info = array();

    /**
     * set auth info
     *
     * @return void
     */
    public static function init()
    {
        $request = \OC::$server->getRequest();
        $session = \OC::$server->getSession();
        foreach (self::$requireKeys as $key) {
            if($request->offsetGet($key)) {
                self::$info[$key] = $request->offsetGet($key);
            }
            else if($request->getHeader($key)) {
                self::$info[$key] = $request->getHeader($key);
            }
            else if($session->get("sso_" . $key)) {
                self::$info[$key] = $session->get("sso_" . $key);
            }
        }
        self::$info["userIp"] = $request->getRemoteAddress();
    }

    /**
     * Getter for Info
     *
     * @return array
     */
    public static function get()
    {
        foreach (self::$requireKeys as $key) {
            if(!array_key_exists($key, self::$info)) {
                return null;
            }
        }
        return self::$info;
    }
    
}
