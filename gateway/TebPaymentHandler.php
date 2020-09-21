<?php
// stop loading this class if the ABSPATH is not defined.
if (!defined('ABSPATH')) {
    exit;
}
// stop loading this class if WC_Payment_Gateway doesn't exist.
if (!class_exists('WC_Payment_Gateway')) {
    exit;
}
// stop loading this class if TebPaymentGateway doesn't exist.
if (!class_exists('TebPaymentGateway')) {
    exit;
}
// stop loading this class if TEB_PAYMENT_PROVIDER_LOADED is not defined.
if (!defined('TEB_PAYMENT_PROVIDER_LOADED')) {
    exit;
}

class TebPaymentHandler
{
    private $lang = 'sq';
    private $hashAlgorythm = 'ver3';
    private $storeType = '3D_PAY_HOSTING';
    private $paymentDetails = null;
    private $tranType = 'Auth';
    private $amount = 0;
    private $randomString;
    private $paymentFormSubmissionMessage;

    public function __construct(PaymentDetails $paymentDetails, $paymentFormSubmissionMessage)
    {
        $this->paymentDetails = $paymentDetails;

        $this->amount = str_replace(',', '.', $this->paymentDetails->getOrder()->get_total());

        $utility = TebUtility::instance();
        $this->randomString = $utility->generateRandomString(20);
        $this->paymentFormSubmissionMessage = $paymentFormSubmissionMessage;
    }

    public function showPaymentView()
    {
        $data = $this->prepareFormData();
        $viewDirPath = str_replace(DIRECTORY_SEPARATOR
            . 'gateway', '', plugin_dir_path(__DIR__)) . DIRECTORY_SEPARATOR .'views'.DIRECTORY_SEPARATOR;

        $jsPart = file_get_contents($viewDirPath.'submit-js.js');
        $jsPart = str_replace('{THE_ID_OF_PAYMENT_GATEWAY}', TEB_KOSOVO_GATEWAY_ID, $jsPart);
        $jsPart = str_replace('{THE_MESSAGE}', esc_js(__($this->paymentFormSubmissionMessage, TEB_KOSOVO_GATEWAY_ID)), $jsPart);

        wc_enqueue_js($jsPart);
        include $viewDirPath.'submit-form.php';
    }

    private function prepareFormData()
    {
        return (object)[
            'clientId' => $this->paymentDetails->getClientId(),
            'amount' => $this->amount,
            'billToCompany' => $this->paymentDetails->getCompanyName(),
            'billToName' => $this->paymentDetails->getCustomerIdentifier(),
            'callbackUrl' => $this->paymentDetails->getSuccessCallback(),
            'currencyId' => $this->paymentDetails->getCurrency(),
            'failUrl' => $this->paymentDetails->getFailCallback(),
            'hashAlgorithm' => $this->hashAlgorythm,
            'instalment' => $this->paymentDetails->getInstallment(),
            'lang' => $this->lang,
            'okUrl' => $this->paymentDetails->getSuccessCallback(),
            'orderId' => $this->paymentDetails->getOrder()->get_id(),
            'refreshTime' => $this->paymentDetails->getRefreshTime(),
            'rnd' => $this->randomString,
            'storeType' => $this->storeType,
            'tranType' => $this->tranType,
            'hash' => $this->generateHash(),
            'shopUrl' => $this->paymentDetails->getShopUrl()
        ];
    }

    private function generateHash()
    {
        $appendData = [
            $this->amount, $this->paymentDetails->getCompanyName(), $this->paymentDetails->getCustomerIdentifier(),
            $this->paymentDetails->getSuccessCallback(), $this->paymentDetails->getClientId(), $this->paymentDetails->getCurrency(),
            $this->paymentDetails->getFailCallback(), $this->hashAlgorythm, $this->paymentDetails->getInstallment(),
            $this->lang, $this->paymentDetails->getSuccessCallback(), $this->paymentDetails->getOrder()->get_id(),
            $this->paymentDetails->getRefreshTime(), $this->randomString, $this->paymentDetails->getShopUrl(), $this->storeType,
            $this->tranType, $this->paymentDetails->getStoreKey()
        ];

        $plaintext = implode('|', $appendData);
        $hash = base64_encode(pack('H*', hash('sha512', $plaintext)));
        return $hash;
    }
}