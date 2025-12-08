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
use Application\Algo\Kruskal;
use Velkuns\Math\_3D\Point3D;
use Velkuns\Math\_3D\Vector3D;

class PuzzleDay8 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        /** @var list<Point3D> $points */
        $points      = \array_map($this->inputToPoint3D(...), $inputs);
        $countPoints = \count($points);
        $distances   = $this->getDistances($points);
        $limit       = \count($distances) === 190 ? 10 : 1000; // Examples have 190 vectors, otherwise it the puzzle input

        $kruskal = new Kruskal();
        $kruskal->init($points);

        for ($i = 0; $i < $limit; $i++) {
            /**
             * @var int $p1 Point3D index of vector::origin, to be used with Kruskal's algo
             * @var int $p2 Point3D index of vector::destination, to be used with Kruskal's algo
             */
            [, $p1, $p2] = $distances->extract();

            if ($kruskal->find($p1) !==  $kruskal->find($p2)) {
                //~ Apply Kruskal algo: different parent, so connect to points
                $kruskal->union($p1, $p2);
            }
        }

        //~ Build circuits with number of junctions box in it
        $circuits = [];
        for ($p = 0; $p < $countPoints; $p++) {
            $root = $kruskal->find($p);
            $circuits[$root] ??= 0;
            $circuits[$root]++;
        }
        \sort($circuits);
        return (int) \array_product(\array_slice($circuits, -3));
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        /** @var list<Point3D> $points */
        $points      = \array_map($this->inputToPoint3D(...), $inputs);
        $countPoints = \count($points);
        $distances   = $this->getDistances($points);

        $kruskal = new Kruskal();
        $kruskal->init($points);

        $connections = 0;
        while ($distances->valid()) {
            /**
             * @var int $p1 Point3D index of vector::origin, to be used with Kruskal's algo
             * @var int $p2 Point3D index of vector::destination, to be used with Kruskal's algo
             */
            [, $p1, $p2] = $distances->extract();

            if ($kruskal->find($p1) !==  $kruskal->find($p2)) {
                //~ Apply Kruskal algo: different parent, so connect to points
                $connections++;

                //~ If all points are connected
                if ($connections === $countPoints - 1) {
                    return $points[$p1]->getX() * $points[$p2]->getX();
                }

                //~ Apply union of points
                $kruskal->union($p1, $p2);
            }
        }

        return 0;
    }

    /**
     * @param Point3D[] $points
     * @return \SplMinHeap<array{0: float, 1: int, 2: int}>
     */
    private function getDistances(array $points): \SplMinHeap
    {
        $time = -microtime(true);

        /** @var \SplMinHeap<array{0: float, 1: int, 2: int}> $distances */
        $distances   = new \SplMinHeap();
        $countPoints = \count($points);
        for ($p1 = 0; $p1 < $countPoints; ++$p1) {
            for ($p2 = $p1 + 1; $p2 < $countPoints; ++$p2) {
                $vector = new Vector3D($points[$p1], $points[$p2], false);
                $distances->insert([$vector->size(), $p1, $p2]);
            }
        }

        echo "Time to build MinHeap: " . \round(microtime(true) + $time, 3) . "s\n";

        return $distances;
    }

    private function inputToPoint3D(string $input): Point3D
    {
        [$x, $y, $z] = \explode(',', $input);

        return new Point3D((int) $x, (int) $y, (int) $z);
    }
}
