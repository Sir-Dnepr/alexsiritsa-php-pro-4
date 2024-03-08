<?php
require_once __DIR__ . '/autoload.php';

use App\HomeWork02\CircleGeometricFigureCalculator;
use App\HomeWork02\SquareGeometricFigureCalculator;
use App\HomeWork02\TrigonometricFunctionCalculatorInRadians;
use App\HomeWork02\TrigonometricFunctionCalculatorInDegrees;
use App\HomeWork02\RhombGeometricFigureCalculator;

$radiusOfCircle = 5;
$circleGeometricFigureCalculator = new CircleGeometricFigureCalculator(5);
$squareCircleGeometricFigureCalculator = $circleGeometricFigureCalculator->getSquare();
$perimeterCircleGeometricFigureCalculator = $circleGeometricFigureCalculator->getPerimeter();

$oneSideOfSquare = 5;
$squareGeometricFigureCalculator = new SquareGeometricFigureCalculator($oneSideOfSquare);
$squareSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getSquare();
$perimeterSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getPerimeter();
$diagonalSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getDiagonal();

$trigonometricFunctionCalculatorObjects = [
    new TrigonometricFunctionCalculatorInRadians,
    new TrigonometricFunctionCalculatorInDegrees
];

$oneSideOfRhomb = 5;
$cornerOfRhombh = 7;

foreach ($trigonometricFunctionCalculatorObjects as $trigonometricFunctionCalculatorObject) {
    $squareGeometricFigureCalculator = new RhombGeometricFigureCalculator(
        $oneSideOfRhomb, $cornerOfRhombh, $trigonometricFunctionCalculatorObject
    );

    $diagonal = $squareGeometricFigureCalculator->getDiagonal();
}

exit;
