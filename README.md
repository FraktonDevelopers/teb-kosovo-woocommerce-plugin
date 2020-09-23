# TEB Kosovo WooCommerce Plugin

This is a plugin for the WooCommerce Wordpress CMS that helps users to integrate their payment provider. This repository
contains the source code and in order to be used as WordPress Plugin it should be first uploaded as zip to the Plugins 
page of WordPress or uploaded directly via FTP.

The settings of this plugin will appear under WooCommerce->Settings->Payments->{Choose the Teb Provider}

## Settings

Please make sure that you use the right settings provided for your Merchant Account in order to make the plugin work 
properly.

Below is a description of each setting:

#### General
<code>Title</code> - This will appear in your payment provider list in frontend.<br>
<code>Company Name</code> - The name of the company that will appear to the customers.<br>
<code>Description</code> - A short description that will appear on front end.

#### TEB Credentials & Settings
<code>ClientID</code> - Represents the id of your merchant Account.<br>
<code>Store Key</code> - Represents the store key provided from your Bank.<br>
<code>Run Mode</code> - Determines the environment. TestMode will not charge the clients and a test credit card
should be used. Live Mode is when you have your e-shop running in production mode and the clients will be charged for real.<br>
<code>Currency</code> - Possible values are € and $. These two determine the currency you merchant is set up.<br>
<code>Refresh time</code> - The time in seconds the TEB Payment Notification will appear after a payment is finished.<br>

#### Security 
This part of settings is highly recommended and please always use this setting.

<code>Whitelisted IP's</code> - This contains the list of IP's that are allowed to send callback requests to your shop. Each
callback determines if the payment transaction went successfully or not. So, this need to be protected by allowing only the IP's provided
from the Bank Provider in order to make sure that no one else can perform this action. In case no IP is whitelisted the callbacks
won't work.

#### Responses

<code>Payment Redirect Message</code> - A short message that will be shown during form submission. Example: You will be redirected to Checkout Page of the Bank.<br>
<code>Payment Fail Message</code> - A short message that will be shown when the payment fails.<br>
<code>Payment Success Message</code> - A short message that will be shown when the payment is successfully finished.

