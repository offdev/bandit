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
use Offdev\Bandit\Math\RandomNumberGeneratorInterface;
use Offdev\Bandit\StrategyInterface;

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
class EpsilonGreedy implements StrategyInterface
{
    private float $e;

    private RandomNumberGeneratorInterface $rng;

    public function __construct(RandomNumberGeneratorInterface $rng, float $uniformProbability = 0.1)
    {
        if ($uniformProbability < 0.0) {
            throw new RuntimeException('Probability must be greater than or equal to 0!');
        }

        if ($uniformProbability > 1.0) {
            throw new RuntimeException('Probability must be less than or equal to 1!');
        }

        $this->e = $uniformProbability;
        $this->rng = $rng;
    }

    public function solve(Machine $machine): Lever
    {
        $r = $this->rng->float();
        if ($r <= $this->e) {
            return $machine->getRandomLever();
        }

        return $machine->getBestLever();
    }
}
