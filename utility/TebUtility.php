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

    public static function init(){
        if(TebUtility::$tebUtilityInstance == null){
            TebUtility::$tebUtilityInstance = new TebUtility();
        }
        return TebUtility::$tebUtilityInstance;
    }

    private function __construct()
    {
        if(defined("TEB_KOSOVO_ENCRYPT_KEY")){
            $this->ENCRYPTION_KEY = TEB_KOSOVO_ENCRYPT_KEY;
        }
    }

    public function encrypt($data)
    {
        $key = $this->ENCRYPTION_KEY;
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public function decrypt($data)
    {
        $key = $this->ENCRYPTION_KEY;
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
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