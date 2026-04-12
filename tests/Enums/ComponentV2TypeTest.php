<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Enums;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ComponentV2Type;

class ComponentV2TypeTest extends TestCase
{
    #[Test]
    public function all_classes_for_specific_components_exist()
    {
        foreach (ComponentV2Type::cases() as $enum) {
            $this->assertTrue(
                class_exists($enum->getClass()),
                sprintf('Class %s does not exist', $enum->getClass()),
            );
        }
    }
}
