<?php

use Fishapi\Client;

include_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = Client::getClient();

$date = new \DateTime("now", new \DateTimeZone("UTC"));

$report = [
  'companyNumber' => getenv('ORG_NUMBER'),
  'companyName' => 'Mikkelvik',
  'reporter' => [
    'firstName' => 'Erik',
    'lastName' => 'Seifert',
    'email' => 'erik.seifert@b-connect.de',
    'externalId' => 'erik.seifert@b-connect.de',
    'phone' => '+49 030 217 36 30',
  ],
  'trips' => [
    [
      'tripDate' => gmdate("Y-m-d\TH:i:s\Z"),
      'catches' => [[
        'speciesIdentifier' => '2202',
        'caughtAmount' => 2,
        'releasedAmount' => 1,
        'weightInGram' => 200
      ]],
      'tripRegistrationSource' => '1000'
    ]
  ]
];

$response = $client->post('reports', ['json' => $report ]);

print_r($response->getBody()->getContents());
