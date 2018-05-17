define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/action/place-order',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Checkout/js/checkout-data',
        'mage/url',
    ],
    function ($,Component,placeOrderAction,quote,customer,selectPaymentMethodAction,checkoutData,url) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Safaricom_Mpesa/payment/mpesac2b',
                redirectAfterPlaceOrder: true
            },
            getCustomerPhone:function(){
                return window.checkoutConfig.isCustomerLoggedIn===false?quote.billingAddress().telephone:quote.billingAddress().telephone;
            },
            validatePayment: function () {
                $('.return-message-paybill').html('');
                var self = this;
                var totals = quote.getTotals()();
                $.ajax({
                    url:url.build(window.checkoutConfig.payment.mpesac2b.paybillValidate),
                    data: {phone:$('#safaricom_phone').val(), orderTotal: (totals ? totals : quote)['grand_total'] },
                    type:"POST",
                    beforeSend: function(){
                        $('.paybill-preload').show();
                        $('#safaricom_phone').attr('disabled','disabled');
                    },
                    success:function(msg){
                        console.log(msg);
                        var obj = JSON.parse(msg);
                        $('.paybill-preload').show();

                        switch(obj.success)
                        {

                            case true:
                                $('.return-message-paybill').removeClass('pay_false').addClass('pay_true').html(obj.message);

                                var myVar;
                                myVar = setInterval(function(){
                                    $.ajax({
                                        url: url.build(window.checkoutConfig.payment.mpesac2b.paybillWait),
                                        data: { m_id: obj.m_id, c_id:obj.c_id },
                                        type: "POST",
                                        success:function(msg){
                                            var objn = JSON.parse(msg);
                                            console.log(msg);

                                            $('.return-message-paybill').removeClass('pay_false').addClass('pay_true').html(objn.message);
                                            if(objn.success == true)
                                            {
                                                if(objn.code == 'O'){
                                                    return self.placeOrder();
                                                }
                                                else {
                                                    $('#safaricom_phone').removeAttr('disabled');
                                                    $('.paybill-preload').hide();
                                                }
                                                clearInterval(myVar);
                                            }


                                        }
                                    });
                                }, 3000);



                                break;

                            case false:
                                $('.return-message-paybill').removeClass('pay_true').addClass('pay_'+obj.success).html(obj.message);
                                $('#safaricom_phone').removeAttr('disabled');
                                $('.paybill-preload').hide();
                                return false;
                                break;

                            default:
                                $('.return-message-paybill').removeClass('pay_true').addClass('pay_false').html('An error ocurred');
                                $('#safaricom_phone').removeAttr('disabled');
                                $('.paybill-preload').hide();
                                return false;
                        }


                    }
                    //,error: function (jqXHR, exception) {
                    //  console.log(jqXHR);
                    //}
                    ,
                    complete: function() {
                       // $('.paybill-preload').hide();
                    }
                });

                return false;
            },

             PolCallback:function(m_id,c_id,self)
            {
                var myVar;
                myVar = setInterval(function(){
                    $.ajax({
                        url: url.build(window.checkoutConfig.payment.mpesac2b.paybillWait),
                        data: { m_id: m_id, c_id:c_id },
                        type: "POST",
                        success:function(msg){
                            var obj = JSON.parse(msg);

                            $('.return-message-paybill').removeClass('pay_false').addClass('pay_true').html(obj.message);
                            if(obj.success == true)
                            {
                                if(obj.code == 'O'){
                                    return self.placeOrder();
                                }
                                clearInterval(myVar);
                            }

                        }
                    });
                }, 3000);
            },

            getPaybillLimit:function (){
                var totals = quote.getTotals()();
                var dt = (totals ? totals : quote)['grand_total']
                var mpl = window.checkoutConfig.payment.mpesac2b.mpesaLimit;
                if(dt>mpl)
                {
                    return false;
                }
                return true;
            },

            getNotPaybillLimit:function (){
                var totals = quote.getTotals()();
                var dt = (totals ? totals : quote)['grand_total']
                var mpl = window.checkoutConfig.payment.mpesac2b.mpesaLimit;
                if(dt>mpl)
                {
                    return true;
                }
                return false;
            },

            getPaybillNo:function (){
                return window.checkoutConfig.payment.mpesac2b.paybillNo;
            },

            getPayaccountNo:function (){
                return window.checkoutConfig.payment.mpesac2b.payReference;
            },

            getOrderTotal: function() {
                var totals = quote.getTotals()();
                return (totals ? totals : quote)['grand_total'];
            },

            afterPlaceOrder: function (data, event) {
                $.mage.redirect(url.build(window.checkoutConfig.payment.mpesac2b.paybillComplete));
            }
        });
    }
);
