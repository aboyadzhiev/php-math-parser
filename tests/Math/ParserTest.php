<?php declare(strict_types=1);

namespace Math;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    private Parser $parser;

    public function testCanCreateParserWithDefaultStrategy(): void
    {
        $this->assertInstanceOf('\Math\Parser', new Parser());
    }

    /**
     * @dataProvider expressionProvider
     *
     * @param string $expression
     * @param float $result
     * @return void
     */
    public function testExpressionEvaluation(string $expression, float $result): void
    {
        $parser = new Parser();
        $message = sprintf('Failed to evaluate math expression "%s" to "%f"', $expression, $result);

        $this->assertEquals($result, $parser->evaluate($expression), $message);
    }

    public function expressionProvider(): array
    {
        // array of arrays which contains two elements: 1st is the math expression, 2nd is the expected result
        return [
            ['1 + 2 * 3 * ( 7 * 8 ) - ( 45 - 10 )', 302],
            ['1+2*3*(7*8)-(45-10)', 302],
            ['11 - -2 * -3 * ( 17 * 81 ) - ( -45 - 10 )', -8196],
            ['11--2*-3*(17*81)-(-45-10)', -8196],
            ['-1 + -2 * 13 * ( 7 * 8 ) - ( 415 - 0.1 )', -1871.90],
            ['-1+-2*13*(7*8)-(415-0.1)', -1871.90],
            ['0 + -1', -1],
            ['0+-1', -1],
            ['1+1', 2],
            ['1 + 1 ', 2],
            [' 1+-1 ', 0],
            ['(1+1)/1', 2],
            ['(1+1)/-1', -2],
        ];
    }

}
