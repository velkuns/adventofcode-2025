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

class PuzzleDay6 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        /** @var list<string> $data */
        $data      = \array_map(fn(string $input) => \preg_split('# +#', \trim($input)), $inputs);
        /** @var list<string> $operators */
        $operators = \array_pop($data);

        $problems = [];
        for ($col = 0; $col < \count($operators); $col++) {
            for ($row = 0; $row < \count($data); $row++) {
                $problems[$col][] = (int) $data[$row][$col];
            }
        }

        return $this->compute($problems, $operators);
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        /** @var list<string> $operators */
        $operators = \preg_split('# +#', (string) \array_pop($inputs));
        /** @var list<string> $inputs */
        $maxLen    = \max(\array_map(\strlen(...), $inputs));
        $lines     = \count($inputs);
        $separator = \str_repeat(' ', $lines);

        $problems  = [];
        $problemNumber = 0;
        for ($pos = 0; $pos < $maxLen; $pos++) {
            $value = '';
            for ($row = 0; $row < $lines; $row++) {
                $value .= $inputs[$row][$pos] ?? '';
            }

            if ($value === $separator) {
                $problemNumber++;
                continue;
            }
            $problems[$problemNumber][] = (int) \trim($value);
        }

        return $this->compute($problems, $operators);
    }

    /**
     * @param array<int, list<int>> $problems
     * @param list<string> $operators
     */
    private function compute(array $problems, array $operators): int
    {
        $mul = fn(?int $carry, int $val) => ($carry ?? 1) * $val;
        $add = fn(?int $carry, int $val) => ($carry ?? 0) + $val;
        $operators = \array_map(fn(string $op) => $op === '*' ? $mul : $add, $operators);

        $total = 0;
        foreach ($problems as $col => $values) {
            $result = \array_reduce($values, $operators[$col]);
            $total += $result;
        }

        return $total;
    }
}
