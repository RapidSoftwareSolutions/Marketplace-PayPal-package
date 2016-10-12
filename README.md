# Paypal Package
PayPal offers online payment solutions.
* Domain: paypal.com
* Credentials: clientId, secret

## How to get credentials: 
0. Item one 
1. Item two

## TOC: 
* [getAccessToken](#getAccessToken)
* [createPayment](#createPayment)
* [executePayment](#executePayment)
* [getPayment](#getPayment)
* [updatePayment](#updatePayment)
* [getPaymentList](#getPaymentList)
* [getSale](#getSale)
* [refundSale](#refundSale)
* [getRefund](#getRefund)
* [getAuthorization](#getAuthorization)
* [captureAuthorization](#captureAuthorization)
* [voidAuthorization](#voidAuthorization)
* [reauthorizePayment](#reauthorizePayment)
* [getCapture](#getCapture)
* [refundCapture](#refundCapture)
* [getOrder](#getOrder)
* [authorizeOrder](#authorizeOrder)
* [captureOrder](#captureOrder)
* [voidOrder](#voidOrder)
* [createPlan](#createPlan)
* [updatePlan](#updatePlan)
* [getPlan](#getPlan)
* [getPlanList](#getPlanList)
* [createAgreement](#createAgreement)
* [executeAgreement](#executeAgreement)
* [updateAgreement](#updateAgreement)
* [getAgreement](#getAgreement)
* [suspendAgreement](#suspendAgreement)
* [reactivateAgreement](#reactivateAgreement)
* [cancelAgreement](#cancelAgreement)
* [getTransactionsForBillingAgreement](#getTransactionsForBillingAgreement)
* [setAgreementBalance](#setAgreementBalance)
* [billAgreementBalance](#billAgreementBalance)
* [createPayout](#createPayout)
* [getPayout](#getPayout)
* [getPayoutItem](#getPayoutItem)
* [cancelPayoutItem](#cancelPayoutItem)
* [createCreditCard](#createCreditCard)
* [deleteCreditCard](#deleteCreditCard)
* [getCreditCard](#getCreditCard)
* [getCreditCardList](#getCreditCardList)
* [updateCreditCard](#updateCreditCard)
* [createTokenFromAurhorizationCode](#createTokenFromAurhorizationCode)
* [createTokenFromRefreshToken](#createTokenFromRefreshToken)
* [getUser](#getUser)
* [createInvoice](#createInvoice)
* [sendInvoice](#sendInvoice)
* [updateInvoice](#updateInvoice)
* [getInvoice](#getInvoice)
* [getInvoiceList](#getInvoiceList)
* [generateInvoiceNumber](#generateInvoiceNumber)
* [searchInvoice](#searchInvoice)
* [sendInvoiceReminder](#sendInvoiceReminder)
* [deleteInvoice](#deleteInvoice)
* [getQRCode](#getQRCode)
* [getTemplate](#getTemplate)
* [getTemplateList](#getTemplateList)
* [createWebProfile](#createWebProfile)
* [getWebProfile](#getWebProfile)
* [getProfileWebList](#getProfileWebList)
* [updateWebProfile](#updateWebProfile)
* [deleteWebProfile](#deleteWebProfile)
* [createWebhook](#createWebhook)
* [getWebhook](#getWebhook)
* [getWebhookList](#getWebhookList)
* [updateWebhook](#updateWebhook)
* [deleteWebhook](#deleteWebhook)
* [getEventNotifications](#getEventNotifications)
* [getEventNotificationsList](#getEventNotificationsList)
* [resendEventNotification](#resendEventNotification)
* [getEventList](#getEventList)
* [getWebhookEventSubscriptionList](#getWebhookEventSubscriptionList)
* [simulateWebhookEvent](#simulateWebhookEvent)
* [cancelSentInvoice](#cancelSentInvoice)
* [markInvoiceAsPaid](#markInvoiceAsPaid)
* [markInvoiceAsRefunded](#markInvoiceAsRefunded)
* [deleteExternalPayment](#deleteExternalPayment)
* [deleteExternalRefund](#deleteExternalRefund)
* [createTemplate](#createTemplate)
* [deleteTemplate](#deleteTemplate)
* [verifyWebhookSignature](#verifyWebhookSignature)
* [updateTemplate](#updateTemplate)
 
<a name="getAccessToken"/>
## Paypal.getAccessToken
Method description

| Field    | Type       | Description
|----------|------------|----------
| clientId | credentials| Required: Client id.
| secret   | credentials| Required: secret
| grantType| String     | Required: Token grant type. Must be set to client_credentials.

#### Request example
```json
{	"clientId": "...",
	"secret": "...",
	"grantType": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createPayment"/>
## Paypal.createPayment
Method description

| Field              | Type  | Description
|--------------------|-------|----------
| accessToken        | String| Required: accessToken obtained with clientId and secret.
| intent             | String| Required: Payment intent. Must be set to sale for immediate payment, authorize to authorize a payment for capture later, or order to create an order. Allowed values: sale, authorize, order.
| payer              | JSON  | Required: Source of the funds for this payment represented by a PayPal account or a direct credit card.
| transactions       | JSON  | Required: Transaction details, if updating a payment. Note that this instance of the transactions object accepts only the amount object.
| experienceProfileId| String| Optional: PayPal generated identifier for the merchant's payment experience profile.
| noteToPayer        | String| Optional: free-form field for the use of clients to pass in a message to the payer.
| redirectUrls       | JSON  | Optional: Set of redirect URLs you provide only for PayPal-based payments.

#### Request example
```json
{	"accessToken": "...",
	"intent": "...",
	"payer": "...",
	"transactions": "...",
	"experienceProfileId": "...",
	"noteToPayer": "...",
	"redirectUrls": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="executePayment"/>
## Paypal.executePayment
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| paymentId   | String| Required: The ID of the payment to execute.
| payerId     | String| Required: The ID of the payer, passed in the return_url by PayPal.
| transactions| String| Optional: Transactional details if updating a payment. Note that this instance of the transactions object accepts only the amount object.

#### Request example
```json
{	"accessToken": "...",
	"paymentId": "...",
	"payerId": "...",
	"transactions": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getPayment"/>
## Paypal.getPayment
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| paymentId  | String| Required: The ID of the payment to execute.

#### Request example
```json
{	"accessToken": "...",
	"paymentId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updatePayment"/>
## Paypal.updatePayment
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| paymentId  | String| Required: The ID of the payment to execute.
| items      | JSON  | Required: A JSON patch object that you can use to apply partial updates to resources.

#### Request example
```json
{	"accessToken": "...",
	"paymentId": "...",
	"items": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getPaymentList"/>
## Paypal.getPaymentList
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| count      | String| Optional: The number of items to list in the response. Default: 10.
| startId    | String| Optional: The ID of the starting resource in the response. When results are paged, you can use the next_id value as the start_id to continue with the next set of results.
| startIndex | String| Optional: The start index of the resources to return. Typically used to jump to a specific position in the resource history based on its cart. Example for starting at the second item in a list of results: ?start_index=2
| startTime  | String| Optional: The date and time when the resource was created. Indicates the start of a range of results. Example: start_time=2013-03-06T11:00:00Z Format: date-time.
| endTime    | String| Optional: The date and time when the resource was created. Indicates the end of a range of results. Format: date-time.

#### Request example
```json
{	"accessToken": "...",
	"count": "...",
	"startId": "...",
	"startIndex": "...",
	"startTime": "...",
	"endTime": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getSale"/>
## Paypal.getSale
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| saleId     | String| Required: The ID of the sale for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"saleId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="refundSale"/>
## Paypal.refundSale
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| saleId       | String| Required: The ID of the sale for which to show details.
| amount       | JSON  | Optional: Refund details including both the refunded amount to payer and refunded fee to payee. If you do not provide an amount, you must still provide an empty JSON payload in the body to indicate a full refund.
| refundSource | String| Optional: Type of PayPal funding source (balance or eCheck) that can be used for auto refund. Allowed values: INSTANT_FUNDING_SOURCE, ECHECK, UNRESTRICTED. Default: UNRESTRICTED.
| invoiceNumber| String| Optional: The invoice number that is used to track this payment. Character length and limitations: 127 single-byte alphanumeric characters. Maximum length: 127.
| refundAdvice | Bool  | Optional: Flag to indicate that the buyer was already given store credit for a given transaction.

#### Request example
```json
{	"accessToken": "...",
	"saleId": "...",
	"amount": "...",
	"refundSource": "...",
	"invoiceNumber": "...",
	"refundAdvice": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getRefund"/>
## Paypal.getRefund
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| refundId   | String| Required: The ID of the refund for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"refundId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getAuthorization"/>
## Paypal.getAuthorization
Method description

| Field          | Type  | Description
|----------------|-------|----------
| accessToken    | String| Required: accessToken obtained with clientId and secret.
| authorizationId| String| Required: The ID of the authorization for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"authorizationId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="captureAuthorization"/>
## Paypal.captureAuthorization
Method description

| Field          | Type  | Description
|----------------|-------|----------
| accessToken    | String| Required: accessToken obtained with clientId and secret.
| authorizationId| String| Required: The ID of the authorization for which to show details.
| amount         | JSON  | Optional: The amount to capture. If the amount matches the orginally authorized amount, the state of the authorization changes to captured. If not, the state of the authorization changes to partially_captured.
| isFinalCapture | Bool  | Optional: Indicates whether to release all remaining funds that the authorization holds in the funding instrument. Default is false. Default: false.
| invoiceNumber  | String| Optional: The invoice number to track this payment. Maximum length: 127.

#### Request example
```json
{	"accessToken": "...",
	"authorizationId": "...",
	"amount": "...",
	"isFinalCapture": "...",
	"invoiceNumber": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="voidAuthorization"/>
## Paypal.voidAuthorization
Method description

| Field          | Type  | Description
|----------------|-------|----------
| accessToken    | String| Required: accessToken obtained with clientId and secret.
| authorizationId| String| Required: The ID of the authorization for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"authorizationId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="reauthorizePayment"/>
## Paypal.reauthorizePayment
Method description

| Field          | Type  | Description
|----------------|-------|----------
| accessToken    | String| Required: accessToken obtained with clientId and secret.
| authorizationId| String| Required: The ID of the authorization for which to show details.
| amount         | JSON  | Required: Amount being reauthorized.

#### Request example
```json
{	"accessToken": "...",
	"authorizationId": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getCapture"/>
## Paypal.getCapture
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| captureId  | String| Required: The ID of the captured payment for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"captureId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="refundCapture"/>
## Paypal.refundCapture
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| captureId    | String| Required: The ID of the captured payment for which to show details.
| amount       | JSON  | Optional: The amount to be refunded to the original payer by the payee.
| description  | String| Optional: Description of what is being refunded for. Character length and limitations: 255 single-byte alphanumeric characters.
| refundSource | String| Optional: Type of PayPal funding source (balance or eCheck) that can be used for auto refund. Allowed values: INSTANT_FUNDING_SOURCE, ECHECK, UNRESTRICTED. Default: UNRESTRICTED.
| reason       | String| Optional: Reason description for the Sale transaction being refunded.
| invoiceNumber| String| Optional: The invoice number that is used to track this payment. Character length and limitations: 127 single-byte alphanumeric characters.
| refundAdvice | String| Optional: Flag to indicate that the buyer was already given store credit for a given transaction.

#### Request example
```json
{	"accessToken": "...",
	"captureId": "...",
	"amount": "...",
	"description": "...",
	"refundSource": "...",
	"reason": "...",
	"invoiceNumber": "...",
	"refundAdvice": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getOrder"/>
## Paypal.getOrder
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| orderId    | String| Required: The ID of the order for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"orderId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="authorizeOrder"/>
## Paypal.authorizeOrder
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| orderId    | String| Required: The ID of the order for which to show details.
| amount     | JSON  | Required: Amount being collected.

#### Request example
```json
{	"accessToken": "...",
	"orderId": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="captureOrder"/>
## Paypal.captureOrder
Method description

| Field         | Type  | Description
|---------------|-------|----------
| accessToken   | String| Required: accessToken obtained with clientId and secret.
| orderId       | String| Required: The ID of the order for which to show details.
| amount        | JSON  | Optional: The amount to capture. If the amount matches the orginally authorized amount, the state of the authorization changes to captured. If not, the state of the authorization changes to partially_captured.
| isFinalCapture| Bool  | Optional: Indicates whether to release all remaining funds that the authorization holds in the funding instrument. Default is false. Default: false.
| invoiceNumber | String| Optional: The invoice number to track this payment.
| transactionFee| JSON  | Optional: The transaction fee for this payment.

#### Request example
```json
{	"accessToken": "...",
	"orderId": "...",
	"amount": "...",
	"isFinalCapture": "...",
	"invoiceNumber": "...",
	"transactionFee": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="voidOrder"/>
## Paypal.voidOrder
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| orderId    | String| Required: The ID of the order to void.

#### Request example
```json
{	"accessToken": "...",
	"orderId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createPlan"/>
## Paypal.createPlan
Method description

| Field              | Type  | Description
|--------------------|-------|----------
| accessToken        | String| Required: accessToken obtained with clientId and secret.
| name               | String| Required: The billing plan name.
| description        | String| Required: The billing plan description.
| type               | String| Required: The billing plan type. Allowed values: FIXED, INFINITE.
| paymentDefinitions | JSON  | Required: Resource that represents payment definition scheduling information.
| merchantPreferences| JSON  | Optional: Resource that represents the merchant preferences for a plan, such as max failed attempts, set up fee, and so on.

#### Request example
```json
{	"accessToken": "...",
	"name": "...",
	"description": "...",
	"type": "...",
	"paymentDefinitions": "...",
	"merchantPreferences": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updatePlan"/>
## Paypal.updatePlan
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| planId     | String| Required: The ID of the billing plan to update.
| items      | JSON  | Optional: A JSON patch object used for applying partial updates to resources.

#### Request example
```json
{	"accessToken": "...",
	"planId": "...",
	"items": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getPlan"/>
## Paypal.getPlan
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| planId     | String| Required: The ID of the billing plan to update.

#### Request example
```json
{	"accessToken": "...",
	"planId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getPlanList"/>
## Paypal.getPlanList
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| page         | String| Optional: The page to return. Default is 0.
| status       | String| Optional: The state. Default is CREATED. Possible values: created, active, inactive.
| pageSize     | String| Optional: The maximum number of results to return at one time. A valid value is a non-negative, non-zero integer. Default is 10.
| totalRequired| String| Optional: The total number of items and pages to return in the response.

#### Request example
```json
{	"accessToken": "...",
	"page": "...",
	"status": "...",
	"pageSize": "...",
	"totalRequired": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createAgreement"/>
## Paypal.createAgreement
Method description

| Field                      | Type  | Description
|----------------------------|-------|----------
| accessToken                | String| Required: accessToken obtained with clientId and secret.
| name                       | String| Required: Name of the agreement. Maximum length: 128.
| description                | String| Required: Description of the agreement. Maximum length: 128.
| startDate                  | String| Required: Start date of the agreement. Date format yyyy-MM-dd z, as defined in ISO8601. Format: YYYY-MM-DDTHH:MM:SSTimeZone.
| payer                      | JSON  | Required: A resource representing a Payer that funds a payment.
| plan                       | JSON  | Required: Billing plan resource that will be used to create a billing agreement.
| agreementDetails           | JSON  | Optional: A resource representing the agreement details.
| shippingAddress            | JSON  | Optional: Base Address object used as billing address in a payment or extended for Shipping Address.
| overrideChargeModels       | JSON  | Optional: A resource representing an override_charge_model to be used during creation of the agreement.
| overrideMerchantPreferences| JSON  | Optional: Resource representing merchant preferences like max failed attempts,set up fee and others for a plan.

#### Request example
```json
{	"accessToken": "...",
	"name": "...",
	"description": "...",
	"startDate": "...",
	"payer": "...",
	"plan": "...",
	"agreementDetails": "...",
	"shippingAddress": "...",
	"overrideChargeModels": "...",
	"overrideMerchantPreferences": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="executeAgreement"/>
## Paypal.executeAgreement
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| paymentToken| String| Required: Identifier of the agreement resource to execute.

#### Request example
```json
{	"accessToken": "...",
	"paymentToken": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updateAgreement"/>
## Paypal.updateAgreement
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to update.
| items      | JSON  | Required: A JSON patch object used for applying partial updates to resources.

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"items": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getAgreement"/>
## Paypal.getAgreement
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to retrieve.

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="suspendAgreement"/>
## Paypal.suspendAgreement
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to suspend.
| note       | String| Required: Reason for changing the state of the agreement. Maximum length: 128.
| amount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"note": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="reactivateAgreement"/>
## Paypal.reactivateAgreement
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to re-activate.
| note       | String| Required: Reason for changing the state of the agreement. Maximum length: 128.
| amount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"note": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="cancelAgreement"/>
## Paypal.cancelAgreement
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to cancel.
| note       | String| Required: Reason for changing the state of the agreement. Maximum length: 128.
| amount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"note": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getTransactionsForBillingAgreement"/>
## Paypal.getTransactionsForBillingAgreement
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to cancel.
| startDate  | String| Required: The start date of the range of transactions to list.
| endDate    | String| Required: The end date of the range of transactions to list.

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"startDate": "...",
	"endDate": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="setAgreementBalance"/>
## Paypal.setAgreementBalance
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to cancel.
| currency   | String| Required: 3 letter currency code as defined by ISO 4217.
| value      | String| Required: amount up to N digit after the decimals separator as defined in ISO 4217 for the appropriate currency code

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"currency": "...",
	"value": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="billAgreementBalance"/>
## Paypal.billAgreementBalance
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| agreementId| String| Required: Identifier of the agreement resource to cancel.
| note       | String| Required: Reason for changing the state of the agreement. Maximum length: 128.
| amount     | JSON  | Required: Base object for all financial value related fields (balance, payment due, etc.)

#### Request example
```json
{	"accessToken": "...",
	"agreementId": "...",
	"note": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createPayout"/>
## Paypal.createPayout
Method description

| Field            | Type  | Description
|------------------|-------|----------
| accessToken      | String| Required: accessToken obtained with clientId and secret.
| senderBatchHeader| JSON  | Required: The sender-provided batch header for a batch payout request.
| items            | JSON  | Required: A sender-created definition of a payout to a single recipient. Maximum length: 5000.
| syncMode         | JSON  | Optional: Set to true to return an immediate and synchronous response. Default is false, which returns an asynchronous response in the background.

#### Request example
```json
{	"accessToken": "...",
	"senderBatchHeader": "...",
	"items": "...",
	"syncMode": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getPayout"/>
## Paypal.getPayout
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| payoutBatchId| String| Required: The ID of the batch payout for which to show status.
| fields       | String| Optional: Shows details for only specified fields.

#### Request example
```json
{	"accessToken": "...",
	"payoutBatchId": "...",
	"fields": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getPayoutItem"/>
## Paypal.getPayoutItem
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| payoutItemId| String| Required: The ID of the payout item for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"payoutItemId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="cancelPayoutItem"/>
## Paypal.cancelPayoutItem
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| payoutItemId| String| Required: The ID of the payout item for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"payoutItemId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createCreditCard"/>
## Paypal.createCreditCard
Method description

| Field             | Type  | Description
|-------------------|-------|----------
| accessToken       | String| Required: accessToken obtained with clientId and secret.
| number            | String| Required: Credit card number. Valid value is numeric characters with no spaces or punctuation. The string must conform with modulo and length required by each credit card type.
| type              | String| Required: Credit card type. Allowed values: visa, mastercard, amex, discover, maestro.
| expireMonth       | String| Required: Expiration month with no leading zero.
| expireYear        | String| Required: The 4-digit card expiry year.
| cvv2              | String| Optional: The 3 to 4 digit card validation code.
| firstName         | String| Optional: The first name of the card holder. Maximum length is 25 characters.
| lastName          | String| Optional: The last name of the card holder.
| billingAddress    | JSON  | Optional: Base Address object used as billing address in a payment or extended for Shipping Address.
| externalCustomerId| JSON  | Optional: Externally provided ID of the customer for which to list credit card resources.
| merchantId        | JSON  | Optional: ID of the merchant for which to list credit card resources.
| payerId           | JSON  | Optional:  unique ID that you can assign and track when you store a credit card or use a stored credit card.
| externalCardId    | JSON  | Optional:  Externally provided ID of the card for which to list credit card resources.

#### Request example
```json
{	"accessToken": "...",
	"number": "...",
	"type": "...",
	"expireMonth": "...",
	"expireYear": "...",
	"cvv2": "...",
	"firstName": "...",
	"lastName": "...",
	"billingAddress": "...",
	"externalCustomerId": "...",
	"merchantId": "...",
	"payerId": "...",
	"externalCardId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteCreditCard"/>
## Paypal.deleteCreditCard
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| creditCardId| String| Required: The ID of the credit card resource for which to show data.

#### Request example
```json
{	"accessToken": "...",
	"creditCardId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getCreditCard"/>
## Paypal.getCreditCard
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| creditCardId| String| Required: The ID of the credit card resource for which to show data.

#### Request example
```json
{	"accessToken": "...",
	"creditCardId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getCreditCardList"/>
## Paypal.getCreditCardList
Method description

| Field             | Type  | Description
|-------------------|-------|----------
| accessToken       | String| Required: accessToken obtained with clientId and secret.
| pageSize          | String| Optional: The number of resources to list, starting with the specified page. Default: 10.
| page              | String| Optional: The number of pages to get. Default: 1.
| startTime         | String| Optional: The date and time when the resource was created in ISO8601 date-time format that indicates the start of a range of results. For example, 2013-11-05T13:15:30Z.
| endTime           | String| Optional: The date and time when the resource was created in ISO8601 date-time format that indicates the end of a range of results. For example, 2014-11-05T13:15:30Z.
| sortOrder         | String| Optional: Sorts the response in ascending or descending order. Value is asc for ascending order or desc for descending order. Default: desc.
| sortBy            | String| Optional: Sorts the response by create_time or update_time. Default: create_time.
| merchantId        | String| Optional: A user-provided, optional field that functions as a unique identifier for the merchant holding the card. Note that this has no relation to PayPal merchant ID.
| externalCardId    | String| Optional: A unique identifier of the bank account resource. Generated and provided by the facilitator to use to restrict the usage of the bank account to the specific merchant.
| externalCustomerId| String| Optional: Externally provided customer identifier to filter the search results in list operations.
| totalRequired     | String| Optional: Indicates whether the response returns the total_items and total_pages values. Default is true. Set to false to omit these values from the response.

#### Request example
```json
{	"accessToken": "...",
	"pageSize": "...",
	"page": "...",
	"startTime": "...",
	"endTime": "...",
	"sortOrder": "...",
	"sortBy": "...",
	"merchantId": "...",
	"externalCardId": "...",
	"externalCustomerId": "...",
	"totalRequired": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updateCreditCard"/>
## Paypal.updateCreditCard
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| creditCardId| String| Required: The ID of the credit card resource to update.
| items       | JSON  | Required: A JSON patch object used for applying partial updates to resources.

#### Request example
```json
{	"accessToken": "...",
	"creditCardId": "...",
	"items": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createTokenFromAurhorizationCode"/>
## Paypal.createTokenFromAurhorizationCode
Method description

| Field      | Type       | Description
|------------|------------|----------
| clientId   | credentials| Required: Client id.
| secret     | credentials| Required: secret
| grantType  | String     | Required: Token grant type. Value must be set to authorization_code.
| code       | String     | Required: Authorization code previously received from the authorization server.
| redirectUri| String     | Required: AApplication return URL where the authorization code is sent.

#### Request example
```json
{	"clientId": "...",
	"secret": "...",
	"grantType": "...",
	"code": "...",
	"redirectUri": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createTokenFromRefreshToken"/>
## Paypal.createTokenFromRefreshToken
Method description

| Field       | Type       | Description
|-------------|------------|----------
| clientId    | credentials| Required: Client id.
| secret      | credentials| Required: secret
| grantType   | String     | Required: Token grant type. Value must be set to authorization_code.
| refreshToken| String     | Required: Refresh token previously received along with the access token that is to be refreshed.
| scope       | String     | Optional: Resource URL endpoints that the client wants the token to be scoped for. The value of the scope parameter is expressed as a list of space-delimited, case-sensitive strings.

#### Request example
```json
{	"clientId": "...",
	"secret": "...",
	"grantType": "...",
	"refreshToken": "...",
	"scope": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getUser"/>
## Paypal.getUser
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| schema     | String| Required: the schema that is used to return as per openidconnect protocol. Possible values: openid.

#### Request example
```json
{	"accessToken": "...",
	"schema": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createInvoice"/>
## Paypal.createInvoice
Method description

| Field                     | Type  | Description
|---------------------------|-------|----------
| accessToken               | String| Required: accessToken obtained with clientId and secret.
| merchantInfo              | JSON  | Required: Merchant business information that appears on the invoice.
| number                    | String| Optional: The unique invoice number. If you omit this number, it is auto-incremented from the previous invoice number. Maximum length: 25.
| templateId                | String| Optional: The ID of the template from which to create the invoice. Useful for copy functionality.
| billingInfo               | JSON  | Optional: Billing information for the invoice recipient.
| ccInfo                    | JSON  | Optional: Participant information.
| shippingInfo              | JSON  | Optional: Shipping information for the invoice recipient.
| items                     | JSON  | Optional: Line item information.
| invoiceDate               | String| Optional: The date when the invoice was enabled. The date format is yyyy-MM-dd z.
| paymentTerm               | JSON  | Optional: The payment term of the invoice. If you specify term_type, you cannot specify due_date, and vice versa.
| reference                 | String| Optional: Reference data, such as PO number, to add to the invoice. Maximum length: 60.
| discount                  | JSON  | Optional: The cost as a percent or an amount value. For example, to specify 10%, enter 10. Alternatively, to specify an amount of 5, enter 5.
| shippingCost              | JSON  | Optional: Shipping cost, as a percent or an amount value.
| custom                    | JSON  | Optional: The custom amount to apply to an invoice. If you include a label, you must include a custom amount.
| allowPartialPayment       | String| Optional: Indicates whether the invoice allows a partial payment. If false, invoice must be paid in full. If true, the invoice allows partial payments. Default is false.
| minimumAmountDue          | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)
| taxCalculatedAfterDiscount| String| Optional: Indicates whether the tax is calculated before or after a discount. If false, the tax is calculated before a discount. If true, the tax is calculated after a discount. Default is false.
| taxInclusive              | String| Optional: Indicates whether the unit price includes tax. Default is false.
| terms                     | String| Optional: The general terms of the invoice. Maximum length: 4000.
| note                      | String| Optional: A note to the payer. Maximum length: 4000.
| merchantMemo              | String| Optional: A private bookkeeping memo for the merchant. Maximum length: 150.
| logoUrl                   | String| Optional: The full URL to an external logo image. Maximum length: 4000.
| attachments               | JSON  | Optional: The array of files attached to an invoice or template.

#### Request example
```json
{	"accessToken": "...",
	"merchantInfo": "...",
	"number": "...",
	"templateId": "...",
	"billingInfo": "...",
	"ccInfo": "...",
	"shippingInfo": "...",
	"items": "...",
	"invoiceDate": "...",
	"paymentTerm": "...",
	"reference": "...",
	"discount": "...",
	"shippingCost": "...",
	"custom": "...",
	"allowPartialPayment": "...",
	"minimumAmountDue": "...",
	"taxCalculatedAfterDiscount": "...",
	"taxInclusive": "...",
	"terms": "...",
	"note": "...",
	"merchantMemo": "...",
	"logoUrl": "...",
	"attachments": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="sendInvoice"/>
## Paypal.sendInvoice
Method description

| Field         | Type  | Description
|---------------|-------|----------
| accessToken   | String| Required: accessToken obtained with clientId and secret.
| invoiceId     | String| Required: The ID of the invoice to send.
| notifyMerchant| String| Optional: Indicates whether to send the invoice update notification to the merchant. Default is true.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"notifyMerchant": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updateInvoice"/>
## Paypal.updateInvoice
Method description

| Field                     | Type  | Description
|---------------------------|-------|----------
| accessToken               | String| Required: accessToken obtained with clientId and secret.
| invoiceId                 | String| Required: The ID of the invoice to update.
| merchantInfo              | JSON  | Required: Merchant business information that appears on the invoice.
| notifyMerchant            | String| Optional: Indicates whether to send the invoice update notification to the merchant. Default is true.
| number                    | String| Optional: The unique invoice number. If you omit this number, it is auto-incremented from the previous invoice number. Maximum length: 25.
| templateId                | String| Optional: The ID of the template from which to create the invoice. Useful for copy functionality.
| billingInfo               | JSON  | Optional: Billing information for the invoice recipient.
| ccInfo                    | JSON  | Optional: Participant information.
| shippingInfo              | JSON  | Optional: Shipping information for the invoice recipient.
| items                     | JSON  | Optional: Line item information.
| invoiceDate               | String| Optional: The date when the invoice was enabled. The date format is yyyy-MM-dd z.
| paymentTerm               | JSON  | Optional: The payment term of the invoice. If you specify term_type, you cannot specify due_date, and vice versa.
| reference                 | String| Optional: Reference data, such as PO number, to add to the invoice. Maximum length: 60.
| discount                  | JSON  | Optional: The cost as a percent or an amount value. For example, to specify 10%, enter 10. Alternatively, to specify an amount of 5, enter 5.
| shippingCost              | JSON  | Optional: Shipping cost, as a percent or an amount value.
| custom                    | JSON  | Optional: The custom amount to apply to an invoice. If you include a label, you must include a custom amount.
| allowPartialPayment       | String| Optional: Indicates whether the invoice allows a partial payment. If false, invoice must be paid in full. If true, the invoice allows partial payments. Default is false.
| minimumAmountDue          | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)
| taxCalculatedAfterDiscount| String| Optional: Indicates whether the tax is calculated before or after a discount. If false, the tax is calculated before a discount. If true, the tax is calculated after a discount. Default is false.
| taxInclusive              | String| Optional: Indicates whether the unit price includes tax. Default is false.
| terms                     | String| Optional: The general terms of the invoice. Maximum length: 4000.
| note                      | String| Optional: A note to the payer. Maximum length: 4000.
| merchantMemo              | String| Optional: A private bookkeeping memo for the merchant. Maximum length: 150.
| logoUrl                   | String| Optional: The full URL to an external logo image. Maximum length: 4000.
| attachments               | JSON  | Optional: The array of files attached to an invoice or template.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"merchantInfo": "...",
	"notifyMerchant": "...",
	"number": "...",
	"templateId": "...",
	"billingInfo": "...",
	"ccInfo": "...",
	"shippingInfo": "...",
	"items": "...",
	"invoiceDate": "...",
	"paymentTerm": "...",
	"reference": "...",
	"discount": "...",
	"shippingCost": "...",
	"custom": "...",
	"allowPartialPayment": "...",
	"minimumAmountDue": "...",
	"taxCalculatedAfterDiscount": "...",
	"taxInclusive": "...",
	"terms": "...",
	"note": "...",
	"merchantMemo": "...",
	"logoUrl": "...",
	"attachments": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getInvoice"/>
## Paypal.getInvoice
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| invoiceId  | String| Required: The ID of the invoice to update.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getInvoiceList"/>
## Paypal.getInvoiceList
Method description

| Field             | Type  | Description
|-------------------|-------|----------
| accessToken       | String| Required: accessToken obtained with clientId and secret.
| page              | String| Optional: A zero-relative index of the list of merchant invoices. Default: 1.
| pageSize          | String| Optional: The number of invoices to list beginning with the specified page. Default: 10.
| totalCountRequired| String| Optional: Indicates whether the total count appears in the response. Default is false.

#### Request example
```json
{	"accessToken": "...",
	"page": "...",
	"pageSize": "...",
	"totalCountRequired": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="generateInvoiceNumber"/>
## Paypal.generateInvoiceNumber
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.

#### Request example
```json
{	"accessToken": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="searchInvoice"/>
## Paypal.searchInvoice
Method description

| Field                | Type  | Description
|----------------------|-------|----------
| accessToken          | String| Required: accessToken obtained with clientId and secret.
| email                | String| Optional: The initial letters of the email address.
| recipientFirstName   | String| Optional: The initial letters of the recipient first name.
| recipientLastName    | String| Optional: The initial letters of the recipient last name.
| recipientBusinessName| String| Optional: The initial letters of the recipient business name.
| number               | String| Optional: The invoice number.
| status               | String| Optional: The invoice status. Allowed values: DRAFT, SENT, PAID, MARKED_AS_PAID, CANCELLED, REFUNDED, PARTIALLY_REFUNDED, MARKED_AS_REFUNDED.
| lowerTotalAmount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)
| upperTotalAmount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)
| startInvoiceDate     | String| Optional: The start date for the invoice. Date format is yyyy-MM-dd z.
| endInvoiceDate       | String| Optional: The end date for the invoice. Date format is yyyy-MM-dd z.
| startDueDate         | String| Optional: The start due date for the invoice. Date format is yyyy-MM-dd z.
| endDueDate           | String| Optional: The end due date for the invoice. Date format is yyyy-MM-dd z.
| startPaymentDate     | String| Optional: The start payment date for the invoice. Date format is yyyy-MM-dd z.
| endPaymentDate       | String| Optional: The end payment date for the invoice. Date format is yyyy-MM-dd z.
| startCreationDate    | String| Optional: The start creation date for the invoice. Date format is yyyy-MM-dd z.
| endCreationDate      | String| Optional: The end creation date for the invoice. Date format is yyyy-MM-dd z.
| page                 | String| Optional: The offset for the search results.
| pageSize             | String| Optional: The page size for the search results.
| totalCountRequired   | String| Optional: Indicates whether the total count appears in the response. Default is false.
| archived             | String| Optional: Indicates whether to list merchant-archived invoices in the response. If true, response lists only merchant-archived invoices. If false, response lists only unarchived invoices. If null, response lists all invoices.

#### Request example
```json
{	"accessToken": "...",
	"email": "...",
	"recipientFirstName": "...",
	"recipientLastName": "...",
	"recipientBusinessName": "...",
	"number": "...",
	"status": "...",
	"lowerTotalAmount": "...",
	"upperTotalAmount": "...",
	"startInvoiceDate": "...",
	"endInvoiceDate": "...",
	"startDueDate": "...",
	"endDueDate": "...",
	"startPaymentDate": "...",
	"endPaymentDate": "...",
	"startCreationDate": "...",
	"endCreationDate": "...",
	"page": "...",
	"pageSize": "...",
	"totalCountRequired": "...",
	"archived": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="sendInvoiceReminder"/>
## Paypal.sendInvoiceReminder
Method description

| Field         | Type  | Description
|---------------|-------|----------
| accessToken   | String| Required: accessToken obtained with clientId and secret.
| invoiceId     | String| Required: The ID of the invoice.
| subject       | String| Required: The subject of the notification.
| note          | String| Required: A note to the payer.
| sendToMerchant| String| Required: Indicates whether to send a copy of the email to the merchant. True or false.
| ccEmails      | JSON  | Optional: An array of one or more Cc: emails. 

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"subject": "...",
	"note": "...",
	"sendToMerchant": "...",
	"ccEmails": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteInvoice"/>
## Paypal.deleteInvoice
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| invoiceId  | String| Required: The ID of the invoice.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getQRCode"/>
## Paypal.getQRCode
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| invoiceId  | String| Required: The ID of the invoice.
| width      | String| Optional: The width, in pixels, of the QR code image. Valid value is from 150 to 500. Default is 500.
| height     | String| Optional: The height, in pixels, of the QR code image. Valid value is from 150 to 500. Default is 500.
| action     | String| Optional: The type of URL for which to generate a QR code. Default is pay and is the only supported value.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"width": "...",
	"height": "...",
	"action": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getTemplate"/>
## Paypal.getTemplate
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| templateId | String| Required: The ID of the template for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"templateId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getTemplateList"/>
## Paypal.getTemplateList
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| fields     | String| Optional: The fields to return in the response. Value is all or none. Specify none to return only the template name, ID, and default attributes. Default: all.

#### Request example
```json
{	"accessToken": "...",
	"fields": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createWebProfile"/>
## Paypal.createWebProfile
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| name        | String| Required: Name of the web experience profile. Unique among only the profiles for a given merchant.
| flowConfig  | JSON  | Optional: Parameters for flow configuration.
| inputFields | JSON  | Optional: Parameters for input fields customization.
| presentation| JSON  | Optional: Parameters for style and presentation.

#### Request example
```json
{	"accessToken": "...",
	"name": "...",
	"flowConfig": "...",
	"inputFields": "...",
	"presentation": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getWebProfile"/>
## Paypal.getWebProfile
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| profileId  | String| Required: ID of the profile to retrieve.

#### Request example
```json
{	"accessToken": "...",
	"profileId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getProfileWebList"/>
## Paypal.getProfileWebList
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.

#### Request example
```json
{	"accessToken": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updateWebProfile"/>
## Paypal.updateWebProfile
Method description

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| Required: accessToken obtained with clientId and secret.
| profileId   | String| Required: ID of the profile to update.
| name        | String| Required: Name of the web experience profile. Unique among only the profiles for a given merchant.
| flowConfig  | JSON  | Optional: Parameters for flow configuration.
| inputFields | JSON  | Optional: Parameters for input fields customization.
| presentation| JSON  | Optional: Parameters for style and presentation.

#### Request example
```json
{	"accessToken": "...",
	"profileId": "...",
	"name": "...",
	"flowConfig": "...",
	"inputFields": "...",
	"presentation": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteWebProfile"/>
## Paypal.deleteWebProfile
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| profileId  | String| Required: ID of the profile to update.

#### Request example
```json
{	"accessToken": "...",
	"profileId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createWebhook"/>
## Paypal.createWebhook
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| url        | String| Required: The URL that is configured to listen on localhost for incoming POST notification messages that contain event information.
| eventTypes | JSON  | Required: A list of events.

#### Request example
```json
{	"accessToken": "...",
	"url": "...",
	"eventTypes": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getWebhook"/>
## Paypal.getWebhook
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| webhookId  | String| Required: aThe ID of the webhook for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"webhookId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getWebhookList"/>
## Paypal.getWebhookList
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| anchorType | String| Optional: Filters the response by an entity type, anchor_id. Value is APPLICATION or ACCOUNT. Default is APPLICATION.

#### Request example
```json
{	"accessToken": "...",
	"anchorType": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updateWebhook"/>
## Paypal.updateWebhook
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| webhookId  | String| Required: The ID of the webhook to update.
| items      | JSON  | Required: A JSON patch object that you can use to apply partial updates to resources.

#### Request example
```json
{	"accessToken": "...",
	"webhookId": "...",
	"items": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteWebhook"/>
## Paypal.deleteWebhook
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| webhookId  | String| Required: The ID of the webhook to update.

#### Request example
```json
{	"accessToken": "...",
	"webhookId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getEventNotifications"/>
## Paypal.getEventNotifications
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| eventId    | String| Required: The ID of the webhook event notification for which to show details.

#### Request example
```json
{	"accessToken": "...",
	"eventId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getEventNotificationsList"/>
## Paypal.getEventNotificationsList
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| pageSize     | String| Optional: The number of webhook event notifications to return in the response. Default: 10.
| startTime    | String| Optional: Filters the webhook event notifications in the response to those created on or after this date and time and on or before the endTime value.
| endTime      | String| Optional: Filters the webhook event notifications in the response to those created on or after the startTime and on or before this date and time.
| transactionId| String| Optional: Filters the response to a single transaction, by ID.
| eventType    | String| Optional: Filters the response to a single event.

#### Request example
```json
{	"accessToken": "...",
	"pageSize": "...",
	"startTime": "...",
	"endTime": "...",
	"transactionId": "...",
	"eventType": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="resendEventNotification"/>
## Paypal.resendEventNotification
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| eventId    | String| Required: The ID of the webhook event notification to resend.
| webhookIds | String| Required: A list of webhook account IDs.

#### Request example
```json
{	"accessToken": "...",
	"eventId": "...",
	"webhookIds": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getEventList"/>
## Paypal.getEventList
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.

#### Request example
```json
{	"accessToken": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="getWebhookEventSubscriptionList"/>
## Paypal.getWebhookEventSubscriptionList
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| webhookId  | String| Required: The ID of the webhook for which to list subscriptions.

#### Request example
```json
{	"accessToken": "...",
	"webhookId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="simulateWebhookEvent"/>
## Paypal.simulateWebhookEvent
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| eventType  | String| Required: The event name. Specify one of the subscribed events. For each request, provide only one event.
| webhookId  | String| Optional: The ID of the webhook. If omitted, the URL is required.
| url        | String| Optional: The URL for the webhook endpoint. If omitted, the webhook ID is required.

#### Request example
```json
{	"accessToken": "...",
	"eventType": "...",
	"webhookId": "...",
	"url": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="cancelSentInvoice"/>
## Paypal.cancelSentInvoice
Method description

| Field         | Type  | Description
|---------------|-------|----------
| accessToken   | String| Required: accessToken obtained with clientId and secret.
| invoiceId     | String| Required: The ID of the invoice to cancel.
| subject       | String| Optional: The subject of the notification.
| note          | String| Optional: A note to the payer.
| sendToMerchant| String| Optional: Indicates whether to send the notification to the merchant.
| sendToPayer   | String| Optional: Indicates whether to send the notification to the payer.
| ccEmails      | String| Optional: An array of one or more Cc: emails. If you omit this parameter from the JSON request body, a notification is sent to all Cc: email addresses that are part of the invoice. Otherwise, specify this parameter to limit the email addresses to which a notification is sent.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"subject": "...",
	"note": "...",
	"sendToMerchant": "...",
	"sendToPayer": "...",
	"ccEmails": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="markInvoiceAsPaid"/>
## Paypal.markInvoiceAsPaid
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| invoiceId  | String| Required: The ID of the invoice to cancel.
| method     | String| Required: The payment mode or method. Required with the EXTERNAL payment type. Value is bank transfer, cash, check, credit card, debit card, PayPal, wire transfer, or other. Allowed values: BANK_TRANSFER, CASH, CHECK, CREDIT_CARD, DEBIT_CARD, PAYPAL, WIRE_TRANSFER, OTHER.
| date       | String| Optional: The date when the invoice was paid. The date format is yyyy-MM-dd z
| note       | String| Optional: A note associated with the payment.
| amount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"method": "...",
	"date": "...",
	"note": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="markInvoiceAsRefunded"/>
## Paypal.markInvoiceAsRefunded
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| invoiceId  | String| Required: The ID of the invoice.
| date       | String| Optional: The date when the invoice was paid. The date format is yyyy-MM-dd z
| note       | String| Optional: A note associated with the payment.
| amount     | JSON  | Optional: Base object for all financial value related fields (balance, payment due, etc.)

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"date": "...",
	"note": "...",
	"amount": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteExternalPayment"/>
## Paypal.deleteExternalPayment
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| invoiceId    | String| Required: The ID of the invoice from which to delete a payment transaction.
| transactionId| String| Required: The ID of the payment transaction to delete.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"transactionId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteExternalRefund"/>
## Paypal.deleteExternalRefund
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| invoiceId    | String| Required: The ID of the invoice from which to delete the refund transaction.
| transactionId| String| Required: The ID of the refund transaction to delete.

#### Request example
```json
{	"accessToken": "...",
	"invoiceId": "...",
	"transactionId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="createTemplate"/>
## Paypal.createTemplate
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| name         | String| Required: The template name.
| default      | String| Required: Indicates whether this template is the default merchant template. A merchant can have one default template. True or false
| templateData | JSON  | Required: Detailed template information.
| settings     | JSON  | Required: Template settings.
| unitOfMeasure| JSON  | Required: The unit of measure for the template. Value is quantity, hours, or amount.

#### Request example
```json
{	"accessToken": "...",
	"name": "...",
	"default": "...",
	"templateData": "...",
	"settings": "...",
	"unitOfMeasure": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="deleteTemplate"/>
## Paypal.deleteTemplate
Method description

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: accessToken obtained with clientId and secret.
| templateId | String| Required: The ID of the template to delete.

#### Request example
```json
{	"accessToken": "...",
	"templateId": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="verifyWebhookSignature"/>
## Paypal.verifyWebhookSignature
Method description

| Field           | Type  | Description
|-----------------|-------|----------
| accessToken     | String| Required: accessToken obtained with clientId and secret.
| authAlgo        | String| Required: The algorithm that PayPal uses to generate the signature and that you can use to verify the signature. Extract this value from the PAYPAL-AUTH-ALGO response header, which is received with the webhook notification.
| certUrl         | String| Required: The X.509 public key certificate. Download the certificate from this URL and use it to verify the signature. Extract this value from the PAYPAL-CERT-URL response header, which is received with the webhook notification.
| transmissionId  | String| Required: The ID of the HTTP transmission. Contained in the PAYPAL-TRANSMISSION-ID header of the notification message.
| transmissionSig | String| Required: The PayPal-generated asymmetric signature. Extract this value from the PAYPAL-TRANSMISSION-SIG response header, which is received with the webhook notification.
| transmissionTime| String| Required: The date and time of the HTTP transmission. Contained in the PAYPAL-TRANSMISSION-TIME header of the notification message.
| webhookId       | String| Required: The ID of the webhook as configured in your Developer Portal account.
| webhookEvent    | String| Required: A webhook event notification.

#### Request example
```json
{	"accessToken": "...",
	"authAlgo": "...",
	"certUrl": "...",
	"transmissionId": "...",
	"transmissionSig": "...",
	"transmissionTime": "...",
	"webhookId": "...",
	"webhookEvent": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

<a name="updateTemplate"/>
## Paypal.updateTemplate
Method description

| Field        | Type  | Description
|--------------|-------|----------
| accessToken  | String| Required: accessToken obtained with clientId and secret.
| templateId   | String| Required: The ID of the template to update.
| name         | String| Required: The template name.
| default      | String| Required: Indicates whether this template is the default merchant template. A merchant can have one default template. True or false
| templateData | JSON  | Required: Detailed template information.
| settings     | JSON  | Required: Template settings.
| unitOfMeasure| JSON  | Required: The unit of measure for the template. Value is quantity, hours, or amount.

#### Request example
```json
{	"accessToken": "...",
	"templateId": "...",
	"name": "...",
	"default": "...",
	"templateData": "...",
	"settings": "...",
	"unitOfMeasure": "..."
}
```
#### Response example
```json
{
	"callback":"success",
	"contextWrites":{
		"#":{
			"to":"..."
		}
	}
}
```

