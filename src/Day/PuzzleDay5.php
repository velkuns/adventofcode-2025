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

class PuzzleDay5 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        [$ranges, $values] = $this->getRangesAndValues($inputs);

        $countFresh = 0;
        foreach ($values as $value) {
            foreach ($ranges as $min => $max) {
                //echo "Check of $value in [$min, $max]\n";
                if ($value < $min) {
                    //echo " > Under minimal range on [$min, $max]\n";
                    break;
                }

                if ($value > $max) {
                    //echo " > Skip range on [$min, $max]\n";
                    continue;
                }

                $countFresh++;
                //echo " > Found\n";
                break;
            }
        }

        return $countFresh;
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        [$ranges, $values] = $this->getRangesAndValues($inputs);

        $result = 0;
        foreach ($ranges as $min => $max) {
            $result += ($max - $min) + 1;
        }

        return $result;
    }

    /**
     * @param list<string> $inputs
     * @return array{0: array<int, int>, 1: list<int>}
     */
    private function getRangesAndValues(array $inputs): array
    {
        /** @var array<int, int> $ranges */
        $ranges = [];
        $values = [];

        foreach ($inputs as $input) {
            if (\str_contains($input, '-')) {
                [$min, $max]  = \array_map(intval(...), \explode('-', $input, 2));
                $ranges[$min] = \max($ranges[$min] ?? 0, $max); // if range with same min already exists, keep max "max"
            } elseif ($input === '') {
                continue;
            } else {
                $values[] = (int) $input;
            }
        }

        ksort($ranges);

        /** @var array<int, int> $mergedRanges */
        $mergedRanges = [];
        $lastMax = 0;
        $lastMin = 0;

        foreach ($ranges as $min => $max) {
            //~ Handle overlap or range inclusion
            if ($min <= $lastMax + 1) {
                $mergedRanges[$lastMin] = \max($mergedRanges[$lastMin], $max);
                $lastMax = $mergedRanges[$lastMin];
                continue;
            }

            //~ New range, so add to merged ranges
            $mergedRanges[$min] = $max;

            //~ Keep previous range info
            $lastMin            = $min;
            $lastMax            = $max;
        }

        return [$mergedRanges, $values];
    }
}
