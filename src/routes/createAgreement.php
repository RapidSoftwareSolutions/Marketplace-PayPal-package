<?php

$app->post('/api/PayPal/createAgreement', function ($request, $response, $args) {
    $settings =  $this->settings;
    
    $data = $request->getBody();
    $post_data = json_decode($data, true);
    if(!isset($post_data['args'])) {
        $data = $request->getParsedBody();
        $post_data = $data;
    }
        
    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken cannot be empty';
    }
    if(empty($post_data['args']['name'])) {
        $error[] = 'name cannot be empty';
    }
    if(empty($post_data['args']['description'])) {
        $error[] = 'description cannot be empty';
    }
    if(empty($post_data['args']['startDate'])) {
        $error[] = 'startDate cannot be empty';
    }
    if(empty($post_data['args']['payer'])) {
        $error[] = 'payer cannot be empty';
    }
    if(empty($post_data['args']['plan'])) {
        $error[] = 'plan cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json'; 
    
    if($post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/payments/billing-agreements';
    } else {
        $query_str = 'https://api.paypal.com/v1/payments/billing-agreements';
    }
    
    $body['name'] = $post_data['args']['name'];
    $body['description'] = $post_data['args']['description'];
    $body['start_date'] = $post_data['args']['startDate'];
    $body['payer'] = $post_data['args']['payer'];
    $body['plan'] = $post_data['args']['plan'];
    
    if(!empty($post_data['args']['overrideChargeModels'])) {
        $query['override_charge_models'] = $post_data['args']['overrideChargeModels'];
    }
    if(!empty($post_data['args']['agreementDetails'])) {
        $query['agreement_details'] = $post_data['args']['agreementDetails'];
    }
    if(!empty($post_data['args']['shippingAddress'])) {
        $query['shipping_address'] = $post_data['args']['shippingAddress'];
    }
    if(!empty($post_data['args']['overrideMerchantPreferences'])) {
        $query['override_merchant_preferences'] = $post_data['args']['overrideMerchantPreferences'];
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
        $res = json_decode($responseBody);
        
        if(in_array($code, ['200','201','202','203','204'])) { 
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_encode($res);   
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to'] = json_encode($res);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $code = $exception->getCode();
        $result['callback'] = 'error';
        $result['contextWrites']['code'] = $code;
        $result['contextWrites']['to'] = json_encode(json_decode($responseBody));

    } catch (\GuzzleHttp\Exception\RequestException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $code = $exception->getCode();
        $result['callback'] = 'error';
        $result['contextWrites']['code'] = $code;
        $result['contextWrites']['to'] = json_encode(json_decode($responseBody));

    }  

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});

