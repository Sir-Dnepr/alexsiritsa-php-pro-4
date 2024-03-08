<?php
declare(strict_types=1);

namespace App\HomeWork02\Api;

interface IGeometricFigureCalculator
{
    /**
     * @return float
     */
    public function getSquare(): float;

    /**
     * @return float
     */
    public function getPerimeter(): float;
}
