if(typeof $ === 'undefined'){
    $ = jQuery;
}
$.blockUI({
    message: "' . esc_js(__($this->paymentThankYouMessage, 'woocommerce')) . '",
    baseZ: 99999,
    overlayCSS:
        {
            background: "#fff",
            opacity: 0.6
        },
    css: {
        padding:        "20px",
        zindex:         "9999999",
        textAlign:      "center",
        color:          "#555",
        border:         "3px solid #aaa",
        backgroundColor:"#fff",
        cursor:         "wait",
        lineHeight:     "24px",
    }
});
$("#submit_{THE_ID_OF_PAYMENT_GATEWAY}").submit();