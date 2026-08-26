<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Soundboard;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\SoundData;
use Ragnarok\Fenrir\Rest\Helpers\Soundboard\CreateSoundboardSoundBuilder;

class CreateSoundboardSoundBuilderTest extends TestCase
{
    public function testItBuildsTheCreatePayload(): void
    {
        $builder = CreateSoundboardSoundBuilder::new()
            ->setName('airhorn')
            ->setSound('::audio::', SoundData::MP3)
            ->setVolume(0.5)
            ->setEmojiName('::emoji::');

        $this->assertEquals([
            'name' => 'airhorn',
            'sound' => 'data:audio/mpeg;base64,' . base64_encode('::audio::'),
            'volume' => 0.5,
            'emoji_name' => '::emoji::',
        ], $builder->get());
    }

    public function testGettersReturnNullWhenUnset(): void
    {
        $builder = CreateSoundboardSoundBuilder::new();

        $this->assertNull($builder->getName());
        $this->assertNull($builder->getSound());
        $this->assertNull($builder->getVolume());
        $this->assertNull($builder->getEmojiId());
        $this->assertNull($builder->getEmojiName());
    }

    public function testItEncodesOggSounds(): void
    {
        $builder = CreateSoundboardSoundBuilder::new()->setSound('::audio::', SoundData::OGG);

        $this->assertEquals(
            'data:audio/ogg;base64,' . base64_encode('::audio::'),
            $builder->getSound()
        );
    }
}
