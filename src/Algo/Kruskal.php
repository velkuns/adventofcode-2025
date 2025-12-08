<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Algo;

class Kruskal
{
    /** @var int[] */
    private array $set = [];

    /**
     * @param array<int, mixed> $data
     */
    public function init(array $data): void
    {
        $this->set = \array_combine(\array_keys($data), \array_keys($data));
    }

    public function find(int $v): int
    {
        if ($this->set[$v] === $v) {
            return $v;
        }

        return $this->set[$v] = $this->find($this->set[$v]);
    }

    public function union(int $v1, int $v2): void
    {
        $this->set[$this->find($v1)] = $this->find($v2);
    }
}
