define([
    'jquery',
    'mageUtils',
    'Matozan_Shipping/js/model/offline-rates-validation-rules',
    'mage/translate'
], function ($, utils, validationRules, $t) {
    'use strict';

    return {
        validationErrors: [],

        validate: function (address) {
            let self = this;

            $.each(validationRules.getRules(), function (field, rule) {
                if (rule.required && utils.isEmpty(address[field])) {
                    let message = $t('Field ') + field + $t(' is required.');
                    self.validationErrors.push(message);
                }
            });

            return !this.validationErrors.length;
        }
    };
});
