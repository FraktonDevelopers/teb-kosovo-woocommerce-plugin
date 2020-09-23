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

class TebPaymentResponseHandler
{
    private $postData;
    private $allowedIpsAsString;
    private $paymentSuccessMessage;
    private $paymentFailureMessage;

    public function __construct($postData, $allowedIpsAsString,$paymentSuccessMessage, $paymentFailureMessage)
    {
        $this->postData = $postData;
        $this->allowedIpsAsString = $allowedIpsAsString;
        $this->paymentSuccessMessage = $paymentSuccessMessage;
        $this->paymentFailureMessage = $paymentFailureMessage;
    }

    public function handle(){
        //woo commerce response
        $response = [];
        $response['class'] = 'error';
        $response['message'] = $this->paymentFailureMessage;
        $response['orderId'] = null;
        $response['orderCartHash'] = null;

        if(!isset($this->postData['order'])){
            return $response;
        }

        $allowedIps = [];
        if(strlen(trim($this->allowedIpsAsString)) > 0){
            $allowedIps = explode(",", trim($this->allowedIpsAsString));
        }

        if(!$this->isUserIpAllowed($allowedIps)){
            return $response;
        }

        try {
            $order = new WC_Order($this->postData['order']);

            $transactionId = isset($this->postData['TransId']) ? $this->postData['TransId'] : 'no-trans-id';
            if ($order->status != 'processing') {
                $order->payment_complete();
                $order->add_order_note(__('SYSTEM: Teb payment successful. Transaction: ', 'wc_tbks') . $transactionId . '<br/>');
            }
            $response['class'] = 'success';
            $response['message'] = $this->paymentSuccessMessage;
            $response['orderId'] = $this->postData['order'];
            $response['orderCartHash'] = $order->get_cart_hash();
            return $response;
        } catch (Exception $e) {
            return $response;
        }
    }

    private function isUserIpAllowed($allowedIps=[]){
        return count($allowedIps) != 0 &&
            (
                in_array($_SERVER['HTTP_REFERER'], $allowedIps) ||
                in_array($_SERVER['REMOTE_ADDR'], $allowedIps)
            );
    }
}