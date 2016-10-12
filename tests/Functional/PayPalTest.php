<?php

namespace Tests\Functional;

class PayPalTest extends BaseTestCase {

    public function testGetAccessToken() {

        $var = '{
	"args": {
                    "clientId": "Ae7QFDaWoKwglHXmgL133-4B1o4J5BfXw0HKL3SNJumVxhDMpL9VOvsZh-oA5Pc_PoexgzkSeO1Q95XI",
                    "secret": "EAym3vWLEpSciyTuwCtQjRG8ByrhgWqyCx0piYrjcRooJPW-tRnya8Twpryb9OV4v074uSIimTm9MYlB",
                    "grantType": "client_credentials",
                    "sandbox": "1"
                  }
          }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getAccessToken', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testCreatePayment() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "intent": "sale",
                          "payer": {"payment_method": "paypal"},
                          "transactions": [
                    {
                      "amount": {
                        "total": "30.11",
                        "currency": "USD",
                        "details": {
                          "subtotal": "30.00",
                          "tax": "0.07",
                          "shipping": "0.03",
                          "handling_fee": "1.00",
                          "shipping_discount": "-1.00",
                          "insurance": "0.01"
                        }
                      },
                      "description": "This is the payment transaction description.",
                      "custom": "EBAY_EMS_90048630024435",
                      "invoice_number": "48787589673",
                      "payment_options": {
                        "allowed_payment_method": "INSTANT_FUNDING_SOURCE"
                      },
                      "soft_descriptor": "ECHI5786786",
                      "item_list": {
                        "items": [
                          {
                            "name": "hat",
                            "description": "Brown color hat",
                            "quantity": "5",
                            "price": "3",
                            "tax": "0.01",
                            "sku": "1",
                            "currency": "USD"
                          },
                          {
                            "name": "handbag",
                            "description": "Black color hand bag",
                            "quantity": "1",
                            "price": "15",
                            "tax": "0.02",
                            "sku": "product34",
                            "currency": "USD"
                          }
                        ],
                        "shipping_address": {
                          "recipient_name": "Hello World",
                          "line1": "4thFloor",
                          "line2": "unit#34",
                          "city": "SAn Jose",
                          "country_code": "US",
                          "postal_code": "95131",
                          "phone": "011862212345678",
                          "state": "CA"
                        }
                      }
                    }
                  ],
                          "noteToPayer": "Contact us for any questions on your order.",
                          "redirectUrls": {
                    "return_url": "http://www.amazon.com",
                    "cancel_url": "http://www.hawaii.com"
                  },
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createPayment', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testExecutePayment() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "paymentId": "PAY-0A129924HC424582FK75Z3VI",
                      "payerId": "RRCYJUTFJGZTA",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/executePayment', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetPayment() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "paymentId": "PAY-1EL32202CF2179517K77EDZY",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getPayment', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testUpdatePayment() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "paymentId": "PAY-1EL32202CF2179517K77EDZY",
                      "items": [
                        {
                          "op": "replace",
                          "path": "/transactions/0/amount",
                          "value": {
                            "total": "32.37",
                            "currency": "USD",
                            "details": {
                              "subtotal": "30.00",
                              "shipping": "2.37"
                            }
                          }
                        },
                        {
                          "op": "add",
                          "path": "/transactions/0/item_list/shipping_address",
                          "value": {
                            "recipient_name": "Gruneberg, Anna",
                            "line1": "Kathwarinenhof 1",
                            "city": "Flensburg",
                            "postal_code": "24939",
                            "country_code": "DE"
                          }
                        }
                      ],
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updatePayment', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetPaymentList() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getPaymentList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetSale() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getSale', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testRefundSale() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      	  "saleId": "111111111",
                        "amount": {
                  "total": "2.34",
                  "currency": "USD"
                },
                        "sandbox": "1"
                      }
              }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/refundSale', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetRefund() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      	  "saleId": "111111111",
                        "amount": {
                  "total": "2.34",
                  "currency": "USD"
                },
                        "sandbox": "1"
                      }
              }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getRefund', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetAuthorization() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      	  "authorizationId": "1111111111111",
                        "sandbox": "1"
                      }
              }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getAuthorization', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCaptureAuthorization() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      	  "authorizationId": "1111111111111",
                        "sandbox": "1"
                      }
              }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/captureAuthorization', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testVoidAuthorization() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      	  "authorizationId": "1111111111111",
                        "sandbox": "1"
                      }
              }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/voidAuthorization', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testReauthorizePayment() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      	  "authorizationId": "2DC87612EK520411B",
                                "amount": {
                          "total": "7.00",
                          "currency": "USD"
                        },
                                "sandbox": "1"
                              }
                      }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/reauthorizePayment', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetCapture() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "captureId": "8F148933LY9388354",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getCapture', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testRefundCapture() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                        	  "captureId": "2MU78835H4515710F",
                                "amount": {
                          "currency": "USD",
                          "total": "110.54"
                        },
                                "sandbox": "1"
                              }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/refundCapture', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetOrder() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                        	  "captureId": "2MU78835H4515710F",
                                "amount": {
                          "currency": "USD",
                          "total": "110.54"
                        },
                                "sandbox": "1"
                              }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getOrder', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testAuthorizeOrder() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                        	  "orderId": "O-0PW72302W3743444R",
                                    "amount": {
                              "currency": "USD",
                              "total": "4.54"
                            },
                                "sandbox": "1"
                              }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/authorizeOrder', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCaptureOrder() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "orderId": "O-3SP845109F051535C",
                          "amount": {
                    "currency": "USD",
                    "total": "44.54"
                  },
                  "is_final_capture": true,
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/captureOrder', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testVoidOrder() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "orderId": "O-0NR488530V5211123",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/voidOrder', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCreatePlan() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "name": "T-Shirt of the Month Club Plan",
  "description": "Template creation.",
  "type": "fixed",
  "paymentDefinitions": [
    {
      "name": "Regular Payments",
      "type": "REGULAR",
      "frequency": "MONTH",
      "frequency_interval": "2",
      "amount": {
        "value": "100",
        "currency": "USD"
      },
      "cycles": "12",
      "charge_models": [
        {
          "type": "SHIPPING",
          "amount": {
            "value": "10",
            "currency": "USD"
          }
        },
        {
          "type": "TAX",
          "amount": {
            "value": "12",
            "currency": "USD"
          }
        }
      ]
    }
  ],
  "merchantPreferences": {
    "setup_fee": {
      "value": "1",
      "currency": "USD"
    },
    "return_url": "http://www.return.com",
    "cancel_url": "http://www.cancel.com",
    "auto_bill_amount": "YES",
    "initial_fail_amount_action": "CONTINUE",
    "max_fail_attempts": "0"
  },
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createPlan', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testUpdatePlan() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "planId": "P-7T4040658U3451534WKUR4KY",
  	  "items": [
  {
    "path": "/",
    "value": {
      "state": "ACTIVE"
    },
    "op": "replace"
  }
], 	
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updatePlan', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetPlan() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "planId": "P-7T4040658U3451534WKUR4KY",
  	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getPlan', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetPlanList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "status": "active",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getPlanList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testCreateAgreement() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "name": "T-Shirt of the Month Club Agreement",
  "description": "Agreement for T-Shirt of the Month Club Plan",
  "startDate": "2017-02-19T00:37:04Z",
  "plan": {
    "id": "P-7T4040658U3451534WKUR4KY"
  },
  "payer": {
    "payment_method": "paypal"
  },
  "shippingAddress": {
    "line1": "111 First Street",
    "city": "Saratoga",
    "state": "CA",
    "postal_code": "95070",
    "country_code": "US"
  },
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testExecuteAgreement() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "paymentToken": "P-7T4040658U3451534WKUR4KY",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/executeAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testUpdateAgreement() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "agreementId": "I-0LN988D3JACS",
	  "items": [
  {
    "op": "replace",
    "path": "/",
    "value": {
      "description": "New Description",
      "shipping_address": {
        "line1": "2065 Hamilton Ave",
        "city": "San Jose",
        "state": "CA",
        "postal_code": "95125",
        "country_code": "US"
      }
    }
  }
],
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updateAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetAgreement() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "agreementId": "I-0LN988D3JACS",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testSuspendAgreement() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "agreementId": "I-0LN988D3JACS",
          "note": "Suspending the agreement.",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/suspendAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testReactivateAgreement() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "agreementId": "I-0LN988D3JACS",
          "note": "Suspending the agreement.",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/reactivateAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCancelAgreement() {

        $var = '{
                "args": {
                  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                  "agreementId": "I-0LN988D3JACS",
                  "note": "Cancel the agreement.",
                  "sandbox": "1"
                }
        }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/cancelAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetTransactionsForBillingAgreement() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "agreementId": "I-0LN988D3JACS",
                          "startDate": "2016-05-01",
                          "endDate": "2016-10-11",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getTransactionsForBillingAgreement', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testSetAgreementBalance() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "agreementId": "I-0LN988D3JACS",
                          "currency": "USD",
                          "value": "100",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/setAgreementBalance', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testBillAgreementBalance() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "agreementId": "I-0LN988D3JACS",
                          "note": "Test bill",
                          "amount": {
                                          "currency": "USD",
                                          "value": "100"
                          }, 
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/billAgreementBalance', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCreatePayout() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "senderBatchHeader": {
                    "sender_batch_id": "325272063",
                    "email_subject": "You have a Payout!"
                  },
                  "items": [
                    {
                      "recipient_type": "EMAIL",
                      "amount": {
                        "value": "9.87",
                        "currency": "USD"
                      },
                      "note": "Thanks for your patronage!",
                      "sender_item_id": "201403140001",
                      "receiver": "anybody01@gmail.com"
                    }
                  ], 
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createPayout', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetPayout() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "payoutBatchId": "M7N6D72V2ECYY",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getPayout', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetPayoutItem() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "payoutItemId": "LPLGE8MH4WDYN",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getPayoutItem', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testCancelPayoutItem() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "payoutItemId": "452345",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/cancelPayoutItem', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCreateCreditCard() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "payer_id":"user12345",
                  "type":"visa",
                  "number":"4012888888881881",
                  "expireMonth":"11",
                  "expireYear":"2018",
                  "first_name":"Betsy",
                  "last_name":"Buyer",
                  "billingAddress":{
                  "line1":"111 First Street",
                  "city":"Saratoga",
                  "country_code":"US",
                  "state":"CA",
                  "postal_code":"95070"
                  },
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createCreditCard', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testDeleteCreditCard() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "creditCardId":"CARD-60B02616TT192174WK76QAFI",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteCreditCard', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetCreditCard() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "creditCardId":"CARD-705140842B316673AK76QGPI",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getCreditCard', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetCreditCardList() {

        $var = '{
                    "args": {
                      "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                      "sandbox": "1"
                    }
            }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getCreditCardList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testUpdateCreditCard() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "creditCardId": "CARD-705140842B316673AK76QGPI",
                          "items": [
                                                  {
                                                    "op": "replace",
                                                    "path": "/billing_address",
                                                    "value": {
                                                      "line1": "111 First Street",
                                                      "city": "Saratoga",
                                                      "country_code": "US",
                                                      "state": "CA",
                                                      "postal_code": "95070"
                                                    }
                                                  }
                                                ],
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updateCreditCard', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetUser() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "schema": "openid",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getUser', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testCreateInvoice() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "merchantInfo": {
    "email": "serg.osipchuk-facilitator@rapidapi.com",
    "first_name": "Dennis",
    "last_name": "Doctor",
    "business_name": "Medical Professionals, LLC",
    "phone": {
      "country_code": "001",
      "national_number": "5032141716"
    },
    "address": {
      "line1": "1234 Main St.",
      "city": "Portland",
      "state": "OR",
      "postal_code": "97217",
      "country_code": "US"
    }
  },
  "billingInfo": [
    {
      "email": "example@example.com"
    }
  ],
  "items": [
    {
      "name": "Sutures",
      "quantity": 100,
      "unit_price": {
        "currency": "USD",
        "value": "5"
      }
    }
  ],
  "note": "Medical Invoice 16 Jul, 2013 PST",
  "paymentTerm": {
    "term_type": "NET_45"
  },
  "shippingInfo": {
    "first_name": "Sally",
    "last_name": "Patient",
    "business_name": "Not applicable",
    "phone": {
      "country_code": "001",
      "national_number": "5039871234"
    },
    "address": {
      "line1": "1234 Broad St.",
      "city": "Portland",
      "state": "OR",
      "postal_code": "97216",
      "country_code": "US"
    }
  },
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testSendInvoice() {

        $var = '{
                        "args": {
                          "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
                          "invoiceId": "INV2-GXSG-BCEM-B98V-KP6B",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/sendInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testUpdateInvoice() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "invoiceId": "INV2-GXSG-BCEM-B98V-KP6B",
	  "merchantInfo": {
    "email": "serg.osipchuk-facilitator@rapidapi.com",
    "first_name": "Dennis",
    "last_name": "Doctor",
    "business_name": "Medical Professionals, LLC",
    "phone": {
      "country_code": "001",
      "national_number": "5032141716"
    },
    "address": {
      "line1": "1234 Main St.",
      "city": "Portland",
      "state": "OR",
      "postal_code": "97217",
      "country_code": "US"
    }
  },
  "billingInfo": [
    {
      "email": "example@example.com"
    }
  ],
  "items": [
    {
      "name": "Sutures",
      "quantity": 100,
      "unit_price": {
        "currency": "USD",
        "value": "5"
      }
    }
  ],
  "note": "Medical Invoice 16 Jul, 2013 PST",
  "paymentTerm": {
    "term_type": "NET_45"
  },
  "shippingInfo": {
    "first_name": "Sally",
    "last_name": "Patient",
    "business_name": "Not applicable",
    "phone": {
      "country_code": "001",
      "national_number": "5039871234"
    },
    "address": {
      "line1": "1234 Broad St.",
      "city": "Portland",
      "state": "OR",
      "postal_code": "97216",
      "country_code": "US"
    }
  },
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updateInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetInvoice() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "invoiceId": "INV2-GXSG-BCEM-B98V-KP6B",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetInvoiceList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getInvoiceList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGenerateInvoiceNumber() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/generateInvoiceNumber', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testSearchInvoice() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
		"startInvoiceDate": "2014-01-01 PST",
  "endInvoiceDate": "2014-03-26 PST",
  "page": 0,
  "page_size": 3,
  "totalCountRequired": true	  
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/searchInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testSendInvoiceReminder() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-GXSG-BCEM-B98V-KP6B",
	  "subject": "Past due",
  "note": "Please pay soon",
  "sendToMerchant": "true"
	  
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/sendInvoiceReminder', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testDeleteInvoice() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-92MG-CNXV-ND7G-P3D2"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetQRCode() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-GXSG-BCEM-B98V-KP6B"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getQRCode', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetTemplate() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "templateId": "TEMP-17S5837101782162D"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getTemplate', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetTemplateList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getTemplateList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testCreateWebProfile() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "name": "YeowZa! T-Shirt Shop_'.rand(1,100000000000).'",
  "presentation": {
    "brand_name": "YeowZa! Paypal",
    "logo_image": "http://www.yeowza.com",
    "locale_code": "US"
  },
  "inputFields": {
    "allow_note": true,
    "no_shipping": 0,
    "address_override": 1
  },
  "flowConfig": {
    "landing_page_type": "billing",
    "bank_txn_pending_url": "http://www.yeowza.com"
  }
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createWebProfile', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetWebProfile() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
          "profileId": "XP-W2QA-5EEF-JC83-FVYD"  
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getWebProfile', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetProfileWebList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getProfileWebList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testUpdateWebProfile() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1""profileId": "XP-W2QA-5EEF-JC83-FVYD"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updateWebProfile', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testDeleteWebProfile() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1""profileId": "XP-W2QA-5EEF-JC83-FVYD"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteWebProfile', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCreateWebhook() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "url": "https://paypal.local/paypal_webhook' . rand(1, 100000000) . '",
  "eventTypes": [
    {
      "name": "PAYMENT.AUTHORIZATION.CREATED"
    },
    {
      "name": "PAYMENT.AUTHORIZATION.VOIDED"
    }
  ]
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createWebhook', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetWebhook() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "webhookId": "29B44752DM328171C"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getWebhook', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetWebhookList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getWebhookList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testUpdateWebhook() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "webhookId": "29B44752DM328171C",
	  "items": [
  {
    "op": "replace",
    "path": "/url",
    "value": "https://paypal.local/paypal_webhook_new_url"
  },
  {
    "op": "replace",
    "path": "/event_types",
    "value": [
      {
        "name": "PAYMENT.SALE.REFUNDED"
      }
    ]
  }
]
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updateWebhook', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testDeleteWebhook() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "webhookId": "29B44752DM328171C"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteWebhook', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetEventNotifications() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "eventId": "WH-2N1678257S892762B-8MC99539P4557624Y"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getEventNotifications', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetEventNotificationsList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getEventNotificationsList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testResendEventNotification() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "eventId": "MC99539P4557624Y",
	  "webhookIds": ["12334456"]
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/resendEventNotification', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testGetEventList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "eventId": "MC99539P4557624Y",
	  "webhookIds": ["12334456"]
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getEventList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testGetWebhookEventSubscriptionList() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "webhookId": "54T60865TR9081003"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/getWebhookEventSubscriptionList', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testSimulateWebhookEvent() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "url": "https://paypal.local/paypal_webhook_1",
  "eventType": "PAYMENT.AUTHORIZATION.CREATED"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/simulateWebhookEvent', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testCancelSentInvoice() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-GXSG-BCEM-B98V-KP6B",
  "subject": "Past due",
  "note": "Canceling invoice",
  "send_to_merchant": true,
  "send_to_payer": true
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/cancelSentInvoice', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testMarkInvoiceAsPaid() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-4Y98-4B9E-H8HY-48M7",
"method": "CASH",
  "date": "2016-11-10 03:30:00 PST",
  "note": "I got the payment by cash!",
  "amount": {
    "currency": "USD",
    "value": "20.00"
  }
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/markInvoiceAsPaid', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testMarkInvoiceAsRefunded() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-4Y98-4B9E-H8HY-48M7",
"method": "CASH",
  "date": "2016-11-10 03:30:00 PST",
  "note": "refunded by cash!",
  "amount": {
    "currency": "USD",
    "value": "20.00"
  }
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/markInvoiceAsRefunded', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testDeleteExternalPayment() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-TBRZ-SWBK-7FQ9-AC8F",
	  "transactionId": "EXTR-86F38350LX4353815"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteExternalPayment', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testDeleteExternalRefund() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "invoiceId": "INV2-LT6D-D2SR-Y97U-QR3K",
	  "transactionId": "EXTR-86F38350LX4353815"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteExternalRefund', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testCreateTemplate() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
"name": "Hours Template_' . rand(1, 10000000000) . '",
  "default": true,
  "unitOfMeasure": "Hours",
  "templateData": {
    "items": [
      {
        "name": "Nutri Bullet",
        "quantity": 1,
        "unit_price": {
          "currency": "USD",
          "value": "50.00"
        }
      }
    ],
    "merchant_info": {
      "email": "serg.osipchuk-facilitator@rapidapi.com"
    },
    "tax_calculated_after_discount": false,
    "tax_inclusive": false,
    "note": "Thank you for your business.",
    "logo_url": "https://pics.paypal.com/v1/images/redDot.jpeg"
  },
  "settings": [
    {
      "field_name": "items.date",
      "display_preference": {
        "hidden": true
      }
    },
    {
      "field_name": "custom",
      "display_preference": {
        "hidden": true
      }
    }
  ]
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/createTemplate', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

    public function testDeleteTemplate() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "templateId": "TEMP-89385919FL409783E"
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/deleteTemplate', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testVerifyWebhookSignature() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
"transmissionId": "69cd13f0-d67a-11e5-baa3-778b53f4ae55",
  "transmissionTime": "2016-02-18T20:01:35Z",
  "certUrl": "cert_url",
  "authAlgo": "SHA256withRSA",
  "transmissionSig": "lmI95Jx3Y9nhR5SJWlHVIWpg4AgFk7n9bCHSRxbrd8A9zrhdu2rMyFrmz+Zjh3s3boXB07VXCXUZy/UFzUlnGJn0wDugt7FlSvdKeIJenLRemUxYCPVoEZzg9VFNqOa48gMkvF+XTpxBeUx/kWy6B5cp7GkT2+pOowfRK7OaynuxUoKW3JcMWw272VKjLTtTAShncla7tGF+55rxyt2KNZIIqxNMJ48RDZheGU5w1npu9dZHnPgTXB9iomeVRoD8O/jhRpnKsGrDschyNdkeh81BJJMH4Ctc6lnCCquoP/GzCzz33MMsNdid7vL/NIWaCsekQpW26FpWPi/tfj8nLA==",
  "webhookId": "1JE4291016473214C",
  "webhookEvent": {
    "id": "8PT597110X687430LKGECATA",
    "create_time": "2013-06-25T21:41:28Z",
    "resource_type": "authorization",
    "event_type": "PAYMENT.AUTHORIZATION.CREATED",
    "summary": "A payment authorization was created",
    "resource": {
      "id": "2DC87612EK520411B",
      "create_time": "2013-06-25T21:39:15Z",
      "update_time": "2013-06-25T21:39:17Z",
      "state": "authorized",
      "amount": {
        "total": "7.47",
        "currency": "USD",
        "details": {
          "subtotal": "7.47"
        }
      },
      "parent_payment": "PAY-36246664YD343335CKHFA4AY",
      "valid_until": "2013-07-24T21:39:15Z",
      "links": [
        {
          "href": "https://api.paypal.com/v1/payments/authorization/2DC87612EK520411B",
          "rel": "self",
          "method": "GET"
        },
        {
          "href": "https://api.paypal.com/v1/payments/authorization/2DC87612EK520411B/capture",
          "rel": "capture",
          "method": "POST"
        },
        {
          "href": "https://api.paypal.com/v1/payments/authorization/2DC87612EK520411B/void",
          "rel": "void",
          "method": "POST"
        },
        {
          "href": "https://api.paypal.com/v1/payments/payment/PAY-36246664YD343335CKHFA4AY",
          "rel": "parent_payment",
          "method": "GET"
        }
      ]
    }
  }
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/verifyWebhookSignature', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
    }

    public function testUpdateTemplate() {

        $var = '{
	"args": {
	  "accessToken": "A101.j5Ex6Ytd6kQSu088NJ9sS9IkrkbnueP_mCH6uxM2M8VljC6tzQ9Oguw_O6S1ZO5T.QNzVJBUB7jRGEbBiUvo7h9lCiF8",
	  "sandbox": "1",
	  "templateId": "TEMP-1FV13188R1449493P",
"name": "Hours Template",
  "default": true,
  "unitOfMeasure": "Hours",
  "templateData": {
    "items": [
      {
        "name": "Nutri Bullet",
        "quantity": 1,
        "unit_price": {
          "currency": "USD",
          "value": "50.00"
        }
      }
    ],
    "merchant_info": {
      "email": "serg.osipchuk-facilitator@rapidapi.com"
    },
    "tax_calculated_after_discount": false,
    "tax_inclusive": false,
    "note": "Thank you for your business.",
    "logo_url": "https://pics.paypal.com/v1/images/redDot.jpeg"
  },
  "settings": [
    {
      "field_name": "items.date",
      "display_preference": {
        "hidden": true
      }
    },
    {
      "field_name": "custom",
      "display_preference": {
        "hidden": true
      }
    }
  ]
	}
}';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/PayPal/updateTemplate', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

}
