<?php

$app->post('/api/PayPal/verifyWebhookSignature', function ($request, $response, $args) {
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
        
    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken cannot be empty';
    }
    if(empty($post_data['args']['authAlgo'])) {
        $error[] = 'authAlgo cannot be empty';
    }
    if(empty($post_data['args']['certUrl'])) {
        $error[] = 'certUrl cannot be empty';
    }
    if(empty($post_data['args']['transmissionId'])) {
        $error[] = 'transmissionId cannot be empty';
    }
    if(empty($post_data['args']['transmissionSig'])) {
        $error[] = 'transmissionSig cannot be empty';
    }
    if(empty($post_data['args']['transmissionTime'])) {
        $error[] = 'transmissionTime cannot be empty';
    }
    if(empty($post_data['args']['webhookId'])) {
        $error[] = 'webhookId cannot be empty';
    }
    if(empty($post_data['args']['webhookEvent'])) {
        $error[] = 'webhookEvent cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json';
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/notifications/verify-webhook-signature';
    } else {
        $query_str = 'https://api.paypal.com/v1/notifications/verify-webhook-signature';
    }
    
    $body['auth_algo'] = $post_data['args']['authAlgo'];
    $body['cert_url'] = $post_data['args']['certUrl'];
    $body['transmission_id'] = $post_data['args']['transmissionId'];
    $body['transmission_sig'] = $post_data['args']['transmissionSig'];
    $body['transmission_time'] = $post_data['args']['transmissionTime'];
    $body['webhook_id'] = $post_data['args']['webhookId'];
    $body['webhook_event'] = $post_data['args']['webhookEvent'];
    
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

