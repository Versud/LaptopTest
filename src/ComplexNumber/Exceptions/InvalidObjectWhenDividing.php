<?php

declare(strict_types=1);

namespace Vladimir\Laptop\ComplexNumber\Exceptions;

use InvalidArgumentException;

final class InvalidObjectWhenDividing extends InvalidArgumentException
{
    public static function create(): self
    {
        return new self('Сумма квадратов комплексной и мнимой части принятого объекта не может быть равной 0');
    }
}