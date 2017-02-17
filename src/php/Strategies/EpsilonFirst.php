<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal.severin@gmail.com>
 * @copyright   Copyright (c) 2017, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit\Strategies;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;

/**
 * Class EpsilonFirst
 *
 * Represents the epsilon-first strategy to solve the multi armed bandit problem.
 *
 * From wikipedia (2016-08-13):
 * A pure exploration phase is followed by a pure exploitation phase. For N trials
 * in total, the exploration phase occupies eN trials and the exploitation phase
 * 1-eN trials. During the exploration phase, a lever is randomly selected (with
 * uniform probability); during the exploitation phase, the best lever is always
 * selected.
 *
 * @url     https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies
 * @package Offdev\Bandit\Strategies
 */
class EpsilonFirst extends EpsilonBase
{
    /**
     * Percentage of exploration phase tries
     *
     * @var float
     */
    private $r = 1.0;

    /**
     * EpsilonGreedy constructor.
     *
     * @param float $proportion
     * @param int   $triesExploration
     * @param int   $triesExploitation
     */
    public function __construct(float $proportion, int $triesExploration, int $triesExploitation)
    {
        $total = $triesExploration + $triesExploitation;
        $this->e = $proportion;
        if (!$total) {
            $this->r = 1.0;
        } else {
            $this->r = $triesExploration / $total;
        }
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
        if ($this->r < $this->e) {
            return $this->getRandomLever($machine);
        }

        return $this->getBestLever($machine);
    }
}
