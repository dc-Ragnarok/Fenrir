<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use JsonMapper;
use Psr\Log\LoggerInterface;
use Throwable;

class DataMapper
{
    private JsonMapper $jsonMapper;

    public function __construct(private LoggerInterface $logger)
    {
        $this->jsonMapper = new JsonMapper();

        $this->jsonMapper->bStrictNullTypes = false;
        $this->jsonMapper->bEnforceMapType = false;
        $this->jsonMapper->bStrictObjectTypeChecking = false;
    }

    /**
     * @param class-string $definition
     * @return $definition Instance of given definition with provided properties.
     *  If no properties are present, the mapping failed
     */
    public function map(object|array $data, string $definition): mixed
    {
        try {
            return $this->jsonMapper->map($data, new $definition());
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return new $definition();
    }

    /**
     * @param array<object|array> $data
     * @param class-string $definition
     * @return array<$definition> Array of instances of given definition with provided properties.
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
