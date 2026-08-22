<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Soundboard;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Rest\Helpers\Soundboard\ModifySoundboardSoundBuilder;

class ModifySoundboardSoundBuilderTest extends TestCase
{
    public function testItBuildsTheModifyPayload(): void
    {
        $builder = ModifySoundboardSoundBuilder::new()
            ->setName('airhorn')
            ->setVolume(1.0)
            ->setEmojiId('::emoji id::');

        $this->assertEquals([
            'name' => 'airhorn',
            'volume' => 1.0,
            'emoji_id' => '::emoji id::',
        ], $builder->get());
    }

    /**
     * Discord treats these fields as nullable, so clearing one has to survive
     * into the payload rather than being dropped as "unset".
     */
    public function testItKeepsExplicitNulls(): void
    {
        $builder = ModifySoundboardSoundBuilder::new()
            ->setEmojiId(null)
            ->setEmojiName(null)
            ->setVolume(null);

        $this->assertEquals([
            'emoji_id' => null,
            'emoji_name' => null,
            'volume' => null,
        ], $builder->get());
    }
}
