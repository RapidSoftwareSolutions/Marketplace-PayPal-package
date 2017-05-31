<?php

$app->post('/api/PayPal/searchInvoice', function ($request, $response, $args) {
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
        $query_str = 'https://api.sandbox.paypal.com/v1/invoicing/search';
    } else {
        $query_str = 'https://api.paypal.com/v1/invoicing/search';
    }
    
    $body = [];
    if(!empty($post_data['args']['email'])) {
        $body['email'] = $post_data['args']['email'];
    }
    if(!empty($post_data['args']['recipientFirstName'])) {
        $body['recipient_first_name'] = $post_data['args']['recipientFirstName'];
    }
    if(!empty($post_data['args']['recipientLastName'])) {
        $body['recipient_last_name'] = $post_data['args']['recipientLarstName'];
    }
    if(!empty($post_data['args']['recipientBusinessName'])) {
        $body['recipient_business_name'] = $post_data['args']['recipientBusinessName'];
    }
    if(!empty($post_data['args']['number'])) {
        $body['number'] = $post_data['args']['number'];
    }
    if(!empty($post_data['args']['status'])) {
        $body['status'] = $post_data['args']['status'];
    }
    if(!empty($post_data['args']['lowerTotalAmount'])) {
        $body['lower_total_amount'] = $post_data['args']['lowerTotalAmount'];
    }
    if(!empty($post_data['args']['upperTotalAmount'])) {
        $body['upper_total_amount'] = $post_data['args']['upperTotalAmount'];
    }
    if(!empty($post_data['args']['startInvoiceDate'])) {
        $date =  new DateTime($post_data['args']['startInvoiceDate']);
        $body['start_invoice_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['endInvoiceDate'])) {
        $date =  new DateTime($post_data['args']['endInvoiceDate']);
        $body['end_invoice_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['startDueDate'])) {
        $date =  new DateTime($post_data['args']['startDueDate']);
        $body['start_due_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['endDueDate'])) {
        $date =  new DateTime($post_data['args']['endDueDate']);
        $body['end_due_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['startPaymentDate'])) {
        $date =  new DateTime($post_data['args']['startPaymentDate']);
        $body['start_payment_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['endPaymentDate'])) {
        $date =  new DateTime($post_data['args']['endPaymentDate']);
        $body['end_payment_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['startCreationDate'])) {
        $date =  new DateTime($post_data['args']['startCreationDate']);
        $body['start_creation_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['endCreationDate'])) {
        $date =  new DateTime($post_data['args']['endCreationDate']);
        $body['end_creation_date'] = $date->format('Y-m-d\TH:i:s\Z');
    }
    if(!empty($post_data['args']['page'])) {
        $body['page'] = $post_data['args']['page'];
    }
    if(!empty($post_data['args']['pageSize'])) {
        $body['page_size'] = $post_data['args']['pageSize'];
    }
    if(!empty($post_data['args']['totalCountRequired'])) {
        $body['total_count_required'] = $post_data['args']['totalCountRequired'];
    }
    if(!empty($post_data['args']['archived'])) {
        $body['archived'] = $post_data['args']['archived'];
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

