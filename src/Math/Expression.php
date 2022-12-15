<?php

namespace Math;

use LogicException;

/**
 * Represent mathematical expression.
 *
 * @author Adrean Boyadzhiev (netforce) <adrean.boyadzhiev@gmail.com>
 */
class Expression
{
    private const EMPTY_SPACE_STRING = ' ';
    /**
     * The raw math expression
     *
     * @var string
     */
    private string $source;

    /**
     * Array containing all tokens of the math expression
     *
     * @var array
     */
    private array $tokens;

    private static array $operatorTokens = ['-', '+', '*', '/'];
    private static array $brackets = ['(', ')'];

    /**
     * @param string $source
     */
    public function __construct(string $source)
    {
        $this->source = $source;
        $this->tokens = [];
        $this->parse();
    }

    /**
     * Parse the math expression through scanning it char by char.
     *
     * @return void
     */
    private function parse(): void
    {
        $rawToken = '';
        $hasRawToken = false;
        $exprLength = strlen($this->source);
        for ($currentPosition = 0; $currentPosition < $exprLength; $currentPosition++) {
            $char = $this->source[$currentPosition];
            if ($char == self::EMPTY_SPACE_STRING) {
                if ($hasRawToken) {
                    $this->tokens[] = $rawToken;
                    $rawToken = '';
                }
            } elseif ($char == '.') {
                $rawToken .= $char;
            } elseif ($char == '-') {
                $tokensSize = sizeof($this->tokens);
                $lastToken = $tokensSize == 0 ? null : $this->tokens[$tokensSize - 1];
                if (is_numeric($lastToken) || is_numeric($rawToken)) {
                    if ($hasRawToken) {
                        $this->tokens[] = $rawToken;
                        $rawToken = '';
                    }
                    $this->tokens[] = $char;
                } else {
                    if ($hasRawToken) {
                        $this->tokens[] = $rawToken;
                    }
                    $rawToken = $char;
                }
            } elseif (in_array($char, self::$brackets) || in_array($char, self::$operatorTokens)) {
                if ($hasRawToken) {
                    $this->tokens[] = $rawToken;
                    $rawToken = '';
                }
                $this->tokens[] = $char;
            } elseif (is_numeric($char)) {
                $rawToken .= $char;
            } else {
                throw new LogicException(sprintf(
                    'Syntax error unexpected character: %s at position %d in expression %s',
                    $char, $currentPosition, $this->source
                ));
            }
            $hasRawToken = strlen($rawToken) > 0;
            if ($exprLength - 1 == $currentPosition && $hasRawToken) {
                $this->tokens[] = $rawToken;
                $rawToken = '';
            }
        }
    }

    /**
     * Return the char array representing this math expression e.g. expression: <code> '-1 + -1' </code> will be
     * represented by array: <code> ['-1', '+', '-1'] </code>
     *
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function __toString(): string
    {
        return $this->source;
    }

}