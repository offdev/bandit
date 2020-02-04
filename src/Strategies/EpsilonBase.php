<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal@offdev.net>
 * @copyright   Copyright (c) 2020, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit\Strategies;

use Offdev\Bandit\Exceptions\RuntimeException;
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\StrategyInterface;

abstract class EpsilonBase implements StrategyInterface
{
    protected float $e = 0.1;

    protected function getBestLever(Machine $machine): Lever
    {
        $list = $machine->getLeverList();
        if (empty($list)) {
            throw new RuntimeException("No lever in machine!");
        }

        $bestLever = reset($list);
        $bestConversion = $this->getConversion($bestLever);
        foreach ($list as $lever) {
            $c = $this->getConversion($lever);
            if ($c > $bestConversion) {
                $bestConversion = $c;
                $bestLever = $lever;
            }
        }

        return $bestLever;
    }

    protected function getRandomLever(Machine $machine): Lever
    {
        $list = $machine->getLeverList();
        if (empty($list)) {
            throw new RuntimeException("No lever in machine!");
        }
        $k = array_rand($list);

        return $list[$k];
    }

    protected function getConversion(Lever $lever): float
    {
        if ($lever->getTries() === 0) {
            return 1.0;
        }

        return $lever->getRewards() / $lever->getTries();
    }
}
