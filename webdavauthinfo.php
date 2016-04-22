<?php

namespace OCA\SingleSignOn;

/**
 * Class WebDavAuthInfo
 * @author Dauba
 */
class WebDavAuthInfo implements IWebDavAuthInfo
{
    
    /**
     * auth info
     *
     * @var array
     */
    private static $info = array();

    /**
     * undocumented function
     *
     * @return void
     */
    public static function init($userID, $password)
    {
        $request = \OC::$server->getRequest();

        self::$info["userIp"] = $request->getRemoteAddress();
        self::$info["token1"] = RequestManager::send(ISingleSignOnRequest::GETTOKEN, array("userId" => $userID, "password" => $password, "userIp" => self::$info["userIp"]));
    }
    
    /**
     * Getter for Info
     *
     * @return array
     */
    public static function get()
    {
        foreach (AuthInfo::$requireKeys as $key) {
            if(!array_key_exists($key, self::$info)) {
                return null;
            }
        }
        return self::$info;
    }
    
}
