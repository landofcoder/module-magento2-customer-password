/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_CustomerPassword
 * @copyright  Copyright (c) 2022 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
define(
    [
    'uiRegistry',
    'Magento_Ui/js/form/element/abstract'
    ],
    function (registry, Abstract) {
        'use strict';

        return Abstract.extend({
            defaults: {
                focused: false
            },
            initialize: function () {
                this._super();
                var self = this;

                var infoTab = registry.get('customer_form.areas.customer');
                if (infoTab.active()) {
                    self.prepareInfoTab();
                } else {
                    var infoTabActiveSubscriber = infoTab.active.subscribe(function(status) {
                        if (status) {
                            self.prepareInfoTab();
                            infoTabActiveSubscriber.dispose();
                        }
                    });
                }

                registry.get(
                    'customer_form.areas.customer.customer.email',
                    function (element) {
                        if (element.value() === '') {
                            var password_section = registry.get(self.parentName);
                            password_section.visible(false);
                        }
                    }
                );
            },
            prepareInfoTab: function () {
                var self = this;

                var admin_password = registry.get(self.parentName + '.' + 'admin_password');
                admin_password.hide();
                self.focused.subscribe(function (value) {
                    if (value) {
                        admin_password.show();
                    } else if (!self.value().length) {
                        admin_password.hide();
                    }
                });
            }
        });
    }
);
