<?php
// api/src/Swagger/SwaggerDecorator.php

namespace App\Swagger;

use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Response;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

  
        $docs['paths']['/asset']['get'] = [
            'tags' => ['teste'],
            'operationId' => 'teste',
            'summary' => 'Teste Menu',
            'parameters' => [

            ],
            'responses' => [
                Response::HTTP_OK => [
                    'description' => 'Sucesso',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'default' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object'
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        
    
        return $docs;

    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function getSupportedTypes($format)
    {
        return [OpenApi::class => true];
    }
}
