<?php

$app->post('/api/PayPal/sendInvoiceReminder', function ($request, $response, $args) {
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
    if(empty($post_data['args']['invoiceId'])) {
        $error[] = 'invoiceId cannot be empty';
    }
    if(empty($post_data['args']['subject'])) {
        $error[] = 'subject cannot be empty';
    }
    if(empty($post_data['args']['note'])) {
        $error[] = 'note cannot be empty';
    }
    if(empty($post_data['args']['sendToMerchant'])) {
        $error[] = 'note cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json';
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/invoicing/invoices/'.$post_data['args']['invoiceId'].'/remind';
    } else {
        $query_str = 'https://api.paypal.com/v1/invoicing/invoices/'.$post_data['args']['invoiceId'].'/remind';
    }
    
    $body['subject'] = $post_data['args']['subject'];
    $body['note'] = $post_data['args']['note'];
    $body['send_to_merchant'] = $post_data['args']['sendToMerchant'];
    if(!empty($post_data['args']['ccEmails'])) {
        $body['cc_emails'] = $post_data['args']['ccEmails'];
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

