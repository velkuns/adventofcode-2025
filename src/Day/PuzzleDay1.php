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

class PuzzleDay1 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        $countOnZero = 0;
        $position    = 50;

        foreach ($inputs as $input) {
            $direction = \substr($input, 0, 1);
            $rotation  = ((int) \substr($input, 1)) % 100;

            $position = match ($direction) {
                'L'     => $rotation > $position ? 100 - ($rotation - $position) : $position - $rotation,
                'R'     => ($rotation + $position) % 100,
                default => 0,
            };

            if ($position === 0) {
                $countOnZero++;
            }
        }

        return $countOnZero;
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        $countOnZero = 0;
        $position    = 50;

        foreach ($inputs as $input) {
            $direction = \substr($input, 0, 1);
            $rotation  = (int) \substr($input, 1);

            if ($rotation > 100) {
                $countOnZero += (int) ($rotation / 100); // auto count complete turns
                $rotation = $rotation % 100;
            }

            $countOnZero += match ($direction) {
                'L' => $position !== 0 && $rotation > $position ? 1 : 0,
                'R' => $position !== 0 && $rotation + $position > 100 ? 1 : 0,
                default => 0,
            };

            $newPosition = match ($direction) {
                'L'     => $rotation > $position ? 100 - ($rotation - $position) : $position - $rotation,
                'R'     => ($rotation + $position) % 100,
                default => 0,
            };

            if ($newPosition === 0) {
                $countOnZero++;
            }

            //            if ($direction === 'L' && $position !== 0 && $rotation > $position) {
            //                echo "The dial is rotated $input to point at $newPosition; during this rotation, it points at 0 once.\n";
            //            } elseif ($direction === 'R' && $position !== 0 && $rotation + $position > 100) {
            //                echo "The dial is rotated $input to point at $newPosition; during this rotation, it points at 0 once.\n";
            //            } else {
            //                echo "The dial is rotated $input to point at $newPosition.\n";
            //            }

            $position = $newPosition;
        }

        return $countOnZero;
    }
}
