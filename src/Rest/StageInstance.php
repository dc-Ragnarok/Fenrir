<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\StageInstance as PartsStageInstance;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application
 */
class StageInstance extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/stage-instance#modify-stage-instance
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\StageInstance>
     */
    public function createInstance(array $params, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::STAGE_INSTANCES,
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsStageInstance::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/stage-instance#get-stage-instance
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\StageInstance>
     */
    public function getInstances(string $channelId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::STAGE_INSTANCE,
                    $channelId,
                ),
            ),
            PartsStageInstance::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/stage-instance#modify-stage-instance
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\StageInstance>
     */
    public function modifyInstances(string $channelId, array $params, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::STAGE_INSTANCE,
                    $channelId,
                ),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsStageInstance::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/stage-instance#delete-stage-instance
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteInstances(string $channelId, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->delete(
                Endpoint::bind(
                    Endpoint::STAGE_INSTANCE,
                    $channelId,
                ),
                headers: $this->getAuditLogReasonHeader($reason),
            ),
            PartsStageInstance::class,
        )->otherwise($this->logThrowable(...));
    }
}
