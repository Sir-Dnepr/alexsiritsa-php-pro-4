<?php

interface IGeometricFigureCalculator
{
    public function getSquare(): float;

    public function getPerimeter(): float;
}

interface ITrigonometricFunctionCalculator
{
    public function getCos(float|int $corner): float;
}

class TrigonometricFunctionCalculatorInRadians implements ITrigonometricFunctionCalculator
{
    public function getCos(float|int $corner): float
    {
        return cos($corner);
    }
}

class TrigonometricFunctionCalculatorInDegrees implements ITrigonometricFunctionCalculator
{
    public function getCos(float|int $corner): float
    {
        return cos(deg2rad($corner));
    }
}

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

$circleGeometricFigureCalculator = new CircleGeometricFigureCalculator(5);
$squareCircleGeometricFigureCalculator = $circleGeometricFigureCalculator->getSquare();
$perimeterCircleGeometricFigureCalculator = $circleGeometricFigureCalculator->getPerimeter();

$squareGeometricFigureCalculator = new SquareGeometricFigureCalculator(5);
$squareSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getSquare();
$perimeterSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getPerimeter();
$diagonalSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getDiagonal();

$trigonometricFunctionCalculatorObjects = [
    new TrigonometricFunctionCalculatorInRadians,
    new TrigonometricFunctionCalculatorInDegrees
];

foreach ($trigonometricFunctionCalculatorObjects as $trigonometricFunctionCalculatorObject) {
    $squareGeometricFigureCalculator = new RhombGeometricFigureCalculator(
        5, 7, $trigonometricFunctionCalculatorObject
    );

    $diagonal = $squareGeometricFigureCalculator->getDiagonal();
}

exit;
