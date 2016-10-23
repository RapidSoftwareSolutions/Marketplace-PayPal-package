<?php

$app->post('/api/PayPal/createTokenFromRefreshToken', function ($request, $response, $args) {
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
    if(empty($post_data['args']['refreshToken'])) {
        $error[] = 'refreshToken cannot be empty';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    
    $auth = [$post_data['args']['clientId'], $post_data['args']['secret']];
    
    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://api.sandbox.paypal.com/v1/identity/tokenservice';
    } else {
        $query_str = 'https://api.paypal.com/v1/identity/tokenservice';
    }
    
    $query['grant_type'] = $post_data['args']['grantType'];
    $query['refresh_token'] = $post_data['args']['refreshToken'];
    if(!empty($post_data['args']['scope'])) {
        $query['scope'] = $post_data['args']['scope'];
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
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

/*curl https://api.sandbox.paypal.com/v1/identity/openidconnect/tokenservice \
  -u "Ae7QFDaWoKwglHXmgL133-4B1o4J5BfXw0HKL3SNJumVxhDMpL9VOvsZh-oA5Pc_PoexgzkSeO1Q95XI:EAym3vWLEpSciyTuwCtQjRG8ByrhgWqyCx0piYrjcRooJPW-tRnya8Twpryb9OV4v074uSIimTm9MYlB" \
  -d grant_type=authorization_code \
  -d code=Authorization-Code"

 */
