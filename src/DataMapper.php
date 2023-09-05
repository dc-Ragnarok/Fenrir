<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Tnapf\JsonMapper\Mapper;
use Psr\Log\LoggerInterface;

class DataMapper
{
    private Mapper $jsonMapper;

    public function __construct(private LoggerInterface $logger)
    {
        $this->jsonMapper = new Mapper();
    }

    /**
     * @template T of object
     * @param class-string<T> $definition
     *
     * @return T Instance of given definition with provided properties.
     *  If no properties are present, the mapping failed
     */
    public function map(object|array $data, string $definition): mixed
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        try {
            return $this->jsonMapper->map($definition, $data);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return new $definition();
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
