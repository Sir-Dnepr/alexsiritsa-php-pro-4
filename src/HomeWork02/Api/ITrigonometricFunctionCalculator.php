<?php
declare(strict_types=1);

namespace App\HomeWork02\Api;

interface ITrigonometricFunctionCalculator
{
    /**
     * @param float|int $corner
     *
     * @return float
     */
    public function getCos(float|int $corner): float;
}
