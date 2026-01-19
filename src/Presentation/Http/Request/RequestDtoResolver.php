<?php

declare(strict_types=1);

namespace App\Presentation\Http\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class RequestDtoResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if ($type === null) {
            return [];
        }

        if (!class_exists($type)) {
            return [];
        }

        if (!str_starts_with($type, 'App\\Presentation\\Http\\Request\\')) {
            return [];
        }

        yield $this->serializer->deserialize(
            $request->getContent(),
            $type,
            'json'
        );
    }
}
