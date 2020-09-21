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

class PaymentDetails
{
    private $order;
    private $clientId;
    private $currency;
    private $companyName;
    private $description;
    private $customerIdentifier;
    private $successCallback;
    private $failCallback;
    private $shopUrl;
    private $storeKey;
    private $installment;
    private $refreshTime;

    public function __construct(WC_Order $order, $clientId, $currency, $companyName,
                                $description, $customerIdentifier, $successCallback,
                                $failCallback, $shopUrl, $storeKey, $installment, $refreshTime)
    {
        $this->clientId = $clientId;
        $this->order = $order;
        $this->currency = $currency;
        $this->companyName = $companyName;
        $this->description = $description;
        $this->customerIdentifier = $customerIdentifier;
        $this->successCallback = $successCallback;
        $this->failCallback = $failCallback;
        $this->shopUrl = $shopUrl;
        $this->storeKey = $storeKey;
        $this->installment = $installment;
        $this->refreshTime = $refreshTime;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCustomerIdentifier()
    {
        return $this->customerIdentifier;
    }

    public function getSuccessCallback()
    {
        return $this->successCallback;
    }

    public function getFailCallback()
    {
        return $this->failCallback;
    }

    public function getShopUrl()
    {
        return $this->shopUrl;
    }

    public function getStoreKey()
    {
        return $this->storeKey;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getInstallment()
    {
        return $this->installment;
    }

    public function getRefreshTime()
    {
        return $this->refreshTime;
    }

}