<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Component\V2;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\Button\PrimaryButton;
use Ragnarok\Fenrir\Component\V2\Container;
use Ragnarok\Fenrir\Component\V2\File;
use Ragnarok\Fenrir\Component\V2\MediaGallery;
use Ragnarok\Fenrir\Component\V2\MediaGalleryItem;
use Ragnarok\Fenrir\Component\V2\Section;
use Ragnarok\Fenrir\Component\V2\Separator;
use Ragnarok\Fenrir\Component\V2\TextDisplay;
use Ragnarok\Fenrir\Component\V2\Thumbnail;
use Ragnarok\Fenrir\Component\V2\UnfurledMedia;
use Ragnarok\Fenrir\Enums\SeparatorSpacingSize;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;

class ComponentsV2Test extends TestCase
{
    public function testTextDisplay(): void
    {
        $this->assertEquals(
            ['type' => 10, 'content' => 'Hello'],
            new TextDisplay('Hello')->get()
        );
    }

    public function testTextDisplayCarriesAnId(): void
    {
        $this->assertEquals(
            ['type' => 10, 'content' => 'Hello', 'id' => 7],
            new TextDisplay('Hello', 7)->get()
        );
    }

    /**
     * Every optional field is left out entirely rather than sent as null, so
     * Discord applies its own defaults.
     */
    public function testAnEmptySeparatorSendsOnlyItsType(): void
    {
        $this->assertEquals(['type' => 14], new Separator()->get());
    }

    public function testSeparatorWithSpacingAndDivider(): void
    {
        $this->assertEquals(
            ['type' => 14, 'divider' => true, 'spacing' => 2],
            new Separator(divider: true, spacing: SeparatorSpacingSize::LARGE)->get()
        );
    }

    public function testThumbnail(): void
    {
        $this->assertEquals(
            [
                'type' => 11,
                'media' => ['url' => 'https://example.test/a.png'],
                'description' => 'A picture',
                'spoiler' => true,
            ],
            new Thumbnail(
                new UnfurledMedia('https://example.test/a.png'),
                description: 'A picture',
                spoiler: true
            )->get()
        );
    }

    public function testAFileReferencesAnAttachmentOnTheSameMessage(): void
    {
        $this->assertEquals(
            ['type' => 13, 'file' => ['url' => 'attachment://report.pdf']],
            new File(UnfurledMedia::attachment('report.pdf'))->get()
        );
    }

    public function testMediaGallery(): void
    {
        $gallery = new MediaGallery()
            ->add(new MediaGalleryItem(new UnfurledMedia('https://example.test/a.png')))
            ->add(new MediaGalleryItem(new UnfurledMedia('https://example.test/b.png'), 'Second'));

        $this->assertEquals([
            'type' => 12,
            'items' => [
                ['media' => ['url' => 'https://example.test/a.png']],
                ['media' => ['url' => 'https://example.test/b.png'], 'description' => 'Second'],
            ],
        ], $gallery->get());
    }

    public function testAGalleryRejectsAnEleventhItem(): void
    {
        $gallery = new MediaGallery();

        for ($i = 0; $i < MediaGallery::MAX_ITEMS; $i++) {
            $gallery->add(new MediaGalleryItem(new UnfurledMedia('https://example.test/' . $i . '.png')));
        }

        $this->expectException(TooManyItemsException::class);

        $gallery->add(new MediaGalleryItem(new UnfurledMedia('https://example.test/x.png')));
    }

    public function testSectionWithAButtonAccessory(): void
    {
        $section = new Section(new PrimaryButton('::custom id::', 'Go'))
            ->add(new TextDisplay('Line one'));

        $this->assertEquals([
            'type' => 9,
            'components' => [['type' => 10, 'content' => 'Line one']],
            'accessory' => [
                'type' => 2,
                'style' => 1,
                'custom_id' => '::custom id::',
                'disabled' => false,
                'label' => 'Go',
            ],
        ], $section->get());
    }

    public function testASectionRejectsAFourthTextDisplay(): void
    {
        $section = new Section(new PrimaryButton('::custom id::'));

        for ($i = 0; $i < Section::MAX_COMPONENTS; $i++) {
            $section->add(new TextDisplay('line ' . $i));
        }

        $this->expectException(TooManyItemsException::class);

        $section->add(new TextDisplay('one too many'));
    }

    public function testContainerNestsItsChildren(): void
    {
        $container = new Container(accentColor: 0x5865F2, spoiler: true)
            ->add(new TextDisplay('Inside'))
            ->add(new Separator());

        $this->assertEquals([
            'type' => 17,
            'components' => [
                ['type' => 10, 'content' => 'Inside'],
                ['type' => 14],
            ],
            'accent_color' => 0x5865F2,
            'spoiler' => true,
        ], $container->get());
    }
}
