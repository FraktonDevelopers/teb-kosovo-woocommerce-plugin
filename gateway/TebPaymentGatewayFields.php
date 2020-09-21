<?php
// stop loading this class if the ABSPATH is not defined.
if (!defined('ABSPATH')){
    exit;
}
// stop loading this class if WC_Payment_Gateway doesn't exist.
if(!class_exists('WC_Payment_Gateway')){
    exit;
}
// stop loading this class if TebPaymentGateway doesn't exist.
if(!class_exists('TebPaymentGateway')){
    exit;
}
// stop loading this class if TEB_PAYMENT_PROVIDER_LOADED is not defined.
if(!defined('TEB_PAYMENT_PROVIDER_LOADED')){
    exit;
}

class TebPaymentGatewayFields
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function instance(){
        if(TebPaymentGatewayFields::$instance == null){
            TebPaymentGatewayFields::$instance = new TebPaymentGatewayFields();
        }

        return TebPaymentGatewayFields::$instance;
    }

    public function prepareFields(TebPaymentGateway $paymentGateway){
        $fields = [
            'enabled' => [
                'title' => __('Enable/Disable', 'wc_tbks'),
                'type' => 'checkbox',
                'label' => __('Enable Teb Payment Gateway', 'wc_tbks'),
                'default' => 'yes'
            ],
            'title' => [
                'title' => __('Title', 'wc_tbks'),
                'type' => 'text',
                'description' => __('Payment method title which the customer will see during checkout', 'wc_tbks'),
                'default' => __('Teb Bank.', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'company_name' => [
                'title' => __('Company Name', 'wc_tbks'),
                'type' => 'text',
                'description' => __('The name of the company that will reflect on your transactions. Example: Your store name.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'description' => [
                'title' => __('Description', 'wc_tbks'),
                'type' => 'textarea',
                'description' => __('Payment method description which the customer will see during checkout', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'client_id' => [
                'title' => __('Client ID', 'wc_tbks'),
                'type' => 'text',
                'description' => __('Client ID provided by the bank.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'store_key' => [
                'title' => __('Store Key', 'wc_tbks'),
                'type' => 'text',
                'description' => __('Store Key provided by the bank.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'payment_submit_url' => [
                'title' => __('Payment Submit Url', 'wc_tbks'),
                'type' => 'text',
                'description' => __('The URL of TEB Service that will handle the request.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'payment_thank_you_message' => [
                'title' => __('Payment Thank You Message', 'wc_tbks'),
                'type' => 'text',
                'description' => __('A short message that will be shown during form submission. Example: You will be redirected to Checkout Page of the Bank.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'payment_fail_message' => [
                'title' => __('Payment Fail Message', 'wc_tbks'),
                'type' => 'text',
                'description' => __('A short message that will be shown when the payment fails.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'payment_success_message' => [
                'title' => __('Payment Success Message', 'wc_tbks'),
                'type' => 'text',
                'description' => __('A short message that will be shown when the payment is successful finished.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
            'callback_known_ips' => [
                'title' => __('The list of IP\' that are allowed to call the callback urls.', 'wc_tbks'),
                'type' => 'text',
                'description' => __('Highly recommended. Get the IP list from your payment provider. Separate with , each ip.', 'wc_tbks'),
                'default' => __('', 'wc_tbks'),
                'desc_tip' => true,
            ],
        ];

        foreach ($fields as $fieldName=>$fieldAttributes) {
            $paymentGateway->registerFormField($fieldName, $fieldAttributes);
        }
    }
}