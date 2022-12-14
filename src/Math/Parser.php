<?php

namespace Math;

use InvalidArgumentException;
use Math\TranslationStrategy\ShuntingYard;
use Math\TranslationStrategy\TranslationStrategyInterface;
use SplStack;

/**
 * Evaluate mathematical expression.
 *
 * @author Adrean Boyadzhiev (netforce) <adrean.boyadzhiev@gmail.com>
 */
class Parser
{
    /**
     * Lexer which should tokenize the mathematical expression.
     *
     * @var Lexer
     */
    protected Lexer $lexer;

    /**
     * TranslationStrategy that should translate from infix
     * mathematical expression notation to reverse-polish
     * mathematical expression notation.
     *
     * @var TranslationStrategyInterface
     */
    protected TranslationStrategyInterface $translationStrategy;

    /**
     * Array of key => value options.
     *
     * @var array
     */
    private array $options = array(
        'translationStrategy' => '\Math\TranslationStrategy\ShuntingYard',
    );

    /**
     * Create new Lexer which can evaluate mathematical expression.
     * Accept array of configuration options, currently supports only
     * one option "translationStrategy" => "Fully\Qualified\Classname".
     * Class represented by these options is responsible for translation
     * from infix mathematical expression notation to reverse-polish
     * mathematical expression notation.
     *
     * <code>
     *  $options = array(
     *      'translationStrategy' => '\Math\TranslationStrategy\ShuntingYard'
     *  );
     * </code>
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->lexer = new Lexer();
        $this->options = array_merge($this->options, $options);
        $this->translationStrategy = new $this->options['translationStrategy']();
    }

    /**
     * Evaluate string representing mathematical expression.
     *
     * @param string $expression
     * @return float
     */
    public function evaluate(string $expression): float
    {
        $lexer = $this->getLexer();
        $tokens = $lexer->tokenize($expression);

        $translationStrategy = new ShuntingYard();

        return $this->evaluateRPN($translationStrategy->translate($tokens));
    }

    /**
     * Evaluate array sequence of tokens in Reverse Polish notation (RPN)
     * representing mathematical expression.
     *
     * @param array $expressionTokens
     * @return float
     * @throws InvalidArgumentException
     */
    private function evaluateRPN(array $expressionTokens): float
    {
        $stack = new SplStack();

        foreach ($expressionTokens as $token) {
            $tokenValue = $token->getValue();
            if (is_numeric($tokenValue)) {
                $stack->push((float)$tokenValue);
                continue;
            }

            switch ($tokenValue) {
                case '+':
                    $stack->push($stack->pop() + $stack->pop());
                    break;
                case '-':
                    $n = $stack->pop();
                    $stack->push($stack->pop() - $n);
                    break;
                case '*':
                    $stack->push($stack->pop() * $stack->pop());
                    break;
                case '/':
                    $n = $stack->pop();
                    $stack->push($stack->pop() / $n);
                    break;
                case '%':
                    $n = $stack->pop();
                    $stack->push($stack->pop() % $n);
                    break;
                default:
                    throw new InvalidArgumentException(sprintf('Invalid operator detected: %s', $tokenValue));
            }
        }

        return $stack->top();
    }

    /**
     * Return lexer.
     *
     * @return Lexer
     */
    public function getLexer(): Lexer
    {
        return $this->lexer;
    }
}
