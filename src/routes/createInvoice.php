<?php

$app->post('/api/PayPal/createInvoice', function ($request, $response, $args) {
    $settings =  $this->settings;
    
    $data = $request->getBody();

    if($data=='') {
        $post_data = $request->getParsedBody();
    } else {
        $toJson = $this->toJson;
        $data = $toJson->normalizeJson($data); 
        $data = str_replace('\"', '"', $data);
        $post_data = json_decode($data, true);
    }
    
    if(json_last_error() != 0) {
        $error[] = json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
        
    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken is required';
    }
    if(empty($post_data['args']['merchantInfo'])) {
        $error[] = 'merchantInfo is required';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['message'] = "There are incomplete fields in your request";
        $result['contextWrites']['to']['fields'] = $error;
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json';
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/invoicing/invoices';
    } else {
        $query_str = 'https://api.paypal.com/v1/invoicing/invoices';
    }
    
    $body['merchant_info'] = $post_data['args']['merchantInfo'];
    if(!empty($post_data['args']['number'])) {
        $body['number'] = $post_data['args']['number'];
    }
    if(!empty($post_data['args']['templateId'])) {
        $body['template_id'] = $post_data['args']['templateId'];
    }
    if(!empty($post_data['args']['billingInfo'])) {
        $body['billing_info'] = $post_data['args']['billingInfo'];
    }
    if(!empty($post_data['args']['ccInfo'])) {
        $body['cc_info'] = $post_data['args']['ccInfo'];
    }
    if(!empty($post_data['args']['shippingInfo'])) {
        $body['shipping_info'] = $post_data['args']['shippingInfo'];
    }
    if(!empty($post_data['args']['items'])) {
        $body['items'] = $post_data['args']['items'];
    }
    if(!empty($post_data['args']['invoiceDate'])) {
        $body['invoice_date'] = $post_data['args']['invoiceDate'];
    }
    if(!empty($post_data['args']['paymentTerm'])) {
        $body['payment_term'] = $post_data['args']['paymentTerm'];
    }
    if(!empty($post_data['args']['reference'])) {
        $body['reference'] = $post_data['args']['reference'];
    }
    if(!empty($post_data['args']['discount'])) {
        $body['discount'] = $post_data['args']['discount'];
    }
    if(!empty($post_data['args']['shippingCost'])) {
        $body['shipping_cost'] = $post_data['args']['shippingCost'];
    }
    if(!empty($post_data['args']['custom'])) {
        $body['custom'] = $post_data['args']['custom'];
    }
    if(!empty($post_data['args']['allowPartialPayment'])) {
        $body['allow_partial_payment'] = $post_data['args']['allowPartialPayment'];
    }
    if(!empty($post_data['args']['minimumAmountDue'])) {
        $body['minimum_amount_due'] = $post_data['args']['minimumAmountDue'];
    }
    if(!empty($post_data['args']['taxCalculatedAfterDiscount'])) {
        $body['tax_calculated_after_discount'] = $post_data['args']['taxCalculatedAfterDiscount'];
    }
    if(!empty($post_data['args']['taxInclusive'])) {
        $body['tax_inclusive'] = $post_data['args']['taxInclusive'];
    }
    if(!empty($post_data['args']['terms'])) {
        $body['terms'] = $post_data['args']['terms'];
    }
    if(!empty($post_data['args']['note'])) {
        $body['note'] = $post_data['args']['note'];
    }
    if(!empty($post_data['args']['merchantMemo'])) {
        $body['merchant_memo'] = $post_data['args']['merchantMemo'];
    }
    if(!empty($post_data['args']['logoUrl'])) {
        $body['logo_url'] = $post_data['args']['logoUrl'];
    }
    if(!empty($post_data['args']['attachments'])) {
        $body['attachments'] = $post_data['args']['attachments'];
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'json' => $body
            ]);
        $responseBody = $resp->getBody()->getContents();
        $code = $resp->getStatusCode();
        
        if(in_array($code, ['200','201','202','203','204'])) { 
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\BadResponseException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    }  

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});

