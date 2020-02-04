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

/**
 * Represents the epsilon-greedy strategy to solve the multi armed bandit problem.
 *
 * From wikipedia (2016-08-13):
 * The best lever is selected for a proportion 1-e of the trials, and a lever is selected at
 * random (with uniform probability) for a proportion e. A typical parameter value might
 * be e=0.1, but this can vary widely depending on circumstances and predilections.
 *
 * @url https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies
 */
class EpsilonGreedy extends EpsilonBase
{
    public function __construct(float $uniformProbability)
    {
        if ($uniformProbability < 0.0) {
            throw new RuntimeException('Probability must be greater than or equal to 0!');
        }

        if ($uniformProbability > 1.0) {
            throw new RuntimeException('Probability must be less than or equal to 1!');
        }

        $this->e = $uniformProbability;
    }

    public function solve(Machine $machine): Lever
    {
        $r = rand(0, 100) / 100;
        if ($r <= $this->e) {
            return $this->getRandomLever($machine);
        }

        return $this->getBestLever($machine);
    }
}
