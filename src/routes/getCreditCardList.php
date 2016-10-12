<?php

$app->post('/api/PayPal/getCreditCardList', function ($request, $response, $args) {
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
    
    $query = [];
    if(!empty($post_data['args']['pageSize'])) {
        $query['page_size'] = $post_data['args']['pageSize'];
    }
    if(!empty($post_data['args']['page'])) {
        $query['page'] = $post_data['args']['page'];
    }
    if(!empty($post_data['args']['startTime'])) {
        $query['start_time'] = $post_data['args']['startTime'];
    }
    if(!empty($post_data['args']['endTime'])) {
        $query['end_time'] = $post_data['args']['endTime'];
    }
    if(!empty($post_data['args']['sortOrder'])) {
        $query['sort_order'] = $post_data['args']['sortOrder'];
    }
    if(!empty($post_data['args']['sortBy'])) {
        $query['sort_by'] = $post_data['args']['sortBy'];
    }
    if(!empty($post_data['args']['merchantId'])) {
        $query['merchant_id'] = $post_data['args']['merchantId'];
    }
    if(!empty($post_data['args']['externalCardId'])) {
        $query['external_card_id'] = $post_data['args']['externalCardId'];
    }
    if(!empty($post_data['args']['externalCustomerId'])) {
        $query['external_customer_id'] = $post_data['args']['externalCustomerId'];
    }
    if(!empty($post_data['args']['totalRequired'])) {
        $query['total_required'] = $post_data['args']['totalRequired'];
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->get( $query_str, 
            [
                'headers' => $headers,
                'query' => $query
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

