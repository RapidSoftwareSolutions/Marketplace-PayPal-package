<?php

$app->post('/api/PayPal/getCreditCardList', function ($request, $response, $args) {
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
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['message'] = "There are incomplete fields in your request";
        $result['contextWrites']['to']['fields'] = $error;
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json'; 
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
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
        $date =  new DateTime($post_data['args']['startTime']);
        $query['start_time'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['endTime'])) {
        $date =  new DateTime($post_data['args']['endTime']);
        $query['end_time'] = $date->format('Y-m-d\TH:i:s\Z');
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

