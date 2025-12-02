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

class PuzzleDay2 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        return $this->getResult($inputs[0], $this->hasPatternSimple(...));
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        return $this->getResult($inputs[0], $this->hasPattern(...));
    }

    private function getResult(string $input, callable $hasPattern): int
    {
        $ranges = \explode(',', $input);

        $result = 0;
        foreach ($ranges as $range) {
            [$min, $max] = \explode('-', $range);
            $numbers = \array_filter(\range((int) $min, (int) $max), $hasPattern);
            $result += \array_sum($numbers);
        }

        return $result;
    }

    private function hasPatternSimple(int $content): bool
    {
        $content = (string) $content;
        $length  = \strlen($content);
        $split   = (int) ($length / 2); // For phpstan :P
        if ($split < 1 || $length % 2 !== 0) {
            return false;
        }

        $split = \str_split($content, $split);

        return $split[0] === $split[1];
    }

    private function hasPattern(int $content): bool
    {
        $content = (string) $content;
        $length  = \strlen($content);

        //~ Compute lengths of chunks that can be repeatable in whole string
        $chunkLengths = [1];
        for ($i = 2; $i < $length; ++$i) {
            if ($length % $i === 0) {
                $chunkLengths[] = $i;
            }
        }

        //~ For each chunk length, chunk the content, then sort & compare first & last element. same = pattern
        foreach ($chunkLengths as $chunkLength) {
            $chunks = \str_split($content, $chunkLength);
            \sort($chunks);
            $first = \array_shift($chunks);
            $last  = \array_pop($chunks);
            if ($first === $last) {
                return true;
            }
        }

        return false;
    }
}
