<?php

namespace Fishapi;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\GrantType\ClientCredentials;

class Client extends GuzzleClient {

  private function __construct() {
  }

  static function getClient() {
    $stack = HandlerStack::create();

    $basicClient = new GuzzleClient([
      'base_uri' => getenv('API_TOKEN_URL'),
    ]);

    $grantType = new ClientCredentials($basicClient, [
      'client_id' => getenv('API_CLIENT_ID'),
      'client_secret' => getenv('API_CLIENT_SECRET')
    ]);
    $oauth = new OAuth2Middleware($grantType);
    $stack->push($oauth);

    return new GuzzleClient([
      'handler' => $stack,
      'auth' => 'oauth',
      'headers' => ['Accept' => 'application/json'],
      'base_uri' => getenv('API_BASE_URL')
    ]);
  }

}
