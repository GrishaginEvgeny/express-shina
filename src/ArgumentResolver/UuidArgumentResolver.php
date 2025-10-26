<?php

namespace App\ArgumentResolver;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Uid\Uuid;

#[AsTaggedItem(index: 'uuid_resolver', priority: 150)]
class UuidArgumentResolver implements ValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Uuid::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $paramName = $argument->getName();
        $controllerName = $argument->getControllerName();
        $value = $request->query->get($paramName);

        if (!$value) {
            yield null;
            return;
        }

        try {
            yield new Uuid($value);
        } catch (\Exception) {
            throw new \InvalidArgumentException(sprintf(
                'Неправильный формат uuid для %s::%s, значение: %s',
                $paramName,
                $controllerName,
                $value,
            ));
        }
    }
}
