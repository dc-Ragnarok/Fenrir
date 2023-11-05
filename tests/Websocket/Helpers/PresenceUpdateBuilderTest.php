<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Websocket\Helpers;

use Carbon\Carbon;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\StatusType;
use Ragnarok\Fenrir\Gateway\Helpers\ActivityBuilder;
use Ragnarok\Fenrir\Gateway\Helpers\PresenceUpdateBuilder;

class PresenceUpdateBuilderTest extends TestCase
{
    public function tesSetProperties()
    {
        $builder = PresenceUpdateBuilder::new();

        /** @var MockInterface&ActivityBuilder */
        $activity = Mockery::mock(ActivityBuilder::class);
        $activity->shouldReceive()
            ->get()
            ->andReturn(['::activity builder::']);

        $date = Carbon::now();

        $builder->setSince($date)
            ->addActivity($activity)
            ->setStatus(StatusType::DO_NOT_DISTURB)
            ->setAfk(true);

        $this->assertEquals([
            'since' => $date->getTimestampMs(),
            'status' => StatusType::DO_NOT_DISTURB->value,
            'afk' => true,
            'activities' => [['::activity builder::']],
        ], $builder->get());

        $this->assertEquals($date, $builder->getSince());
        $this->assertEquals([$activity], $builder->getActivities());
        $this->assertEquals(StatusType::DO_NOT_DISTURB, $builder->getStatus());
        $this->assertEquals(true, $builder->getAfk());
    }

    public function testSinceIsOptional()
    {
        $builder = PresenceUpdateBuilder::new();

        /** @var MockInterface&ActivityBuilder */
        $activity = Mockery::mock(ActivityBuilder::class);
        $activity->shouldReceive()
            ->get()
            ->andReturn(['::activity builder::']);

        $builder->setActivities($activity)
            ->setStatus(StatusType::DO_NOT_DISTURB)
            ->setAfk(true);

        $this->assertEquals([
            'since' => null,
            'status' => StatusType::DO_NOT_DISTURB->value,
            'afk' => true,
            'activities' => [['::activity builder::']],
        ], $builder->get());
    }
}
