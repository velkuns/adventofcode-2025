<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\VO;

use Velkuns\Math\_2D\Point2D;

class Tachyon
{
    public function __construct(public Point2D $position, public int $timelines = 0) {}
}
