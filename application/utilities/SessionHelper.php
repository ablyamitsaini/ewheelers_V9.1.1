<?php
class SessionHelper extends FatUtility
{
    const USER_lOCATION_SESSION = 'yokartLocationSession';

    public static function getUserLocation() 
    {
        if (!empty($_SESSION[SELF::USER_lOCATION_SESSION])) {
            return $_SESSION[SELF::USER_lOCATION_SESSION];
        }
        return array();
    }
    
    public static function resetUserLocation() 
    {
        if (!empty($_SESSION[SELF::USER_lOCATION_SESSION])) {
            unset($_SESSION[SELF::USER_lOCATION_SESSION]);
        }
    }

    public static function askUserLocation() 
    {
        if (!empty($_SESSION[SELF::USER_lOCATION_SESSION])) {
            return false;
        }
        return true;
    }
}
