<?php
declare(strict_types=1);

namespace App\HomeWork02;

use App\HomeWork02\Api\IGeometricFigureCalculator;

class CircleGeometricFigureCalculator implements IGeometricFigureCalculator
{
    public function __construct(protected float|int $radius)
    {
    }

    public function getSquare(): float
    {
        return (float)(2 * M_PI * $this->radius);
    }

    public function getPerimeter(): float
    {
        return (float)(M_PI * pow($this->radius, 2));
    }
}
