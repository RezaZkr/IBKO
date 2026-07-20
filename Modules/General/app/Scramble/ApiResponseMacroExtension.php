<?php

namespace Modules\General\Scramble;

use Dedoc\Scramble\Infer\Extensions\Event\MethodCallEvent;
use Dedoc\Scramble\Infer\Extensions\MethodReturnTypeExtension;
use Dedoc\Scramble\Support\Type\ArrayItemType_;
use Dedoc\Scramble\Support\Type\ArrayType;
use Dedoc\Scramble\Support\Type\Generic;
use Dedoc\Scramble\Support\Type\KeyedArrayType;
use Dedoc\Scramble\Support\Type\Literal\LiteralBooleanType;
use Dedoc\Scramble\Support\Type\Literal\LiteralIntegerType;
use Dedoc\Scramble\Support\Type\ObjectType;
use Dedoc\Scramble\Support\Type\StringType;
use Dedoc\Scramble\Support\Type\Type;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

class ApiResponseMacroExtension implements MethodReturnTypeExtension
{
    public function shouldHandle(ObjectType $type): bool
    {
        return $type->isInstanceOf(ResponseFactory::class);
    }

    public function getMethodReturnType(MethodCallEvent $event): ?Type
    {
        return match ($event->getName()) {
            'success' => $this->success($event),
            'error' => $this->error($event),
            default => null,
        };
    }

    protected function success(MethodCallEvent $event): Type
    {
        return new Generic(JsonResponse::class, [
            new KeyedArrayType([
                new ArrayItemType_('success', new LiteralBooleanType(true)),
                new ArrayItemType_('message', new StringType()),
                new ArrayItemType_('data', $event->getArg('data', 1, new KeyedArrayType([]))),
            ]),
            $this->resolveStatus($event, 200),
            new ArrayType(),
        ]);
    }

    protected function error(MethodCallEvent $event): Type
    {
        return new Generic(JsonResponse::class, [
            new KeyedArrayType([
                new ArrayItemType_('success', new LiteralBooleanType(false)),
                new ArrayItemType_('message', new StringType()),
                new ArrayItemType_('errors', $event->getArg('errors', 1, new ArrayType())),
            ]),
            $this->resolveStatus($event, 500),
            new ArrayType(),
        ]);
    }

    protected function resolveStatus(MethodCallEvent $event, int $default): Type
    {
        $status = $event->getArg('status', 2, new LiteralIntegerType($default));

        return $status instanceof LiteralIntegerType ? $status : new LiteralIntegerType($default);
    }


}
