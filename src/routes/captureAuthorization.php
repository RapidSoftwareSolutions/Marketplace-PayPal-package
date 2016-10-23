<?php

$app->post('/api/PayPal/captureAuthorization', function ($request, $response, $args) {
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
    if(empty($post_data['args']['authorizationId'])) {
        $error[] = 'authorizationId cannot be empty';
    }

    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json'; 
    
    $body = [];
    if(!empty($post_data['args']['amount'])) {
        $body['amount'] = $post_data['args']['amount'];
    }
    if(!empty($post_data['args']['isFinalCapture'])) {
        $body['is_final_capture'] = $post_data['args']['isFinalCapture'];
    }
    if(!empty($post_data['args']['invoiceNumber'])) {
        $body['invoice_number'] = $post_data['args']['invoiceNumber'];
    }
    
    
    if($post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/payments/authorization/'.$post_data['args']['authorizationId'].'/capture';
    } else {
        $query_str = 'https://api.paypal.com/v1/payments/authorization/'.$post_data['args']['authorizationId'].'/capture';
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'json'=> $body
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
        $result['contextWrites']['to'] = json_encode(json_decode($responseBody));

    } catch (\GuzzleHttp\Exception\RequestException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $code = $exception->getCode();
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_encode(json_decode($responseBody));

    }  

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
