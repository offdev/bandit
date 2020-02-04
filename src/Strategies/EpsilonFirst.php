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
 * Represents the epsilon-first strategy to solve the multi armed bandit problem.
 *
 * From wikipedia (2016-08-13):
 * A pure exploration phase is followed by a pure exploitation phase. For N trials
 * in total, the exploration phase occupies eN trials and the exploitation phase
 * 1-eN trials. During the exploration phase, a lever is randomly selected (with
 * uniform probability); during the exploitation phase, the best lever is always
 * selected.
 *
 * @url https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies
 */
class EpsilonFirst extends EpsilonBase
{
    private float $r = 1.0;

    public function __construct(float $proportion, int $triesExploration, int $triesExploitation)
    {
        if ($triesExploration < 0) {
            throw new RuntimeException('Amount of tries (exploration phase) must be greater than 0!');
        }

        if ($triesExploitation < 0) {
            throw new RuntimeException('Amount of tries (exploitation phase) must be greater than 0!');
        }

        if ($proportion < 0.0) {
            throw new RuntimeException('Proportion must be greater than or equal to 0!');
        }

        if ($proportion > 1.0) {
            throw new RuntimeException('Proportion must be less than or equal to 1!');
        }

        $total = $triesExploration + $triesExploitation;
        $this->e = $proportion;
        if ($total === 0) {
            $this->r = 1.0;
        } else {
            $this->r = $triesExploration / $total;
        }
    }

    public function solve(Machine $machine): Lever
    {
        if ($this->r < $this->e) {
            return $this->getRandomLever($machine);
        }

        return $this->getBestLever($machine);
    }
}
