/*
 * 2007-2022 PayPal
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Academic Free License (AFL 3.0)
 *  that is bundled with this package in the file LICENSE.txt.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/afl-3.0.php
 *  If you did not receive a copy of the license and are unable to
 *  obtain it through the world-wide-web, please send an email
 *  to license@prestashop.com so we can send you a copy immediately.
 *
 *  DISCLAIMER
 *
 *  Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 *  versions in the future. If you wish to customize PrestaShop for your
 *  needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 2007-2022 PayPal
 *  @author 202 ecommerce <tech@202-ecommerce.com>
 *  @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *  @copyright PayPal
 */

import {Tools} from './tools.js';

const ACDC = function(conf) {
  this.button = typeof conf['button'] != 'undefined' ? conf['button'] : null;

  this.controller = typeof conf['controller'] != 'undefined' ? conf['controller'] : null;

  this.validationController = typeof conf['validationController'] != 'undefined' ? conf['validationController'] : null;

  this.messages = typeof conf['messages'] != "undefined" ? conf['messages'] : [];
};

ACDC.prototype.initButton = function() {
  totPaypalAcdcSdk.Buttons({

    createOrder: function(data, actions) {
      return this.getIdOrder();
    }.bind(this),

    onApprove: function(data, actions) {
      this.sendData(data);
    }.bind(this),

  }).render(this.button);

  Tools.disableTillConsenting(
    document.querySelector(this.button),
    document.getElementById('conditions_to_approve[terms-and-conditions]')
  );
};

ACDC.prototype.getIdOrder = function() {
  let url = new URL(this.controller);
  url.searchParams.append('ajax', '1');
  url.searchParams.append('action', 'CreateOrder');

  return fetch(url.toString(), {
    method: 'post',
    headers: {
      'content-type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify({page: 'cart', addAddress: 1})
  }).then(function(res) {
    return res.json();
  }).then(function(data) {
    if (data.success) {
      return data.idOrder;
    }
  });
};

ACDC.prototype.sendData = function(data) {
  let form = document.createElement('form');
  let input = document.createElement('input');

  input.name = "paymentData";
  input.value = JSON.stringify(data);

  form.method = "POST";
  form.action = this.validationController;

  form.appendChild(input);
  document.body.appendChild(form);
  form.submit();
};

ACDC.prototype.initHostedFields = function() {
  if (totPaypalAcdcSdk.HostedFields.isEligible()) {

    // Renders card fields
    totPaypalAcdcSdk.HostedFields.render({
      // Call your server to set up the transaction
      createOrder: function () {
        return this.getIdOrder();
      }.bind(this),

      styles: {
        '.valid': {
          'color': 'green'
        },
        '.invalid': {
          'color': 'red'
        }
      },

      fields: {
        number: {
          selector: "#card-number",
          placeholder: "4111 1111 1111 1111"
        },
        cvv: {
          selector: "#cvv",
          placeholder: "123",
          type: 'password'
        },
        expirationDate: {
          selector: "#expiration-date",
          placeholder: "MM/YY"
        }
      }
    }).then(function (cardFields) {
      document.querySelector("#card-form").addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (typeof cardFields['_state'] != 'undefined') {
          if (typeof cardFields['_state']['fields'] != 'undefined') {
            for (let nameField in cardFields['_state']['fields']) {
              if (cardFields['_state']['fields'][nameField]['isEmpty']) {
                let message = '';

                switch (nameField) {
                  case 'cvv':
                    message = typeof this.messages['CVV_IS_EMPTY'] != 'undefined'? this.messages['CVV_IS_EMPTY'] : '';
                    break;
                  case 'number':
                    message = typeof this.messages['NUMBER_IS_EMPTY'] != 'undefined'? this.messages['NUMBER_IS_EMPTY'] : '';
                    break;
                  case 'expirationDate':
                    message = typeof this.messages['DATE_IS_EMPTY'] != 'undefined'? this.messages['DATE_IS_EMPTY'] : '';
                    break;
                }
                this.setError(message);
                return;
              }
            }
          }
        }

        this.submitHostedFields(cardFields);
        document.querySelector('#card-form #submit').setAttribute('disabled', true);
      }.bind(this));
    }.bind(this));
  } else {
    // Hides card fields if the merchant isn't eligible
    document.querySelector("#card-form").style = 'display: none';
  }

  Tools.disableTillConsenting(
    document.querySelector('[paypal-acdc-card-wrapper] button'),
    document.getElementById('conditions_to_approve[terms-and-conditions]')
  );
};

ACDC.prototype.submitHostedFields = function(cardFields) {

  cardFields.submit({
    // Trigger 3D Secure authentication
    contingencies: ['SCA_WHEN_REQUIRED']
  })
    .then(function(res) {
      if (res.liabilityShift != undefined) {
        if (res.liabilityShift !== "POSSIBLE") {
          // 3D Secure is failed
          if (typeof this.messages['3DS_FAILED'] != 'undefined') {
            this.setError(this.messages['3DS_FAILED']);
          }

          document.querySelector('#card-form #submit').removeAttribute('disabled');
          return;
        }
      }

      this.sendData({
        orderID: res['orderId']
      });
    }.bind(this))
    .catch(function(reason) {
      document.querySelector('#card-form #submit').removeAttribute('disabled');

      if (reason['name'] == 'INVALID_REQUEST' || reason['name'] == 'VALIDATION_ERROR') {
        if (typeof this.messages['INVALID_REQUEST'] != 'undefined') {
          this.setError(this.messages['INVALID_REQUEST']);
        }
      }
      console.log(reason);
    }.bind(this))
};

ACDC.prototype.setError = function(message) {
  const alert = Tools.getAlert(message, 'danger');
  document.querySelector('[paypal-acdc-card-error]').innerHTML = '';
  document.querySelector('[paypal-acdc-card-error]').appendChild(alert);
};

ACDC.prototype.hideElementTillPaymentOptionChecked = function(paymentOptionSelector, hideElementSelector) {
  Tools.hideElementTillPaymentOptionChecked(paymentOptionSelector, hideElementSelector);
};

window.ACDC = ACDC;


