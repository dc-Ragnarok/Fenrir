<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\Mapping\Mapper;
use Ragnarok\Fenrir\Mapping\MappingException;

class DataMapper
{
    private Mapper $mapper;

    public function __construct(private LoggerInterface $logger)
    {
        $this->mapper = new Mapper();
    }

    /**
     * @template T of object
     * @param class-string<T> $definition
     *
     * @return T Instance of given definition with provided properties.
     *  If no properties are present, the mapping failed
     */
    public function map(object $data, string $definition): mixed
    {
        $completedMapping = $this->mapper->map(
            $data,
            $definition
        );

        $errors = array_map(fn (MappingException $exception) => [
            'Mapping exception: ' . $exception->getMessage(),
            ['class' => $exception->className, 'property' => $exception->propertyName]
        ], $completedMapping->errors);

        foreach (array_unique($errors, SORT_REGULAR) as $uniqueError) {
            $this->logger->debug(...$uniqueError);
        }

        return $completedMapping->result;
    }

    /**
     * @template T of object
     *
     * @param array<object|array> $data
     * @param class-string<T> $definition
     * @return array<T> Array of instances of given definition with provided properties.
     *  If no properties are present in an item of the array, the mapping for this item failed
     */
    public function mapArray(array $data, string $definition): array
    {
        return array_map(
            fn (object|array $item) => $this->map($item, $definition),
            $data
        );
    }
}
