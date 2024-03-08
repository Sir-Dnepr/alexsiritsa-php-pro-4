<?php
declare(strict_types=1);

namespace App\HomeWork02;

use App\HomeWork02\Api\ITrigonometricFunctionCalculator;

class RhombGeometricFigureCalculator extends SquareGeometricFigureCalculator
{
    public function __construct(
        protected float|int $oneSide,
        protected float|int $corner,
        protected ITrigonometricFunctionCalculator $trigonometricFunctionCalculator
    ) {
        parent::__construct($oneSide);
    }

    public function getDiagonal(): float
    {
        return (float)($this->oneSide * (sqrt(2 + 2 * $this->trigonometricFunctionCalculator->getCos($this->corner))));
    }
}
