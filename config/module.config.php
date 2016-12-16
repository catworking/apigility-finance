<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityFinance\V1\Rest\Ledger\LedgerResource::class => \ApigilityFinance\V1\Rest\Ledger\LedgerResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-finance.rest.ledger' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/finance/ledger[/:ledger_id]',
                    'defaults' => [
                        'controller' => 'ApigilityFinance\\V1\\Rest\\Ledger\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-finance.rest.ledger',
        ],
    ],
    'zf-rest' => [
        'ApigilityFinance\\V1\\Rest\\Ledger\\Controller' => [
            'listener' => \ApigilityFinance\V1\Rest\Ledger\LedgerResource::class,
            'route_name' => 'apigility-finance.rest.ledger',
            'route_identifier_name' => 'ledger_id',
            'collection_name' => 'ledger',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
                1 => 'account',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityFinance\V1\Rest\Ledger\LedgerEntity::class,
            'collection_class' => \ApigilityFinance\V1\Rest\Ledger\LedgerCollection::class,
            'service_name' => 'Ledger',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityFinance\\V1\\Rest\\Ledger\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilityFinance\\V1\\Rest\\Ledger\\Controller' => [
                0 => 'application/vnd.apigility-finance.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilityFinance\\V1\\Rest\\Ledger\\Controller' => [
                0 => 'application/vnd.apigility-finance.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilityFinance\V1\Rest\Ledger\LedgerEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-finance.rest.ledger',
                'route_identifier_name' => 'ledger_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityFinance\V1\Rest\Ledger\LedgerCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-finance.rest.ledger',
                'route_identifier_name' => 'ledger_id',
                'is_collection' => true,
            ],
        ],
    ],
];
