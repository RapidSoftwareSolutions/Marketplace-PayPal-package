<?php
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

$app->post('/api/PayPal/getAccessToken', function ($request, $response, $args) {
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
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Content-Type'] = 'application/x-www-form-urlencoded'; 
    $auth = [$post_data['args']['clientId'], $post_data['args']['secret']];

    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/oauth2/token';
    } else {
        $query_str = 'https://api.paypal.com/v1/oauth2/token';
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'auth' => $auth,
                'form_params' => [
                    'grant_type' => $post_data['args']['grantType']
                ],
                'verify' => false
            ]);
        $responseBody = $resp->getBody()->getContents();
        $code = $resp->getStatusCode();
        $res = json_decode($responseBody);
        
        if($code == '200') { 
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_encode($res);   
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to'] = json_encode($res);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_encode(json_decode($responseBody));

    }
    
    

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});

