<?php
declare(strict_types=1);

namespace Offdev\Bandit\Math;

/**
 * @codeCoverageIgnore
 */
class MersenneTwister implements RandomNumberGeneratorInterface
{
    public function integer(int $min = 0, int $max = null): int
    {
        return mt_rand($min, $max);
    }

    public function float(float $min = 0, float $max = 1): float
    {
        return $min + ($max - $min) * $this->integer() / mt_getrandmax();
    }
}
