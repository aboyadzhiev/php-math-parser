<?php

namespace Math;

use InvalidArgumentException;

/**
 * Tokenize mathematical expression.
 *
 * @author Adrean Boyadzhiev (netforce) <adrean.boyadzhiev@gmail.com>
 */
class Lexer
{

    /**
     * Collection of Token instances
     *
     * @var array
     */
    protected array $tokens;

    /**
     * The math expression
     *
     * @var Expression
     */
    protected Expression $expression;

    /**
     * Mathematical operators map
     *
     * @var array
     */
    protected static array $operatorsMap = [
        '+' => ['priority' => 0, 'associativity' => Operator::O_LEFT_ASSOCIATIVE],
        '-' => ['priority' => 0, 'associativity' => Operator::O_LEFT_ASSOCIATIVE],
        '*' => ['priority' => 1, 'associativity' => Operator::O_LEFT_ASSOCIATIVE],
        '/' => ['priority' => 1, 'associativity' => Operator::O_LEFT_ASSOCIATIVE],
        '%' => ['priority' => 1, 'associativity' => Operator::O_LEFT_ASSOCIATIVE],
    ];

    public function __construct()
    {
        $this->tokens = [];
    }

    /**
     * Tokenize mathematical expression.
     *
     * @param string $expression
     * @return array Collection of Token instances
     * @throws InvalidArgumentException
     */
    public function tokenize(string $expression): array
    {
        $this->expression = new Expression(trim($expression));
        $this->tokens = [];

        $tokenArray = $this->expression->getTokens();
        if (empty($tokenArray)) {
            throw new InvalidArgumentException(sprintf('Cannot tokenize expression: %s', $this->expression));
        }

        foreach ($tokenArray as $t) {
            if (array_key_exists($t, static::$operatorsMap)) {
                $token = new Operator(
                    $t,
                    static::$operatorsMap[$t]['priority'],
                    static::$operatorsMap[$t]['associativity']
                );
            } elseif (is_numeric($t)) {
                $token = new Token((float)$t, Token::T_OPERAND);
            } elseif ('(' === $t) {
                $token = new Token($t, Token::T_LEFT_BRACKET);
            } elseif (')' === $t) {
                $token = new Token($t, Token::T_RIGHT_BRACKET);
            } else {
                throw new InvalidArgumentException(sprintf('Syntax error: unknown token "%s"', $t));
            }

            $this->tokens[] = $token;
        }

        return $this->tokens;
    }

}
