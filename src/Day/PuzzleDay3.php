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

class PuzzleDay3 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        $jolts = 0;
        foreach ($inputs as $bank) {
            $jolts += $this->getHighJoltFromBank2($bank, 2);
        }

        return $jolts;
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        $jolts = 0;
        foreach ($inputs as $bank) {
            $jolts += $this->getHighJoltFromBank2($bank, 12);
        }

        return $jolts;
    }

    private function getHighJoltFromBank2(string $bank, int $length): int
    {
        $offset     = 0;
        $limit      = 1 - $length;
        $jolts      = '';
        $bankLength = \strlen($bank);

        while (\strlen($jolts) < $length) {
            $remainingLength = $bankLength - $offset;
            $missingLength   = $length - \strlen($jolts);

            if ($remainingLength > $missingLength) {
                // Prepare next string where search
                $bankLeft = \substr($bank, $offset, $limit === 0 ? null : $limit);

                // Get next battery with sub-offset + 1
                [$subOffset, $number] = $this->getNextBatteryWithPosition($bankLeft);

                $jolts  .= $number;    // Add found number to jolt
                $offset += $subOffset; // Increase global offset with sub-offset + 1
                $limit++;              // Increase limit of 1 char
            } else {
                $jolts .= \substr($bank, $offset); // Cannot search for more, so get full remaining batteries
            }
        }

        return (int) $jolts;
    }

    /**
     * @return array{0: int|null, 1: int|null}
     */
    private function getNextBatteryWithPosition(string $bankLeft, int $length = 2): array
    {
        for ($i = 9; $i >= 0; $i--) {
            $position = \strpos($bankLeft, (string) $i);
            if ($position !== false) {
                return [$position + 1, $i];
            }
        }

        return [null, null];
    }
}
