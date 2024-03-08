<?php
require_once __DIR__ . '/../examples/autoload.php';

use App\HomeWork02 as HomeWork;

$circleGeometricFigureCalculator = new HomeWork\CircleGeometricFigureCalculator(5);
$squareCircleGeometricFigureCalculator = $circleGeometricFigureCalculator->getSquare();
$perimeterCircleGeometricFigureCalculator = $circleGeometricFigureCalculator->getPerimeter();

$squareGeometricFigureCalculator = new HomeWork\SquareGeometricFigureCalculator(5);
$squareSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getSquare();
$perimeterSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getPerimeter();
$diagonalSquareGeometricFigureCalculator = $squareGeometricFigureCalculator->getDiagonal();

$trigonometricFunctionCalculatorObjects = [
    new HomeWork\TrigonometricFunctionCalculatorInRadians,
    new HomeWork\TrigonometricFunctionCalculatorInDegrees
];

foreach ($trigonometricFunctionCalculatorObjects as $trigonometricFunctionCalculatorObject) {
    $squareGeometricFigureCalculator = new HomeWork\RhombGeometricFigureCalculator(
        5, 7, $trigonometricFunctionCalculatorObject
    );

    $diagonal = $squareGeometricFigureCalculator->getDiagonal();
}

exit;
