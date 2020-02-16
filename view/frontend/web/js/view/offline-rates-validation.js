define([
    'uiComponent',
    'Magento_Checkout/js/model/shipping-rates-validator',
    'Magento_Checkout/js/model/shipping-rates-validation-rules',
    'Matozan_Shipping/js/model/offline-rates-validation',
    'Matozan_Shipping/js/model/offline-rates-validation-rules'
], function (
    Component,
    defaultShippingRatesValidator,
    defaultShippingRatesValidationRules,
    shippingRatesValidator,
    shippingRatesValidationRules
) {
    'use strict';

    defaultShippingRatesValidator.registerValidator('custom_offline', shippingRatesValidator);
    defaultShippingRatesValidationRules.registerRules('custom_offline', shippingRatesValidationRules);

    return Component;
});
