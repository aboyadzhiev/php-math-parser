<?php

namespace Math;

use PHPUnit_Framework_TestCase;

class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateParser()
    {
        $this->assertInstanceOf('\Math\Parser', new Parser());
    }
}
