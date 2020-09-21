<?php
// stop loading this class if the ABSPATH is not defined.
if (!defined('ABSPATH')){
    exit;
}
// stop loading this class if WC_Payment_Gateway doesn't exist.
if(!class_exists('WC_Payment_Gateway')){
    exit;
}
// stop loading this class if TEB_PAYMENT_PROVIDER_LOADED is not defined.
if(!defined('TEB_PAYMENT_PROVIDER_LOADED')){
    exit;
}

class TebUtility
{
    private static $tebUtilityInstance = null;

    private $ENCRYPTION_KEY = "ThisKeyShouldBeChanged888";

    private function __construct()
    {
    }

    public static function instance(){
        if(TebUtility::$tebUtilityInstance == null){
            TebUtility::$tebUtilityInstance = new TebUtility();
        }
        return TebUtility::$tebUtilityInstance;
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}