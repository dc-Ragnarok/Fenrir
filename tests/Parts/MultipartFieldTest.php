<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Parts;

use Exan\Finrir\Parts\MultipartField;
use PHPUnit\Framework\TestCase;

class MultipartFieldTest extends TestCase
{
    /**
     * @dataProvider stringConversionProvider
     */
    public function testStringConversion(array $args, string $expected)
    {
        $multipartField = new MultipartField(...$args);

        $this->assertEquals($expected, (string) $multipartField);
    }

    public function stringConversionProvider(): array
    {
        return [
            'Completely filled' => [
                'args' => [
                    '::name::',
                    '::content::',
                    '::filename::',
                    [
                        'Header-Name' => 'Value',
                    ],
                ],

                'expected' => <<<EXPECTED
                Content-Disposition: form-data; name="::name::"; filename="%3A%3Afilename%3A%3A"
                Header-Name: Value

                ::content::

                EXPECTED
            ],
            'Missing filename' => [
                'args' => [
                    '::name::',
                    '::content::',
                    null,
                    [
                        'Header-Name' => 'Value',
                    ],
                ],

                'expected' => <<<EXPECTED
                Content-Disposition: form-data; name="::name::"
                Header-Name: Value

                ::content::

                EXPECTED
            ],
            'No headers' => [
                'args' => [
                    '::name::',
                    '::content::',
                    '::filename::',
                    [],
                ],

                'expected' => <<<EXPECTED
                Content-Disposition: form-data; name="::name::"; filename="%3A%3Afilename%3A%3A"

                ::content::

                EXPECTED
            ],
        ];
    }
}
