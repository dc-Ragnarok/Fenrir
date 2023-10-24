<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Mapping;

use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;
use Throwable;

class Mapper
{
    public function map(mixed $source, string $definition): CompletedMapping
    {
        if (is_object($source)) {
            return $this->mapFromObject($source, $definition);
        }

        try {
            $constructorArgs = is_array($source) ? $source : [$source];
            $instance = new $definition(...$constructorArgs);

            return new CompletedMapping($instance, []);
        } catch (Throwable $e) {
            return new CompletedMapping(null, [
                new MappingException('Unable to instantiate property', '', $definition, $e)
            ]);
        }
    }

    private function mapFromObject(mixed $source, string $definition): CompletedMapping
    {
        $reflection = new ReflectionClass($definition);
        $instance = new $definition();

        $errors = [];
        $data = get_object_vars($source);

        foreach ($data as $key => $value) {
            try {
                $this->setProperty(
                    $value,
                    $reflection->getProperty($key),
                    $instance,
                    $errors
                );
            } catch (ReflectionException $e) {
                $errors[] = new MappingException('Property does not exist on definition', $key, $definition, $e);
            }
        }

        return new CompletedMapping($instance, $errors);
    }

    private function setProperty(
        mixed $value,
        ReflectionProperty $reflectionProperty,
        mixed &$instance,
        array &$errors,
    ) {
        $type = $reflectionProperty->getType();

        /**
         * Union types will only be used for primitive union types, thus typing of source data should match allowed
         */
        if ($type instanceof ReflectionUnionType || is_null($type)) {
            try {
                $reflectionProperty->setValue($instance, $value);
            } catch (Throwable $e) {
                $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
            }

            return;
        }

        /**
         * IntersecionType is not used
         * e.g. TypeA&TypeB
         */
        if ($type instanceof ReflectionIntersectionType) {
            $errors[] = new MappingException('Unsupported typing', $reflectionProperty->getName(), get_class($instance));
        }

        if (($type instanceof ReflectionNamedType && $type->isBuiltin())) {
            if ($type->getName() === 'array') {
                if (!is_array($value)) {
                    $errors[] = new MappingException('Unable to map non-array to array', $reflectionProperty->getName(), get_class($instance));
                    return;
                }

                $attributes = $reflectionProperty->getAttributes(ArrayMapping::class);

                /**
                 * Only arrays with a custom type should use the attribute
                 */
                $arrayValue = count($attributes) > 0
                    ? $this->mapArray($value, array_pop($attributes)->newInstance(), $errors)
                    : $value;

                try {
                    $reflectionProperty->setValue($instance, $arrayValue);
                } catch (Throwable $e) {
                    $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
                }

                return;
            }

            try {
                $reflectionProperty->setValue($instance, $value);
            } catch (Throwable $e) {
                $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
            }

            return;
        }

        $typeName = $type->getName();

        if (enum_exists($typeName)) {
            try {
                $reflectionProperty->setValue($instance, $typeName::tryFrom($value));
            } catch (Throwable $e) {
                $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
            }

            return;
        }

        if (class_exists($typeName)) {
            $mappedValue = $this->map($value, $typeName);

            $errors = [...$errors, ...$mappedValue->errors];

            try {
                $reflectionProperty->setValue($instance, $mappedValue->result);
            } catch (Throwable $e) {
                $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
            }

            return;
        }

        $errors[] = new MappingException('Unsupported typing', $reflectionProperty->getName(), get_class($instance));
    }

    private function mapArray(array $values, ArrayMapping $arrayMapping, array &$errors)
    {
        $new = [];

        foreach ($values as $key => $value) {
            $completedMapping = $this->map($value, $arrayMapping->definition);

            $errors = [...$errors, ...$completedMapping->errors];
            $new[$key] = $completedMapping->result;
        }

        return $new;
    }
}
