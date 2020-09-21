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

class TebPaymentGateway extends WC_Payment_Gateway
{
    // this attribute is changeable from user settings.
    public $description = "Payment Gateway for TEB Kosovo.";

    // TEB Configuration attributes
    private $clientId;
    private $storeKey;
    private $companyName;
    private $paymentSubmitUrl;
    private $successNotifyUrl;
    private $failureNotifyUrl;
    private $currency;

    // UI stuff attributes.
    private $paymentThankYouMessage;
    private $paymentFailureMessage;
    private $paymentSuccessMessage;

    // security stuff
    private $callbackKnownIps;

    private $tebUtility;

    public function __construct()
    {
        $this->tebUtility = TebUtility::instance();

        $this->id = TEB_KOSOVO_GATEWAY_ID;
        $this->method_title = 'TEB Payment Gateway for WooCommerce';

        $this->title = $this->extractOption('title');
        if(empty($this->title)){
            $this->title = "Teb Kosovo";
        }
        $this->description = $this->extractOption('description');
        $this->storeKey = $this->extractOption('store_key');
        $this->clientId = $this->extractOption('client_id');
        $this->paymentSubmitUrl = $this->extractOption('payment_submit_url');

        $this->companyName = $this->extractOption('company_name');
        $this->paymentThankYouMessage = __($this->extractOption('payment_thank_you_message'), 'wc_tbks');
        $this->paymentFailureMessage = __($this->extractOption('payment_failure_message'), 'wc_tbks');
        $this->paymentSuccessMessage =__($this->extractOption('payment_success_message'), 'wc_tbks');
        $this->callbackKnownIps = $this->extractOption('callback_known_ips');
        $this->currency = $this->extractOption('currency');
        $this->successNotifyUrl = home_url('/wc-api/wc_gateway_TebPaymentGateway');
        $this->failureNotifyUrl = home_url('/wc-api/wc_gateway_TebPaymentGateway');

        //register form fields for settings page
        $tebPaymentFields = TebPaymentGatewayFields::instance();
        $tebPaymentFields->prepareFields($this);

        //register action to handle payments
        add_action('woocommerce_receipt_'.TEB_KOSOVO_GATEWAY_ID, array($this, 'handlePayment'));

        //register action to store wp settings
        if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        } else {
            add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
        }

        add_action('woocommerce_api_'.TEB_KOSOVO_GATEWAY_ID, array($this, 'handleResponseCallback'));
    }

    private function extractOption($optionName) {
        $value = $this->get_option($optionName);
        return $value;
    }

    public function registerFormField($fieldName, array $fieldAttributes)
    {
        if(!is_array($this->form_fields) || count($this->form_fields) == 0){
            $this->form_fields = [];
        }

        $this->form_fields[$fieldName] = $fieldAttributes;
    }

    /*
    * @param $orderId this is invoked from WooCommerce
    */
    public function handlePayment($orderId){
        try{
            $order = new WC_Order($orderId);

            $customer = $order->get_billing_email();
            if (empty($customer)) {
                $customer = "Web Customer";
            }

            $refreshTime = intval($this->extractOption('refresh_time'));
            if($refreshTime <= 0){
                $refreshTime = 5;
            }

            $paymentDetails = new PaymentDetails(
                $order, $this->clientId, $this->currency, $this->companyName,
                $this->description, $customer, $this->successNotifyUrl,
                $this->failureNotifyUrl, home_url(), $this->storeKey, '', $refreshTime
            );
            $paymentHandler = new TebPaymentHandler($paymentDetails, $this->paymentThankYouMessage);
            $paymentHandler->showPaymentView();
        }catch (Exception $e){
            // non complaint exp
        }
    }

    // for payment hanling
    public function process_payment($order_id)
    {
        try{
            $order = new WC_Order($order_id);
            return ['result' => 'success', 'redirect' => $order->get_checkout_payment_url(true)];
        }catch (Exception $e){
            return ['result' => false, 'redirect'=>false];
        }
    }

    public function handleResponseCallback(){

    }
}