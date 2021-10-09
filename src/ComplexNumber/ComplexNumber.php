<?php

declare(strict_types=1);

namespace Vladimir\Laptop\ComplexNumber;

use Vladimir\Laptop\ComplexNumber\Exceptions\InvalidObjectWhenDividing;


/**
 * Предназначен для работы с комплексными числами в иммутабельном формате
 */
final class ComplexNumber
{
    /**
     * @param float $re действительная часть
     * @param float $im мнимая часть
     */
    public function __construct(private float $re, private float $im)
    {}

    /**
     * Возвращает действительную часть
     */
    public function getReal(): float
    {
        return $this->re;
    }

    /**
     * Возвращает мнимую часть
     */
    public function getImaginary(): float
    {
        return $this->im;
    }

    /**
     * Операция сложения комплексных чисел
     */
    public function add(self $other): self
    {
        return new self(
            $this->re + $other->re,
            $this->im + $other->im
        );
    }

    /**
     * Операция вычитания комплексных чисел
     */
    public function sub(self $other): self
    {
        return new self(
            $this->re - $other->re,
            $this->im - $other->im
        );
    }

    /**
     * Операция умножения комплексных чисел
     */
    public function mul(self $other): self
    {
        return new self(
            $this->re * $other->re - $this->im * $other->im,
            $this->re * $other->im + $this->im * $other->re
        );
    }

    /**
     * Операция деления комплексных чисел
     *
     * @throws InvalidObjectWhenDividing
     */
    public function div(self $other): self
    {
        $denominator = $other->re ** 2 + $other->im ** 2;

        // Сравнивать явным образом нельзя из-за машинной точности
        if (abs($denominator) < PHP_FLOAT_EPSILON) {
            throw InvalidObjectWhenDividing::create();
        }

        return new self(
            ($this->re * $other->re + $this->im * $other->im) / $denominator,
            ($this->im * $other->re - $this->re * $other->im) / $denominator
        );
    }
}