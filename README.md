The Safaricom Mpesa Express module gives your store an ability to receive payments via M-pesa STK push.

Features

1. Adds  M-pesa as a payment method during customer checkout 
2. Give you an ability to configure your M-pesa credentials on `[Stores -> Configuration -> Sales -> Payments]`
3. View live payment feeds on `[Reports -> Sales -> Safaricom Mpesa]`


Setup Step:

1. Copy Safaricom/Mpesa folder inside app/code (Important: Be sure to create the `Safaricom` folder under app/code, the copy the `Mpesa` folder inside it)
2. Run following command `php bin/magento setup:upgrade && php bin/magento setup:static-content:deploy`
