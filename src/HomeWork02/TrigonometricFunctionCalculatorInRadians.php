<?php
declare(strict_types=1);

namespace App\HomeWork02;

use App\HomeWork02\Api\ITrigonometricFunctionCalculator;

class TrigonometricFunctionCalculatorInRadians implements ITrigonometricFunctionCalculator
{
    public function getCos(float|int $corner): float
    {
        return cos($corner);
    }
}
