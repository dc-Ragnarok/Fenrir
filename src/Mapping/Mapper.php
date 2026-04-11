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
    /**
     * @var ReflectionClass[]
     */
    private array $reflectionClasses = [];

    /**
     * @var ReflectionProperty[]
     */
    private array $reflectionProperties = [];

    /**
     * @var (ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null)[]
     */
    private array $reflectionTypes = [];

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

    private function mapFromObject(object $source, string $definition): CompletedMapping
    {
        $instance = new $definition();

        $errors = [];
        $data = get_object_vars($source);

        foreach ($data as $key => $value) {
            try {
                $this->setProperty(
                    $source,
                    $value,
                    $this->getReflectionProperty($definition, $key),
                    $this->getReflectionType($definition, $key),
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
        object $source,
        mixed $value,
        ReflectionProperty $reflectionProperty,
        ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null $reflectionType,
        mixed &$instance,
        array &$errors,
    ): void {
        /**
         * Typing should match for Union Types & non-set types
         */
        if ($reflectionType instanceof ReflectionUnionType || is_null($reflectionType)) {
            $this->setFlat($reflectionProperty, $instance, $value, $errors);
            return;
        }

        /**
         * IntersecionType is not used
         * e.g. TypeA&TypeB
         */
        if ($reflectionType instanceof ReflectionIntersectionType) {
            $errors[] = new MappingException('Unsupported typing', $reflectionProperty->getName(), get_class($instance));
            return;
        }

        /**
         * Scalar types
         */
        if (($reflectionType instanceof ReflectionNamedType && $reflectionType->isBuiltin())) {
            $this->setNamedType($source, $reflectionProperty, $reflectionType, $instance, $value, $errors);
            return;
        }

        $typeName = $reflectionType->getName();

        if (enum_exists($typeName)) {
            $this->setEnum($reflectionProperty, $instance, $value, $typeName, $errors);
            return;
        }

        if (class_exists($typeName)) {
            $this->setClass($reflectionProperty, $instance, $value, $typeName, $errors);
            return;
        }

        $errors[] = new MappingException('Unsupported typing', $reflectionProperty->getName(), get_class($instance));
    }

    private function setFlat(
        ReflectionProperty $reflectionProperty,
        mixed &$instance,
        mixed $value,
        array &$errors,
    ): void {
        try {
            $reflectionProperty->setValue($instance, $value);
        } catch (Throwable $e) {
            $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
        }

        return;
    }

    private function setNamedType(
        object $source,
        ReflectionProperty $reflectionProperty,
        ReflectionNamedType $type,
        mixed &$instance,
        mixed $value,
        array &$errors,
    ): void {
        if ($type->getName() === 'array') {
            $this->setArray($source, $reflectionProperty, $instance, $value, $errors);

            return;
        }

        try {
            $reflectionProperty->setValue($instance, $value);
        } catch (Throwable $e) {
            $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
        }

        return;
    }

    private function setArray(
        object $source,
        ReflectionProperty $reflectionProperty,
        mixed &$instance,
        mixed $value,
        array &$errors,
    ): void {
        if (!is_array($value)) {
            $errors[] = new MappingException('Unable to map non-array to array', $reflectionProperty->getName(), get_class($instance));
            return;
        }

        $attributes = $reflectionProperty->getAttributes(ArrayMapping::class);

        /**
         * Only arrays with a custom type should use the attribute
         */
        $arrayValue = count($attributes) > 0
            ? $this->mapArray($source, $value, array_pop($attributes)->newInstance(), $errors)
            : $value;

        try {
            $reflectionProperty->setValue($instance, $arrayValue);
        } catch (Throwable $e) {
            $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
        }
    }

    private function setEnum(
        ReflectionProperty $reflectionProperty,
        mixed &$instance,
        mixed $value,
        string $enum,
        array &$errors,
    ): void {
        try {
            $reflectionProperty->setValue($instance, $enum::tryFrom($value));
        } catch (Throwable $e) {
            $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
        }

        return;
    }

    private function setClass(
        ReflectionProperty $reflectionProperty,
        mixed &$instance,
        mixed $value,
        string $class,
        array &$errors,
    ): void {
        $mappedValue = $this->map($value, $class);

        $errors = [...$errors, ...$mappedValue->errors];

        try {
            $reflectionProperty->setValue($instance, $mappedValue->result);
        } catch (Throwable $e) {
            $errors[] = new MappingException($e->getMessage(), $reflectionProperty->getName(), get_class($instance), $e);
        }

        return;
    }

    private function mapArray(object $source, array $values, ArrayMapping $arrayMapping, array &$errors)
    {
        $definition = is_callable($arrayMapping->definition)
            ? ($arrayMapping->definition)($source)
            : $arrayMapping->definition;

        return enum_exists($definition)
            ? $this->mapEnumArray($values, $definition, $errors)
            : $this->mapClassArray($values, $definition, $errors);
    }

    /**
     * @param array $values
     * @param class-string $definition
     * @param array &$errors
     */
    private function mapClassArray(array $values, string $definition, array &$errors)
    {
        $new = [];

        foreach ($values as $key => $value) {
            $completedMapping = $this->map($value, $definition);

            $errors = [...$errors, ...$completedMapping->errors];
            $new[$key] = $completedMapping->result;
        }

        return $new;
    }

    /**
     * @param array $values
     * @param class-string $definition
     * @param array &$errors
     */
    private function mapEnumArray(array $values, string $definition, array &$errors)
    {
        $new = [];

        foreach ($values as $key => $value) {
            try {
                $new[$key] = $definition::tryFrom($value);
            } catch (Throwable $e) {
                $errors[] = new MappingException($e->getMessage(), '', $definition, $e);
                $new[$key] = null;
            }
        }

        return $new;
    }

    private function getReflectionProperty(string $definition, string $key): ReflectionProperty
    {
        if (isset($this->reflectionProperties[$definition][$key])) {
            return $this->reflectionProperties[$definition][$key];
        }

        $reflectionClass = $this->reflectionClasses[$definition]
            ?? $this->reflectionClasses[$definition] = new ReflectionClass($definition);

        return $this->reflectionProperties[$definition][$key] = $reflectionClass->getProperty($key);
    }

    private function getReflectionType(string $definition, string $key): ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null
    {
        return $this->reflectionTypes[$definition][$key]
            ?? $this->reflectionTypes[$definition][$key] = $this->getReflectionProperty($definition, $key)->getType();
    }
}
