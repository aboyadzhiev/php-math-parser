<?php

namespace oat\beeme\tests;

use PHPUnit_Framework_TestCase;
use oat\beeme\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateParser()
    {
        $this->assertInstanceOf('oat\beeme\Parser', new Parser());
    }
}
