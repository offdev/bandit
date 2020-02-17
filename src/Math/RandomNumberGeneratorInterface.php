<?php
declare(strict_types=1);

namespace Offdev\Bandit\Math;

interface RandomNumberGeneratorInterface
{
    public function integer(int $min = 0, ?int $max = null): int;

    public function float(float $min = 0, float $max = 1): float;
}
