<?php

use Exan\Dhp\Parts\Multipart;
use Exan\Dhp\Parts\MultipartField;
use PHPUnit\Framework\TestCase;

class MultipartTest extends TestCase
{
    public function testThing()
    {

        var_dump((new \Mimey\MimeTypes)->getMimeType('nothing lol'));

        $fields = [
            new MultipartField('files[0]', 'AAAABBBB', 'test.png'),
            new MultipartField('files[1]', 'CCCCDDDD', 'something.png'),
            new MultipartField('files[2]', 'EEEEFFFF', 'thing.png'),
        ];

        $multipart = new Multipart($fields);

        var_dump((string) $multipart);
    }
}
