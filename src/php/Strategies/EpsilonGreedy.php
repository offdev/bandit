<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal.severin@gmail.com>
 * @copyright   Copyright (c) 2016, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit\Strategies;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;

/**
 * Class EpsilonGreedy
 *
 * Represents the epsilon-greedy strategy to solve the multi armed bandit problem.
 *
 * From wikipedia (2016-08-13):
 * The best lever is selected for a proportion 1-e of the trials, and a lever is selected at
 * random (with uniform probability) for a proportion e. A typical parameter value might
 * be e=0.1, but this can vary widely depending on circumstances and predilections.
 *
 * @url     https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies
 * @package Offdev\Bandit\Strategies
 */
class EpsilonGreedy extends EpsilonBase
{
    /**
     * EpsilonGreedy constructor.
     *
     * @param float $uniformProbability
     */
    public function __construct(float $uniformProbability)
    {
        $this->e = $uniformProbability;
    }

    /**
     * Solves the puzzle :)
     *
     * @param Machine $machine
     *
     * @return Lever
     */
    public function solve(Machine $machine): Lever
    {
        $r = rand(0, 100) / 100;
        if ($r <= $this->e) {
            return $this->getRandomLever($machine);
        }

        return $this->getBestLever($machine);
    }
}
