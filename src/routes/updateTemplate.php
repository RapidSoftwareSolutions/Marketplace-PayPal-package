<?php

$app->post('/api/PayPal/updateTemplate', function ($request, $response, $args) {
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
    if(empty($post_data['args']['templateId'])) {
        $error[] = 'templateId is required';
    }
    if(empty($post_data['args']['name'])) {
        $error[] = 'name is required';
    }
    if(empty($post_data['args']['default'])) {
        $error[] = 'default is required';
    }
    if(empty($post_data['args']['templateData'])) {
        $error[] = 'templateData is required';
    }
    if(empty($post_data['args']['settings'])) {
        $error[] = 'settings is required';
    }
    if(empty($post_data['args']['unitOfMeasure'])) {
        $error[] = 'unitOfMeasure is required';
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

