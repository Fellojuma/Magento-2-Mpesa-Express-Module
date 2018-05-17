define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'mpesac2b',
                component: 'Safaricom_Mpesa/js/view/payment/method-renderer/mpesac2b'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);