<form method="POST" action="<?php echo  '' ?>" id="submit_<?php echo TEB_KOSOVO_GATEWAY_ID ?>">
    <div class="payment_buttons">
        <input type="hidden" name="amount" value="<?php echo  $data->amount; ?>">
        <input type="hidden" name="billTocompany" value="<?php echo  $data->billToCompany; ?>">
        <input type="hidden" name="billToName" value="<?php echo  $data->billToName; ?>">
        <input type="hidden" name="callbackUrl" value="<?php echo  $data->callbackUrl; ?>">
        <input type="hidden" name="clientid" value="<?php echo  $data->clientId; ?>">
        <input type="hidden" name="currency" value="<?php echo  $data->currencyId; ?>">
        <input type="hidden" name="failUrl" value="<?php echo  $data->failUrl; ?>">
        <input type="hidden" name="hashAlgorithm" value="<?php echo  $data->hashAlgorithm; ?>">
        <input type="hidden" name="instalment" value="<?php echo  $data->instalment; ?>">
        <input type="hidden" name="lang" value="<?php echo  $data->lang; ?>">
        <input type="hidden" name="okUrl" value="<?php echo  $data->okUrl; ?>">
        <input type="hidden" name="order" value="<?php echo  $data->orderId; ?>">
        <input type="hidden" name="refreshTime" value="<?php echo  $data->refreshTime; ?>">
        <input type="hidden" name="rnd" value="<?php echo  $data->rnd; ?>">
        <input type="hidden" name="storetype" value="<?php echo  $data->storeType; ?>">
        <input type="hidden" name="TranType" value="<?php echo  $data->tranType; ?>">
        <input type="hidden" name="hash" value="<?php echo  $data->hash; ?>">
        <input type="hidden" name="encoding" value="UTF-8">
        <input type="hidden" name="shopurl" value="<?php echo  $data->shopUrl; ?>">.
    </div>
</form>