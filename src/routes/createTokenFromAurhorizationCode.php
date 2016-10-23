<?php

$app->post('/api/PayPal/createTokenFromAurhorizationCode', function ($request, $response, $args) {
    $settings =  $this->settings;
    
    $data = $request->getBody();
    $post_data = json_decode($data, true);
    if(!isset($post_data['args'])) {
        $data = $request->getParsedBody();
        $post_data = $data;
    }
        
    $error = [];
    if(empty($post_data['args']['clientId'])) {
        $error[] = 'clientId cannot be empty';
    }
    if(empty($post_data['args']['secret'])) {
        $error[] = 'secret cannot be empty';
    }
    if(empty($post_data['args']['grantType'])) {
        $error[] = 'grantType cannot be empty';
    }
    if(empty($post_data['args']['code'])) {
        $error[] = 'code cannot be empty';
    }
    if(empty($post_data['args']['redirectUri'])) {
        $error[] = 'redirect_uri cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Content-Type'] = 'application/json'; 
    $auth = [$post_data['args']['clientId'], $post_data['args']['secret']];
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/identity/tokenservice';
    } else {
        $query_str = 'https://api.paypal.com/v1/identity/tokenservice';
    }
    
    $query['grant_type'] = $post_data['args']['grantType'];
    $query['code'] = $post_data['args']['code'];
    $query['redirect_uri'] = $post_data['args']['redirectUri'];
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'auth' => $auth,
                'query' => $query,
                'allow_redirects' => false
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

