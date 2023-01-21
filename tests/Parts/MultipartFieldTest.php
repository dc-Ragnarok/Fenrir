<?php

use Exan\Dhp\Parts\MultipartField;
use PHPUnit\Framework\TestCase;

class MultipartFieldTest extends TestCase
{
    public function testThing()
    {
        $multipartField = new MultipartField('files[1]', 'AAAABBBB', 'test.png');

        var_dump((string) $multipartField);
    }
}
