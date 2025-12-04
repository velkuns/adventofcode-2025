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
use Velkuns\Math\_2D\Vector2D;
use Velkuns\Math\Matrix;

class PuzzleDay4 extends Puzzle
{
    private const array DIRECTIONS = [
        'UL' => [-1, -1],
        'U'  => [0, -1],
        'UR' => [1, -1],
        'L'  => [-1, 0],
        'R'  => [1, 0],
        'DL' => [-1, 1],
        'D'  => [0, 1],
        'DR' => [1, 1],
    ];

    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        $data = \array_map(\str_split(...), $inputs);

        $matrix = (new Matrix($data))->transpose();

        return $this->removeRolls($matrix, false);
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        $data = \array_map(\str_split(...), $inputs);

        $matrix = (new Matrix($data))->transpose();

        $result = 0;
        do {
            $count = $this->removeRolls($matrix, true);
            $result += $count;
        } while ($count > 0);

        return $result;
    }

    private function removeRolls(Matrix $matrix, bool $replace): int
    {
        $count = 0;
        for ($y = 0; $y < $matrix->height(); $y++) {
            for ($x = 0; $x < $matrix->width(); $x++) {
                $position = new Point2D($x, $y);
                if (!$this->canBeAccessed($matrix, $position, 4)) {
                    continue;
                }

                $count++;
                if ($replace) {
                    $matrix->set($position, '.');
                }
            }
        }

        return $count;
    }

    private function canBeAccessed(Matrix $matrix, Point2D $center, int $limit): bool
    {
        if ($matrix->get($center) !== '@') {
            return false;
        }

        $count = 0;
        foreach (self::DIRECTIONS as [$x, $y]) {
            $data   = $matrix->get($center->translate(Vector2D::dir($x, $y)));
            $count += $data === '@' ? 1 : 0;
        }

        return $count < $limit;
    }
}
