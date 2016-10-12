<?php

$app->post('/api/PayPal/createCreditCard', function ($request, $response, $args) {
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
    if(empty($post_data['args']['number'])) {
        $error[] = 'number cannot be empty';
    }
    if(empty($post_data['args']['type'])) {
        $error[] = 'type cannot be empty';
    }
    if(empty($post_data['args']['expireMonth'])) {
        $error[] = 'expireMonth cannot be empty';
    }
    if(empty($post_data['args']['expireYear'])) {
        $error[] = 'expireYear cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json'; 
    
    if($post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/vault/credit-cards';
    } else {
        $query_str = 'https://api.paypal.com/v1/vault/credit-cards';
    }
    
    $body['number'] = $post_data['args']['number'];
    $body['type'] = $post_data['args']['type'];
    $body['expire_month'] = $post_data['args']['expireMonth'];
    $body['expire_year'] = $post_data['args']['expireYear'];
    if(!empty($post_data['args']['cvv2'])) {
        $body['cvv2'] = $post_data['args']['cvv2'];
    }
    if(!empty($post_data['args']['firstName'])) {
        $body['first_name'] = $post_data['args']['firstName'];
    }
    if(!empty($post_data['args']['lastName'])) {
        $body['last_name'] = $post_data['args']['lastName'];
    }
    if(!empty($post_data['args']['billingAddress'])) {
        $body['billing_address'] = $post_data['args']['billingAddress'];
    }
    if(!empty($post_data['args']['externalCustomerId'])) {
        $body['external_customer_id'] = $post_data['args']['externalCustomerId'];
    }
    if(!empty($post_data['args']['merchantId'])) {
        $body['merchant_id'] = $post_data['args']['merchantId'];
    }
    if(!empty($post_data['args']['payerId'])) {
        $body['payer_id'] = $post_data['args']['payerId'];
    }
    if(!empty($post_data['args']['externalCardId'])) {
        $body['external_card_id'] = $post_data['args']['externalCardId'];
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

