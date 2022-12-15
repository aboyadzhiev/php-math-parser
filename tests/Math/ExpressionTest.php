<?php

namespace Math;

use PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{

    /**
     * @dataProvider expressionProvider
     *
     * @param string $expression
     * @param array $tokens
     * @return void
     */
    public function testExpressionParsing(string $expression, array $tokens): void
    {
        $expr = new Expression($expression);
        $actualTokens = $expr->getTokens();

        $this->assertSameSize($tokens, $actualTokens);
        foreach ($tokens as $k => $token) {
            $this->assertEquals($token, $actualTokens[$k]);
        }
    }

    public function expressionProvider(): array
    {
        // Array of arrays with 2 elements: 1st the math expression, 2nd the token array expected to be returned after
        // parsing the expression.
        return [
            ['1 + 1', ['1', '+', '1']],
            ['1+1', ['1', '+', '1']],
            ['1 + -1', ['1', '+', '-1']],
            ['1+-1', ['1', '+', '-1']],
            ['-1 + -1', ['-1', '+', '-1']],
            ['-1-1', ['-1', '-', '1']],
            ['1 + 2 * 3 * ( 7 * 8 ) - ( 45 - 10 )',
                ['1', '+', '2', '*', '3', '*', '(', '7', '*', '8', ')', '-', '(', '45', '-', '10', ')']],
            ['1 + 2 * 3 * ( 7 * 8 ) - ( 45 - 10 )',
                ['1', '+', '2', '*', '3', '*', '(', '7', '*', '8', ')', '-', '(', '45', '-', '10', ')']],
            ['1+2*3*(7*8)-(45-10)',
                ['1', '+', '2', '*', '3', '*', '(', '7', '*', '8', ')', '-', '(', '45', '-', '10', ')']],
            ['11 - -2 * -3 * ( 17 * 81 ) - ( -45 - 10 )',
                ['11', '-', '-2', '*', '-3', '*', '(', '17', '*', '81', ')', '-', '(', '-45', '-', '10', ')']],
            ['11--2*-3*(17*81)-(-45-10)',
                ['11', '-', '-2', '*', '-3', '*', '(', '17', '*', '81', ')', '-', '(', '-45', '-', '10', ')']],
            ['-1 + -2 * 13 * ( 7 * 8 ) - ( 415 - 0.1 )',
                ['-1', '+', '-2', '*', '13', '*', '(', '7', '*', '8', ')', '-', '(', '415', '-', '0.1', ')']],
            ['-1+-2*13*(7*8)-(415-0.1)',
                ['-1', '+', '-2', '*', '13', '*', '(', '7', '*', '8', ')', '-', '(', '415', '-', '0.1', ')']],
            ['0 + -1', ['0', '+', '-1']],
            ['1+-1', ['1', '+', '-1']],
        ];
    }
}
