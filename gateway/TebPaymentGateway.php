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

    // UI stuff attributes.
    private $paymentThankYouMessage;
    private $paymentFailureMessage;
    private $paymentSuccessMessage;

    // security stuff
    private $callbackKnownIps;

    private $tebUtility;
    private $optionPrefix = 'tbks_';

    public function __construct()
    {
        $this->tebUtility = TebUtility::instance();

        $this->id = 'teb_kosovo_gtw';
        $this->method_title = 'TEB Payment Gateway for WooCommerce';

        $this->title = $this->extractOption('title');
        if(empty($this->title)){
            $this->title = "Teb Kosovo";
        }
        $this->description = $this->extractOption('description');
        $this->storeKey = $this->extractOption('store_key', true);
        $this->clientId = $this->extractOption('client_id', true);
        $this->paymentSubmitUrl = $this->extractOption('payment_submit_url');

        $this->companyName = $this->extractOption('company_name');
        $this->paymentThankYouMessage = __($this->extractOption('payment_thank_you_message'), 'wc_tbks');
        $this->paymentFailureMessage = __($this->extractOption('payment_failure_message'), 'wc_tbks');
        $this->paymentSuccessMessage =__($this->extractOption('payment_success_message'), 'wc_tbks');
        $this->callbackKnownIps = $this->extractOption('callback_known_ips');

        //register form fields for settings page
        $tebPaymentFields = TebPaymentGatewayFields::instance();
        $tebPaymentFields->prepareFields($this);
    }

    private function extractOption($optionName, $decrypt=false) {
        $value = $this->get_option($optionName);

        if($decrypt && !empty($value)){
            $value = $this->tebUtility->decrypt($value);
        }

        return $value;
    }

    public function registerFormField($fieldName, array $fieldAttributes)
    {
        if(!is_array($this->form_fields) || count($this->form_fields) == 0){
            $this->form_fields = [];
        }

        $this->form_fields[$fieldName] = $fieldAttributes;
    }
}