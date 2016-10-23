<?php

$app->post('/api/PayPal/updateTemplate', function ($request, $response, $args) {
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
    if(empty($post_data['args']['templateId'])) {
        $error[] = 'templateId cannot be empty';
    }
    if(empty($post_data['args']['name'])) {
        $error[] = 'name cannot be empty';
    }
    if(empty($post_data['args']['default'])) {
        $error[] = 'default cannot be empty';
    }
    if(empty($post_data['args']['templateData'])) {
        $error[] = 'templateData cannot be empty';
    }
    if(empty($post_data['args']['settings'])) {
        $error[] = 'settings cannot be empty';
    }
    if(empty($post_data['args']['unitOfMeasure'])) {
        $error[] = 'unitOfMeasure cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json';
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/invoicing/templates/'.$post_data['args']['templateId'];
    } else {
        $query_str = 'https://api.paypal.com/v1/invoicing/invoicing/templates/'.$post_data['args']['templateId'];
    }
    
    $body['name'] = $post_data['args']['name'];
    $body['default'] = $post_data['args']['default'];
    $body['template_data'] = $post_data['args']['templateData'];
    $body['settings'] = $post_data['args']['settings'];
    $body['unit_of_measure'] = $post_data['args']['unitOfMeasure'];
    
    $client = $this->httpClient;

    try {

        $resp = $client->put( $query_str, 
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

