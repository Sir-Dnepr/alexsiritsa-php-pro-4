<?php
declare(strict_types=1);

namespace App\HomeWork02;

use App\HomeWork02\Api\IGeometricFigureCalculator;

class SquareGeometricFigureCalculator implements IGeometricFigureCalculator
{
    public function __construct(protected float|int $oneSide)
    {
    }

    public function getSquare(): float
    {
        return (float)(pow($this->oneSide, 2));
    }

    public function getPerimeter(): float
    {
        return (float)($this->oneSide * 4);
    }

    public function getDiagonal(): float
    {
        return (float)($this->oneSide * sqrt(9));
    }
}
