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
use Application\VO\Tachyon;
use Velkuns\Math\_2D\Point2D;
use Velkuns\Math\_2D\Vector2D;
use Velkuns\Math\Matrix;

class PuzzleDay7 extends Puzzle
{
    /**
     * @param list<string> $inputs
     */
    protected function partOne(array $inputs): int
    {
        $data   = \array_map(\str_split(...), $inputs); // Explode line in array of 1 char
        $matrix = (new Matrix($data))->transpose(); // Make matrix with format array[col][row]

        [$countSplits, ] = $this->simulateTimelines($matrix);

        return $countSplits;
    }

    /**
     * @param list<string> $inputs
     */
    protected function partTwo(array $inputs): int
    {
        $data   = \array_map(\str_split(...), $inputs); // Explode line in array of 1 char
        $matrix = (new Matrix($data))->transpose(); // Make matrix with format array[col][row]

        [ , $countTimelines] = $this->simulateTimelines($matrix);

        return $countTimelines;
    }

    /**
     * @return array{0: int, 1: int}
     */
    private function simulateTimelines(Matrix $matrix): array
    {
        $position      = $matrix->locate('S');
        $next          = $position->translate(Vector2D::dir(0, 2)); // Skip current & next empty line

        /** @var \SplQueue<Tachyon> $queue */
        $queue = new \SplQueue();
        $queue->enqueue(new Tachyon($next, 1));

        $visited        = [];
        $timelines      = [];
        $countTimelines = 0;
        $countSplits    = 0;
        while (!$queue->isEmpty()) {
            $tachyon = $queue->dequeue();

            //~ If we reach the end, sum possible timelines
            if ($tachyon->position->getY() > $matrix->getMaxY()) {
                $countTimelines += $tachyon->timelines;
                continue;
            }

            if ($matrix->get($tachyon->position) === '^') {
                //~ Check if we already have a beam that visit the splitter in another timeline, otherwise increase counter
                if (!isset($visited[(string) $tachyon->position])) {
                    $countSplits++;
                    $visited[(string) $tachyon->position] = true;
                }

                //~ Splitter, so split beam
                $left  = $tachyon->position->translate(Vector2D::dir(-1, 2)); // Skip current & next empty line
                $right = $tachyon->position->translate(Vector2D::dir(1, 2));  // Skip current & next empty line

                //~ Create Tachyons for new timelines if not already set
                $timelines[(string) $left]  ??= new Tachyon($left);
                $timelines[(string) $right] ??= new Tachyon($right);

                //~ Then add timelines from previous tachyons to the new split tachyons
                $timelines[(string) $left]->timelines  += $tachyon->timelines;
                $timelines[(string) $right]->timelines += $tachyon->timelines;
            } elseif ($matrix->get($tachyon->position) === '.') {
                //~ No Splitter, so beam continue down
                $down = $tachyon->position->translate(Vector2D::dir(0, 2)); // Skip current & next empty line
                $timelines[(string) $down] ??= new Tachyon($down);

                //~ Then add timelines from previous tachyons to the new split tachyons
                $timelines[(string) $down]->timelines += $tachyon->timelines;
            }

            if (!$queue->isEmpty()) {
                continue;
            }

            //~ We have processed all beams on the current line, so add new split beam tachyons to queue
            if ($timelines !== []) {
                foreach ($timelines as $tachyon) {
                    $queue->enqueue($tachyon);
                }
                $timelines = []; // Reset timelines for the next line
            }
        }

        return [$countSplits, $countTimelines];
    }
}
