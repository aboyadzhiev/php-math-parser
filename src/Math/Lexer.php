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
     * The mathematical expression that should be tokenized
     *
     * @var string
     */
    protected string $code;

    /**
     * Mathematical operators map
     *
     * @var array
     */
    protected static array $operatorsMap = array(
        '+' => array('priority' => 0, 'associativity' => Operator::O_LEFT_ASSOCIATIVE),
        '-' => array('priority' => 0, 'associativity' => Operator::O_LEFT_ASSOCIATIVE),
        '*' => array('priority' => 1, 'associativity' => Operator::O_LEFT_ASSOCIATIVE),
        '/' => array('priority' => 1, 'associativity' => Operator::O_LEFT_ASSOCIATIVE),
        '%' => array('priority' => 1, 'associativity' => Operator::O_LEFT_ASSOCIATIVE),
    );

    public function __construct()
    {
        $this->tokens = array();
    }

    /**
     * Tokenize mathematical expression.
     *
     * @param string $code
     * @return array Collection of Token instances
     * @throws InvalidArgumentException
     */
    public function tokenize(string $code): array
    {
        $code = trim($code);
        if (empty($code)) {
            throw new InvalidArgumentException('Cannot tokenize empty string.');
        }

        $this->code = $code;
        $this->tokens = array();

        $tokenArray = explode(' ', $this->code);

        if (!is_array($tokenArray) || empty($tokenArray)) {
            throw new InvalidArgumentException(
                sprintf('Cannot tokenize string: %s, please use " "(empty space for delimiter between tokens)', $this->code)
            );
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
            } elseif ('' === $t) {
                continue;
            } else {
                throw new InvalidArgumentException(sprintf('Syntax error: unknown token "%s"', $t));
            }

            $this->tokens[] = $token;
        }

        return $this->tokens;
    }

}
