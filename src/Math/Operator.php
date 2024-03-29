<?php

namespace Math;

use InvalidArgumentException;

/**
 * Value object representing one operator of mathematical expression.
 *
 * @author Adrean Boyadzhiev (netforce) <adrean.boyadzhiev@gmail.com>
 */
class Operator extends Token
{
    const O_LEFT_ASSOCIATIVE = -1;
    const O_NONE_ASSOCIATIVE = 0;
    const O_RIGHT_ASSOCIATIVE = 1;

    protected int $priority;
    protected int $associativity;

    /**
     * Create new "Value object" which represent one mathematical operator.
     *
     * @param string $value string representation of this operator
     * @param integer $priority priority value of this token
     * @param integer $associativity one of Operator associative constants
     * @throws InvalidArgumentException
     */
    public function __construct(string $value, int $priority, int $associativity)
    {
        if (!in_array($associativity, [self::O_LEFT_ASSOCIATIVE, self::O_NONE_ASSOCIATIVE, self::O_RIGHT_ASSOCIATIVE])) {
            throw new InvalidArgumentException(sprintf('Invalid associativity: %s', $associativity));
        }

        $this->priority = $priority;
        $this->associativity = $associativity;
        parent::__construct($value, Token::T_OPERATOR);
    }

    /**
     * Return associativity of this operator.
     *
     * @return integer
     */
    public function getAssociativity(): int
    {
        return $this->associativity;
    }

    /**
     * Return priority of this operator.
     *
     * @return integer
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Return true if this operator has lower priority of operator $o.
     *
     * @param Operator $o
     * @return boolean
     */
    public function hasLowerPriority(Operator $o): bool
    {
        return ((Operator::O_LEFT_ASSOCIATIVE == $o->getAssociativity()
                && $this->getPriority() == $o->getPriority())
            || $this->getPriority() < $o->getPriority());
    }
}
