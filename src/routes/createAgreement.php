<?php

$app->post('/api/PayPal/createAgreement', function ($request, $response, $args) {
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
    if(empty($post_data['args']['name'])) {
        $error[] = 'name is required';
    }
    if(empty($post_data['args']['description'])) {
        $error[] = 'description is required';
    }
    if(empty($post_data['args']['startDate'])) {
        $error[] = 'startDate is required';
    }
    if(empty($post_data['args']['payer'])) {
        $error[] = 'payer is required';
    }
    if(empty($post_data['args']['plan'])) {
        $error[] = 'plan is required';
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

