<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Component\Modal;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\Modal\Checkbox;
use Ragnarok\Fenrir\Component\Modal\CheckboxGroup;
use Ragnarok\Fenrir\Component\Modal\FileUpload;
use Ragnarok\Fenrir\Component\Modal\Label;
use Ragnarok\Fenrir\Component\Modal\Option;
use Ragnarok\Fenrir\Component\Modal\RadioGroup;
use Ragnarok\Fenrir\Component\TextInput;
use Ragnarok\Fenrir\Enums\TextInputStyle;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;

class ModalComponentsTest extends TestCase
{
    public function testALabelWrapsItsInput(): void
    {
        $label = new Label(
            'Your name',
            new TextInput('name', TextInputStyle::Short, 'Name'),
            description: 'As it appears on your account'
        );

        $built = $label->get();

        $this->assertEquals(18, $built['type']);
        $this->assertEquals('Your name', $built['label']);
        $this->assertEquals('As it appears on your account', $built['description']);
        $this->assertEquals(4, $built['component']['type']);
        $this->assertEquals('name', $built['component']['custom_id']);
    }

    public function testCheckbox(): void
    {
        $this->assertEquals(
            ['type' => 23, 'custom_id' => 'agree', 'default' => true],
            new Checkbox('agree', default: true)->get()
        );
    }

    public function testFileUpload(): void
    {
        $this->assertEquals(
            [
                'type' => 19,
                'custom_id' => 'evidence',
                'max_values' => 3,
                'required' => true,
            ],
            new FileUpload('evidence', maxValues: 3, required: true)->get()
        );
    }

    public function testAnEmptyFileUploadSendsOnlyWhatIsRequired(): void
    {
        $this->assertEquals(
            ['type' => 19, 'custom_id' => 'evidence'],
            new FileUpload('evidence')->get()
        );
    }

    public function testRadioGroup(): void
    {
        $group = new RadioGroup('size', required: true)
            ->add(new Option('Small', 's'))
            ->add(new Option('Large', 'l', description: 'Costs more', default: true));

        $this->assertEquals([
            'type' => 21,
            'custom_id' => 'size',
            'options' => [
                ['label' => 'Small', 'value' => 's'],
                ['label' => 'Large', 'value' => 'l', 'description' => 'Costs more', 'default' => true],
            ],
            'required' => true,
        ], $group->get());
    }

    public function testCheckboxGroup(): void
    {
        $group = new CheckboxGroup('toppings', minValues: 1, maxValues: 2)
            ->add(new Option('Cheese', 'cheese'));

        $built = $group->get();

        $this->assertEquals(22, $built['type']);
        $this->assertEquals(1, $built['min_values']);
        $this->assertEquals(2, $built['max_values']);
        $this->assertCount(1, $built['options']);
    }

    public function testAGroupRejectsAnEleventhOption(): void
    {
        $group = new CheckboxGroup('toppings');

        for ($i = 0; $i < CheckboxGroup::MAX_OPTIONS; $i++) {
            $group->add(new Option('option ' . $i, (string) $i));
        }

        $this->expectException(TooManyItemsException::class);

        $group->add(new Option('one too many', 'x'));
    }
}
