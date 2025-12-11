<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Day;

use Application\Puzzle;
use Velkuns\Math\_2D\Point2D;

class PuzzleDay9 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        $points = \array_map($this->inputToPoint2D(...), $inputs);

        $maxArea = 0;
        for ($p1 = 0, $countPoints = \count($points); $p1 < $countPoints; ++$p1) {
            for ($p2 = $p1 + 1; $p2 < $countPoints; ++$p2) {
                $with   = \abs($points[$p2]->getX() - $points[$p1]->getX()) + 1;
                $height = \abs($points[$p2]->getY() - $points[$p1]->getY()) + 1;
                $area =  $with * $height;
                if ($area > $maxArea) {
                    $maxArea = $area;
                }
            }
        }

        return $maxArea;
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        $points = \array_map($this->inputToPoint2D(...), $inputs);
        return 0;
    }

    private function inputToPoint2D(string $input): Point2D
    {
        [$x, $y] = \explode(',', $input);

        return new Point2D((int) $x, (int) $y);
    }
}
